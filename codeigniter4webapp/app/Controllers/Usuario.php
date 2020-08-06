<?php namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * 
 */
class Usuario extends BaseController
{
    /**
     * [form_registro description]
     * @return [type] [description]
     */
    public function form_registro(){
        // helper(['form', 'url']);
        $errores = $this->session->getFlashdata();
        return view('form_registro',[
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator]);
    }

    /**
     * [form_recuperar_cuenta description]
     * @return [type] [description]
     */
    public function form_recuperar_cuenta(){
        $errores = $this->session->getFlashdata();
        return view('form_recuperar_cuenta',[
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator]);
    }


    /**
     * [recuperar_cuenta_paso2 description]
     * @return [type] [description]
     */
    public function recuperar_cuenta_paso2(){
        helper(['form', 'url']);

        $rules = [
            'usuario_email'  => 'required|valid_email|max_length[255]',
            'g-recaptcha-response'=>'required|validateRecaptcha'
        ];
        $mensajes = [
            'usuario_email'=>[
                'required'=>'El campo email es requerido',
                'max_length'=>'El campo email puede tener un max de {param} caracteres',
                'valid_email'=>'El campo email no tiene un formato de email'
                //@todo agregar las demas etiquetas para registro
            ]
        ];

        if(! $this->validate($rules,$mensajes))
        {
            return  view('form_recuperar_cuenta', [
                'validation' => $this->validator,
                'session'=>$this->session,
            ]);
        }else{
            $modelUsuarios = new \App\Models\UsuarioModel();

            $email_usuario = $this->request->getPost('usuario_email');
            //buscar la cuenta
            $query =  $modelUsuarios->where('usuario_email',$email_usuario )->get()->getResult();
            //enviar el mail con el hash de activacion
            if(count($query)>0){
                $db = \Config\Database::connect();
                $nuevo_hash_recuperacion = md5(env('salt').microtime().$email_usuario);
                $db->table('usuarios')
                    ->where('id_usuario',$query[0]->id_usuario)
                    ->set('usuario_hash_recuperacion',$nuevo_hash_recuperacion)
                    ->update();

                $mensaje = "Hola!<br/>Hemos recibido un pedido de recuperación de cuenta, para ello debes visitar el siguiente enlace<br/>";
                $mensaje .= "<a href='".base_url('cambio_contrasenha/'.md5(env('salt').strtolower( $email_usuario) ).'/'.$nuevo_hash_recuperacion);
                $mensaje .= "'>Enlace de recuperacion</a>.<br/>";
                $mensaje .= "Si no lo has solicitado, no te preocupes, que no se ha cambiado tu contraseña.<br/><br/>";
                $mensaje .= "Saludos del equipo de Mascotas Perdidas Py.";

                $this->enviarEmail(
                        $email_usuario,
                        'Mascotas Perdidas Py - Recuperación de Cuenta',
                        array('nombre'=>env('email_noresponder_nombre'),'email'=>env('email_noresponder') ),
                        $mensaje);
            }
            //sino existe igual mostrar mensaje
            $this->session->setFlashData('mensaje','Si la cuenta existe el mail para cambio de contraseña ha sido enviado');
            return redirect()->to('/Inicio');
            //redirigir al inicio avisando que se envio al mail indicado
        }

        return view('form_recuperar_cuenta',[
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator]);
    }

    public function recuperar_cuenta_paso3($email_hasheado,$hash_recuperacion){
        // print_r([$email_hasheado,$hash_recuperacion]);

        $db = \Config\Database::connect();
        $result = $db->table('usuarios')
                    ->where("md5( concat('".env('salt')."',usuario_email)) = ".$db->escape($email_hasheado)
                        ." and usuario_hash_recuperacion = ".$db->escape($hash_recuperacion))
                    ->get()
                    ->getResult();
        // print_r($result->getResult());die();
        if(count($result) > 0){
            $parametrosVista = ['email_hasheado'=>$email_hasheado,'hash_recuperacion'=>$hash_recuperacion,'session'=>$this->session,
            'validation' => $this->validator];
            // if($this->session->getFlashdata('validator')){
            //     $this->validator->setError('password')
            // }
            return view('form_cambio_contrasenha',$parametrosVista);
        }else{
            $this->session->setFlashData('mensaje','Datos de recuperación de cuenta inválidos');
            $this->session->setFlashData('error',true);
            return redirect()->to('/Inicio');
        }
    }

