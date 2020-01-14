<?php

namespace App\Http\Controllers;

use App\Configuracion;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index(){
        $config = Configuracion::first();
        return $config;
    }
    public function edit(Request $request)
    {
        $config = Configuracion::first();
        $config->email=$request->correo;
        $config->password=$request->password;
        $config->save();
        return $request;
    }
}
