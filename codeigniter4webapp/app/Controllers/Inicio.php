<?php namespace App\Controllers;

use CodeIgniter\Controller;


class Inicio extends BaseController
{
    public function index()
    {
        $modelReporte = new \App\Models\ReporteModel();
        $query_reporte = $modelReporte->getReportes(10,0);

        $reportes = $query_reporte->getResult();

        foreach($reportes as $index=> $fila){
            $reportes[$index]->imagenes_reporte = $modelReporte->getImagenesReporte($fila->id_reporte)->getResult();
        }
        $parametrosVista = ['reportes'=>$reportes];
        if(!empty($this->session->getFlashdata('mensaje')) ){
            $parametrosVista['mensaje'] = $this->session->getFlashdata('mensaje');
            if(!empty($this->session->getFlashdata('error'))){
                $parametrosVista['error'] = true;
            }
        }
        return view('Inicio',$parametrosVista);
    }

    public function legal(){
        return view('legal');
    }

}