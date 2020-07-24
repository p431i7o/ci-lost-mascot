<?php namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'usuario_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['usuario_email', 'usuario_telefono','usuario_estado','usuario_nombre','usuario_picture','usuario_password','usuario_hash_recuperacion'];

    protected $useTimestamps = true;
    protected $createdField  = 'usuario_fecha_alta';
    protected $updatedField  = 'usuario_fecha_actualizacion';
    protected $deletedField  = 'usuario_fecha_borrado';

}