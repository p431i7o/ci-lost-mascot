<?php namespace App\Controllers;

use CodeIgniter\Controller;


class Inicio extends BaseController
{
    public function index()
    {
        return view('Inicio');
    }

    

    

    public function legal(){
        return view('legal');
    }

}