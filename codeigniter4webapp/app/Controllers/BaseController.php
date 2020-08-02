<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->request = $request;
        $this->db = \Config\Database::connect();
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}

    public function estaConSesionAbierta(){
        //var_dump(empty($this->session->get('session_iniciada')));die();
        if(!empty($this->session->get('sesion_iniciada')) ){
            return true;
        }
        return false;
    }

    public function getIdUsuarioActual(){
        return $this->session->get('usuario')->id_usuario;
    }

    /**
     * Enviar email
     * @param  array/string  $destinatarios Arreglo de destinatarios, puede ser un string tambien
     * @param  string $asunto        Asunto del email
     * @param  array  $remitente     Remitente del email
     * @param  string $mensaje       String que contiene el mensaje
     * @param  array  $adjuntos      Si hay adjuntos, van aca
     * @return boolean               True si se pudo enviar, false de lo contrario
     */
    public function enviarEmail($destinatarios=array(),
                                $asunto="",
                                $remitente=array("email"=>"no-responder@mascotasperdidaspy.org","nombre"=>"No Responder"),
                                $mensaje="",
                                $adjuntos=array()){
        //@todo trabajar sobre adjuntos
        if(!is_array($destinatarios)){
            $destinatarios = [$destinatarios];
        }
        $config = Array(
          'protocol' => env('EMAIL_PROTOCOL'),
          'SMTPHost' => env('EMAIL_HOST'),
          'SMTPPort' => env('EMAIL_PORT'),
          'SMTPUser' => env('EMAIL_USER'),
          'SMTPCrypto'=>env('EMAIL_CRYPTO'),
          'SMTPPass' => env('EMAIL_PASS'),
          'CRLF' => "\r\n",
          'newline' => "\r\n",
          'mailType'=>env('EMAIL_MAILTYPE')
        );
        $email = \Config\Services::email($config);

        $email->setFrom($remitente['email'], $remitente['nombre']);
        foreach($destinatarios as $destinatario){
            $email->setTo($destinatario);    
        }        
        // $email->setCC('another@another-example.com');
        // $email->setBCC('them@their-example.com');

        $email->setSubject($asunto);
        $email->setMessage($mensaje);

        return $email->send();
#       echo $email->printDebugger();
    }

}
