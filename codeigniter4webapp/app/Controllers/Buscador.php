<?php namespace App\Controllers;

use CodeIgniter\Controller;


class Buscador extends BaseController
{
    public function buscar()
    {
        //return view('Inicio');
        // echo "hola esto es la busqueda";
        return view('ResultadoBusqueda');
    }
}