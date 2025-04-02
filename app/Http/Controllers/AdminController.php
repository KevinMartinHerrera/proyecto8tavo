<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//ruta principal para administrador 
class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
}
