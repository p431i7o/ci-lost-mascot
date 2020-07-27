<?php namespace App\Models;

use CodeIgniter\Model;

class TiposAnimalesModel extends Model
{
    protected $table      = 'tipos_animales';
    protected $primaryKey = 'id_tipo_animal';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['tipo_animal_descripcion', 'tipo_animal_ejemplo'];

    protected $useTimestamps = false;
    // protected $createdField  = 'usuario_fecha_alta';
    // protected $updatedField  = 'usuario_fecha_actualizacion';
    // protected $deletedField  = 'usuario_fecha_borrado';

}