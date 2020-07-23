<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Inicio extends Controller
{
    public function index()
    {
        return view('Inicio');
    }

    public function form_registro(){
        return view('form_registro');
    }

    public function legal(){
        return view('legal');
    }
}