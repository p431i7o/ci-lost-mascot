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
        $tipos_animales = new \App\Models\TiposAnimalesModel();
        
        return view('dashboard_form_reporte',[
            'tipos_animales'=>$tipos_animales->findAll(),
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator,
            'success'=>true]);
    }
}