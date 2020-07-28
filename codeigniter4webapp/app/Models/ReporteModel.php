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

    public function getDepartamentoCiudadDistritoByLatLong($lat,$long){
        return $this->db->query("SELECT dep.departamento_nombre, dep.departamento_capital, dis.distrito_nombre, ciu.ciudad_nombre,ba.barrio_nombre,
        dep.departamento_id, dis.distrito_id, ciu.ciudad_id, ba.barrio_id
  FROM departamentos dep 
  LEFT JOIN distritos dis   ON ST_Contains(dis.geom, ST_GeomFromText('POINT( ".$this->db->escapeString($long)." ".$this->db->escapeString($lat)."  )',1))
  LEFT JOIN ciudades ciu ON ST_Contains(ciu.geom, ST_GeomFromText('POINT(".$this->db->escapeString($long)." ".$this->db->escapeString($lat)." )',1))
  LEFT JOIN barrios ba ON ST_Contains(ba.geom, ST_GeomFromText('POINT( ".$this->db->escapeString($long)." ".$this->db->escapeString($lat)." )',1))
  WHERE ST_Contains(dep.geom, ST_GeomFromText('POINT( ".$this->db->escapeString($long)." ".$this->db->escapeString($lat)." )',1)) 
  AND ST_Contains(ciu.geom, ST_GeomFromText('POINT( ".$this->db->escapeString($long)." ".$this->db->escapeString($lat)." )',1))
  AND ST_Contains(ciu.geom, ST_GeomFromText('POINT( ".$this->db->escapeString($long)." ".$this->db->escapeString($lat)." )',1))");
    }

}