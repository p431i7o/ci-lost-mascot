<?php namespace App\Controllers;

use CodeIgniter\Controller;


class Reporte extends BaseController
{


    public function nuevo_reporte(){
        if(!$this->estaConSesionAbierta()){
            return redirect()->to('/inicio'); 
        }
        $errores = $this->session->getFlashdata();
        $tipos_animales = new \App\Models\TiposAnimalesModel();

        return view('dashboard_form_reporte',[
            'tipos_animales'=>$tipos_animales->findAll(),
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator]);
    }

    public function registrar_reporte(){
        $errores = $this->session->getFlashdata();

        helper(['form', 'url']);

        $rules = ['tipo_reporte'=>'required',
                  'id_tipo_animal'=>'required',
                  'reporte_descripcion'=>'required',
                  'reporte_fecha'=>'required',
                  'reporte_mascota_nombre'=>'',
                  'latitud'=>'required',
                  'longitud'=>'required',
                  'reporte_direccion'=>''];

        $mensajes = [
            'usuario_nombre'=>[
                'required'=>'El campo Nombre es requerido',
                'max_length'=>'El campo Nombre puede tener un max de {param} caracteres'
                //@todo agregar las demas etiquetas para registro
            ]
        ];

        $success = false;

        if($this->validate($rules,$mensajes)){

        }


        $tipos_animales = new \App\Models\TiposAnimalesModel();

        return view('dashboard_form_reporte',[
            'tipos_animales'=>$tipos_animales->findAll(),
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator,
            'success'=>$success]);
    }
}