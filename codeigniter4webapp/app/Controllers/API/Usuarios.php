<?php namespace App\Controllers\API;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
    
class Usuarios extends Controller
{
    use ResponseTrait;
   
   public function index(){
    $modelUsuarios = new \App\Models\UsuarioModel();
    $users = $modelUsuarios->findAll();
    // print_r($users);
        return $this->respond($users,200);
   }

    public function create()
    {
        $modelUsuarios = new \App\Models\UsuarioModel();
        // $modelUsuarios = model('App\Models\UsuarioModel', false);
        $data = [
            'usuario_nombre' => 'darth',
            'usuario_email'    => 'd.vader@theempire.com'
        ];

        $modelUsuarios->insert($data);
    }
}
// echo "hola";