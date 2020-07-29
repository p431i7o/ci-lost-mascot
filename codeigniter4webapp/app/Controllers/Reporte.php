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
            // var_dump($result);
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
                'id_usuario'=>$this->session->get('usuario')->id_usuario,
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
                // var_dump($id_reporte);
                // var_dump($this->request->getFiles());
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
                                   // ->fit(env('MINIATURA_ANCHO'), null, 'center')
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
}