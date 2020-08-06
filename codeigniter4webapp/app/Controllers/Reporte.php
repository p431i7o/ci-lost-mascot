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
                  'reporte_fecha'=>'required|max_length[10]',
                  'reporte_mascota_nombre'=>'max_length[50]',
                  'latitud'=>'required|max_length[20]',
                  'longitud'=>'required|max_length[20]',
                  'reporte_direccion'=>'max_length[200]'];

        $mensajes = [
            'reporte_mascota_nombre'=>[
                'max_length'=>'El campo Nombre puede tener un max de {param} caracteres'
                //@todo agregar las demas etiquetas para registro
            ]
        ];

        $success = false;
        
        if($this->validate($rules,$mensajes)){
            $modelReporte = new \App\Models\ReporteModel();
            $DptoDistritoCiudad = $modelReporte->getDepartamentoCiudadDistritoByLatLong($this->request->getPost('latitud'),$this->request->getPost('longitud'));
            $result = $DptoDistritoCiudad->getResult();

            if(count($result)>=0){
                $row = $result[0];
                $departamento = $row->departamento_id;
                $ciudad = $row->ciudad_id;
                $distrito = $row->distrito_id;
                $barrio = $row->barrio_id;

            }else{
                $departamento = null;
                $ciudad = null;
                $distrito = null;
                $barrio = null;
            }
            $data = [
                'id_usuario'=>$this->getIdUsuarioActual(),
                'reporte_mascota_nombre'=>$this->request->getPost('reporte_mascota_nombre'),
                'id_tipo_animal'=>$this->request->getPost('id_tipo_animal'),
                'tipo_reporte'=> $this->request->getPost('tipo_reporte'),
                'reporte_fecha'=>$this->request->getPost('reporte_fecha'),
                'reporte_descripcion'=>$this->request->getPost('reporte_descripcion'),
                'latitud'=>$this->request->getPost('latitud'),
                'longitud'=>$this->request->getPost('longitud'),
                'reporte_vencimiento'=>date('Y-m-d H:i:s',time()+env('DIAS_VENCIMIENTO')*24*3600),
                'reporte_direccion'=>$this->request->getPost('reporte_direccion'),
                'departamento_id'=>$departamento,
                'ciudad_id'=>$ciudad,
                'distrito_id'=>$distrito,
                'barrio_id'=>$barrio
            ];

            $success = $modelReporte->insert($data);
            if($success){
                $id_reporte = $modelReporte->db->insertID();

                if($imagefile = $this->request->getFiles())
                {
                   foreach($imagefile['imagenes'] as $img)
                   {
                      if ($img->isValid() && ! $img->hasMoved())
                      {
                           $newName = $img->getRandomName();
                           

                           $data_img = [
                                'id_reporte'=>$id_reporte,
                                'imagen_reporte_archivo'=>$img->getName(),
                                'imagen_reporte_fecha'=>date('Y-m-d H:i:s'),
                                'imagen_reporte_estado'=>'Activo',
                                'imagen_mime'=>$img->getMimeType(),
                                'imagen_miniatura'=>'thumb_'.$newName,
                                'imagen_reporte_nombre'=>$newName
                           ];
                           $modelReporte->db->table('imagenes_reportes')->insert($data_img);
                           $img->move(WRITEPATH.'reportes', $newName);
                           $image = \Config\Services::image()
                               ->withFile(WRITEPATH.'reportes/'.$newName)
                               ->resize(env('MINIATURA_ANCHO'),env('MINIATURA_ALTO'),true)
                               ->save(WRITEPATH.'reportes/thumb_'.$newName);

                      }
                   }
                }
            }
        }


        $tipos_animales = new \App\Models\TiposAnimalesModel();

        return view('dashboard_form_reporte',[
            'tipos_animales'=>$tipos_animales->findAll(),
            'errores'=>$errores,
            'session'=>$this->session,
            'validation' => $this->validator,
            'success'=>$success]);
    }

    public function mis_reportes(){
        if(!$this->estaConSesionAbierta()){
            return redirect()->to('/inicio'); 
        }

        $modelReporte = new \App\Models\ReporteModel();
        
        $query_reporte = $modelReporte->getReportesUsuario($this->getIdUsuarioActual() );
        $reportes = $query_reporte->getResult();

        foreach($reportes as $index=> $fila){
            $reportes[$index]->imagenes_reporte = $modelReporte->getImagenesReporte($fila->id_reporte)->getResult();
        }

        return view('dashboard_reportes',['reportes'=>$reportes]);
    }

    public function getImagenReporte($nombre,$miniatura){
       $modelReporte = new \App\Models\ReporteModel();
       $registro_query = $modelReporte->getImagenPorNombre($nombre);
            

        if(count($registro_query->getResult()) >0){
            $registro = $registro_query->getResult()[0];
            if($miniatura=='thumb'){
                $archivo = $registro->imagen_miniatura;
            }else{
                $archivo = $registro->imagen_reporte_nombre;
            }
            $mime = $registro->imagen_mime;
            $filename = $registro->imagen_reporte_archivo;
        }else{
            $mime = 'image/png';
            $archivo = 'error.png';
            $filename = $archivo;
        }
        header('Content-type:'.$mime);
        header('Content-Disposition: inline; filename="'.$filename.'"');
        echo file_get_contents(WRITEPATH.'reportes/'.$archivo);
        die();
    }

    public function getReporteLista($pagina=1){
        if(is_nan($pagina) ||  $pagina<1){
            $pagina=1;
        }
        $modelReporte = new \App\Models\ReporteModel();
        $reportes = $modelReporte->getReportes()->getResult();

        foreach($reportes as $indice => $valor){
            $reportes[$indice]->imagenes_reporte = $modelReporte->getImagenesReporte($valor->id_reporte)->getResult();
        }
        // print_r(   );
        return view('listado_reportes',['pagina'=>$pagina,'reportes'=>$reportes]);
    }
}