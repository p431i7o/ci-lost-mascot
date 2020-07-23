<?php namespace App\Controllers;

use CodeIgniter\Controller;


class Inicio extends BaseController
{
    public function index()
    {
        return view('Inicio');
    }

    public function form_registro(){
        $errores = $this->session->getFlashdata();
        return view('form_registro',['errores'=>$errores,'session'=>$this->session]);
    }

    public function registrar_cuenta(){
        
    }

    public function legal(){
        return view('legal');
    }
}