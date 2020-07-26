<?php namespace App\Controllers;

use CodeIgniter\Controller;


class Usuario extends BaseController
{
    public function form_registro(){
        // helper(['form', 'url']);
        $errores = $this->session->getFlashdata();
        return view('form_registro',[
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator]);
    }

    public function form_sesion(){
        $errores = $this->session->getFlashdata();
        return view('form_sesion',[
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator]);
    }

    public function registrar_cuenta(){
        helper(['form', 'url']);
        
        $rules = [
                'usuario_nombre' => 'required|max_length[100]',
                'usuario_email'  => 'required|valid_email|is_unique[usuarios.usuario_email]|max_length[255]',
                'usuario_telefono'=> 'required|max_length[25]',     
                'usuario_password' => 'required|min_length[6]',
                'g-recaptcha-response'=>'required|validateRecaptcha'
            ];
        $mensajes = [
            'usuario_nombre'=>[
                'required'=>'El campo Nombre es requerido',
                'max_length'=>'El campo Nombre puede tener un max de {param} caracteres'
                //@todo agregar las demas etiquetas para registro
            ]
        ];

        if(! $this->validate($rules,$mensajes))
        {
            return  view('form_registro', [
                'validation' => $this->validator,
                'session'=>$this->session,
            ]);
        }
        else
        {
            $modelUsuarios = new \App\Models\UsuarioModel();
            // $modelUsuarios = model('App\Models\UsuarioModel', false);
            $data = [
                'usuario_nombre' => $this->request->getPost('usuario_nombre'),
                'usuario_telefono' => $this->request->getPost('usuario_telefono'),
                'usuario_email'    => $this->request->getPost('usuario_email'),
                'usuario_hash_recuperacion'=> md5(microtime().$this->request->getPost('usuario_email')),
                'usuario_password' => md5(env('salt').$this->request->getPost('usuario_password'))
            ];
            $success = $modelUsuarios->insert($data);

            if($success){
                //enviar mail de activacion
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

                $email->setFrom('noresponder@mascotasperdidas.org', 'No Responder');
                $email->setTo($this->request->getPost('usuario_email'));
                // $email->setCC('another@another-example.com');
                // $email->setBCC('them@their-example.com');

                $email->setSubject('Mascotas Perdidas - Activación de cuenta');

                $mensaje = "<p>Hola ".$data['usuario_nombre'].", <br/>
tu cuenta en Mascotas Perdidas Py se ha creado, para activarla debes visitar el siguiente link:<br/>
<a href='".base_url('activacion_cuenta?a='.md5(env('salt').$data['usuario_email']))."&b=".$data['usuario_hash_recuperacion']."'>Enlace de activación</a><br/>
<br/>
Gracias por unirte a una noble causa!</p>
<p>El equipo de Mascotas Perdidas Py</p>";

                $email->setMessage($mensaje);

                $email->send();
#                echo $email->printDebugger();
            }
            
            return  view('form_registro', [
                'validation' => $this->validator,
                'session'=>$this->session,
                'success'=>$success
            ]);
        }
    }

    public function activacion_cuenta(){
        $hash_recuperacion = $this->request->getGet('b');
        $salted_email_account = $this->request->getGet('a');

        $db = \Config\Database::connect();
        $result = $db->table('usuarios')
                    ->where("md5( concat('".env('salt')."',usuario_email)) = ".$db->escape($salted_email_account)." and usuario_hash_recuperacion = ".$db->escape($hash_recuperacion)." and usuario_estado  = 'Pendiente'")
                    ->get()->getResult();
        // print_r($result->getResult());die();
        if(count($result) > 0){
            $result_query = $db->table('usuarios')
                ->set('usuario_estado','Activo')
                ->set('usuario_fecha_activacion',date('Y-m-d H:i:s'))
                ->where("md5( concat('".env('salt')."',usuario_email)) = ".$db->escape($salted_email_account)." and usuario_hash_recuperacion = ".$db->escape($hash_recuperacion)." and usuario_estado  = 'Pendiente'")
                ->update();
            //@TODO cuenta activada al login
        }else{
            //@todo error al login
        }
    }

    public function iniciar_sesion(){
        helper(['form', 'url']);
        $email = $this->request->getPost('usuario_email');
        $password = $this->request->getPost('usuario_password');
        $rules = [
                'usuario_email'  => 'required',
                'usuario_password' => 'required',
                'g-recaptcha-response'=>'required|validateRecaptcha'
            ];
        $mensajes = [
            'usuario_nombre'=>[
                'required'=>'El campo Nombre es requerido'
            ],
            'usuario_password'=>[
                'required'=>'El campo Nombre es requerido'
            ]
        ];

        if(! $this->validate($rules,$mensajes))
        {
            return  view('form_sesion', [
                'validation' => $this->validator,
                'session'=>$this->session,
            ]);
        }
        else
        {
            $modelUsuarios = new \App\Models\UsuarioModel();
            $result = $modelUsuarios->where('usuario_email',$email)->where('usuario_password',md5(env('salt').$password))->get()->getResult();
            if(count($result)>0){
                $this->session->set('sesion_iniciada',true);
                $this->session->set('usuario',$result[0]);
                return redirect()->to('/cuenta');
            }else{
                $this->session->setFlashData('error','Credenciales Invalidas');
                return redirect()->to('/sesion');
            }
        }
    }

    public function cerrar_sesion(){
        session_destroy();
        return redirect()->to('/inicio');
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function mis_mensajes(){
        return view('dashboard_mensajes');   
    }

    public function mis_reportes(){
        return view('dashboard_reportes');
    }

    public function nuevo_reporte(){
        // return view('dashboard_form_reporte');

        $errores = $this->session->getFlashdata();
        return view('dashboard_form_reporte',[
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator]);
    }
}