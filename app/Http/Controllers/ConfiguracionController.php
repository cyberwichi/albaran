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
        $config->correo_admin=$request->correoAdmin;
        $config->correo_tecnicos = $request->correoTecnicos;
        $config->save();
        return $request;
    }
    public function literales(Request $request)
    {
        $config = Configuracion::first();
        $config->proteccion=$request->proteccion;
        $config->asunto = $request->asunto;
        $config->save();
        return 'Ok';
    }
}
