<?php namespace App\Controllers;

use CodeIgniter\Controller;


class Inicio extends BaseController
{
    public function index()
    {
        return view('Inicio');
    }

    public function form_registro(){
        // helper(['form', 'url']);
        $errores = $this->session->getFlashdata();
        return view('form_registro',[
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
                'usuario_password' => 'required|min_length[6]'
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
            
            echo view('Success');
        }
    }

    public function legal(){
        return view('legal');
    }
}