    public function recuperar_cuenta_paso4(){
         helper(['form', 'url']);
         $rules = [ 
            'usuario_password' => 'required|min_length[6]',
            'usuario_password2' => 'required|min_length[6]|matches[usuario_password]',
            'email_hasheado'=>'required',
            'hash_recuperacion'=>'required',
            'g-recaptcha-response'=>'required|validateRecaptcha'
        ];

        $mensajes = [
            'usuario_password'=>[
                'required'=>'El campo Contraseña es requerido',
                'min_length'=>'El campo Contraseña debe tener un mínimo de {param} caracteres'
            ],
            'usuario_password2'=>[
                'required'=>'El campo Repetir Contraseña es requerido',
                'min_length'=>'El campo Repetir Contraseña debe tener un mínimo de {param} caracteres',
                'matches'=>'El campo Repetir Contraseña debe coincidir'
            ]
        ];

        if(! $this->validate($rules,$mensajes))
        {
            return  redirect()->back()->with('error',$this->validator->getErrors());
        }else{
            $db = \Config\Database::connect();
            $result = $db->table('usuarios')
                        ->where("md5( concat('".env('salt')."',usuario_email)) = ".$db->escape($this->request->getPost('email_hasheado'))
                            ." and usuario_hash_recuperacion = ".$db->escape($this->request->getPost('hash_recuperacion')))
                        ->set('usuario_password',md5(env('salt').$this->request->getPost('usuario_password')))
                        ->set('usuario_hash_recuperacion',md5(env('salt'.microtime() ) ))
                        ->update();
            $this->session->setFlashData('mensaje','Cambio de contraseña correcto!');
            return redirect()->to('/Inicio');
        }

    }

    /**
     * [form_sesion description]
     * @return [type] [description]
     */
    public function form_sesion(){
        $errores = $this->session->getFlashdata();
        return view('form_sesion',[
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator]);
    }
    /**
     * [registrar_cuenta description]
     * @return [type] [description]
     */
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
                'usuario_hash_recuperacion'=> md5(env('salt').microtime().$this->request->getPost('usuario_email')),
                'usuario_password' => md5(env('salt').$this->request->getPost('usuario_password'))
            ];
            $success = $modelUsuarios->insert($data);

            if($success){
                //enviar mail de activacion
                $mensaje = "<p>Hola ".$data['usuario_nombre'].", <br/>
tu cuenta en Mascotas Perdidas Py se ha creado, para activarla debes visitar el siguiente link:<br/>
<a href='".base_url('activacion_cuenta?a='.md5(env('salt'). strtolower( $data['usuario_email'] ) ))."&b=".$data['usuario_hash_recuperacion']."'>Enlace de activación</a><br/>
<br/>
Gracias por unirte a una noble causa!</p>
<p>El equipo de Mascotas Perdidas Py</p>";
                $this->enviarEmail($this->request->getPost('usuario_email'),'Mascotas Perdidas Py - Activación de cuenta',
                                    array('email'=>env('email_noresponder'), 'nombre'=>env('email_noresponder_nombre')),
                                    $mensaje);

                
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
                'required'=>'El campo Contraseña es requerido'
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
        if(!$this->estaConSesionAbierta()){
            return redirect()->to('/inicio'); 
        }
        return view('dashboard');
    }

    public function mis_mensajes(){
        if(!$this->estaConSesionAbierta()){
            return redirect()->to('/inicio'); 
        }
        return view('dashboard_mensajes');   
    }

    

    

    private function revisarSesion(){
        if(!$this->estaConSesionAbierta()){
            return redirect()->to('/inicio'); 
        }
    }

}