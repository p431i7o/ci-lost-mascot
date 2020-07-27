<?php namespace App\Models;

use CodeIgniter\Model;

class ReporteModel extends Model
{
    protected $table      = 'reportes';
    protected $primaryKey = 'id_reporte';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id_usuario', 'reporte_mascota_nombre','id_tipo_animal','tipo_reporte','reporte_fecha','reporte_descripcion','latitud','longitud','reporte_vencimiento','departamento_id','ciudad_id','distrito_id','barrio_id','reporte_direccion'];

    protected $useTimestamps = true;
    protected $createdField  = 'reporte_fecha_alta';
    protected $updatedField  = 'reporte_fecha_actualizacion';
    protected $deletedField  = 'reporte_fecha_borrado';

}