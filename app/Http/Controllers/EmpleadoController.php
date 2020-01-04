<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    public function new(Request $request){
        $empleado = new Empleado();
        $empleado->name = $request->name;
        $empleado->telefono = $request->telefono;
        $empleado->email = $request->email;
        $empleado->activo = $request->activo;
        $empleado->appcode = $request->appcode;

        $empleado->save();
        return $empleado;
    }
    public function index(){
        try {
            $empleados = Empleado::orderBy('Id')->get();
            return json_encode($empleados);
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function porid($id)
    {
        $empleado = Empleado::find($id);
        return json_encode($empleado);
    }
    public function edit(Request $request, $id){
        DB::table('empleados')
            ->where('id', $id)
            ->update(array('name' => $request->name, 'telefono' => $request->telefono, 'activo' => $request->activo, 'email' => $request->email));
        return json_encode(Empleado::get());
    }
    public function delete($id){
        DB::table('empleados')->where('id', '=', $id)->delete();
        return ('ok');
    }
    public function activos(){
        $empleados = Empleado::where('activo', '=', true)->get();
        return json_encode($empleados);
    }



}
