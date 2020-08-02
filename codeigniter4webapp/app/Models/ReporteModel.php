<?php namespace App\Models;

use CodeIgniter\Model;

class ReporteModel extends Model
{
    /**
     * [$table description]
     * @var string
     */
    protected $table      = 'reportes';
    /**
     * [$primaryKey description]
     * @var string
     */
    protected $primaryKey = 'id_reporte';
    /**
     * [$returnType description]
     * @var string
     */
    protected $returnType     = 'object';
    /**
     * [$useSoftDeletes description]
     * @var boolean
     */
    protected $useSoftDeletes = true;

    /**
     * [$allowedFields description]
     * @var [type]
     */
    protected $allowedFields = ['id_usuario', 'reporte_mascota_nombre','id_tipo_animal','tipo_reporte','reporte_fecha','reporte_descripcion','latitud','longitud','reporte_vencimiento','departamento_id','ciudad_id','distrito_id','barrio_id','reporte_direccion'];
    /**
     * [$useTimestamps description]
     * @var boolean
     */
    protected $useTimestamps = true;
    /**
     * [$createdField description]
     * @var string
     */
    protected $createdField  = 'reporte_fecha_alta';
    /**
     * [$updatedField description]
     * @var string
     */
    protected $updatedField  = 'reporte_fecha_actualizacion';
    /**
     * [$deletedField description]
     * @var string
     */
    protected $deletedField  = 'reporte_fecha_borrado';

    /**
     * [getDepartamentoCiudadDistritoByLatLong description]
     * @param  [type] $lat  [description]
     * @param  [type] $long [description]
     * @return [type]       [description]
     */
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

    /**
     * [getImagenesReporte description]
     * @param  [type] $id_reporte [description]
     * @param  string $estado     [description]
     * @return [type]             [description]
     */
    public function getImagenesReporte($id_reporte,$estado='Activo'){
        return $this->db
            ->table('imagenes_reportes')
            ->where('imagen_reporte_estado',$estado)
            ->where('id_reporte',$id_reporte)
            ->get();
    }

    public function getReportesUsuario($id_usuario){
        return $this->select('dp.departamento_nombre,d.distrito_nombre,b.barrio_nombre,c.ciudad_nombre,reportes.*')
            ->join('ciudades c','c.ciudad_id = reportes.ciudad_id','left')
            ->join('distritos d','d.distrito_id = reportes.distrito_id','left')
            ->join('departamentos dp','dp.departamento_id = reportes.departamento_id','left')
            ->join('barrios b','b.barrio_id = reportes.barrio_id','left')
            ->where('id_usuario',$id_usuario )
            ->get();
    }

    public function getReportes($limit=10,$offset=0){
        return $this->select('dp.departamento_nombre,d.distrito_nombre,b.barrio_nombre,c.ciudad_nombre,reportes.*')
            ->join('ciudades c','c.ciudad_id = reportes.ciudad_id','left')
            ->join('distritos d','d.distrito_id = reportes.distrito_id','left')
            ->join('departamentos dp','dp.departamento_id = reportes.departamento_id','left')
            ->join('barrios b','b.barrio_id = reportes.barrio_id','left')
            ->where('reporte_vencimiento > now()' )
            ->where('reporte_estado','Activo')
            ->limit($limit)
            ->offset($offset)
            ->get();
    }

    public function getImagenPorNombre($nombre){
        return $this->db
            ->table('imagenes_reportes')
            ->where('imagen_reporte_nombre',$nombre)
            ->orWhere('imagen_miniatura',$nombre)
            ->get();
    }

}