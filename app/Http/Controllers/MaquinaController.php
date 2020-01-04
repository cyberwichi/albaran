<?php

namespace App\Http\Controllers;
use App\Maquina;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Albaranmaquina;

class MaquinaController extends Controller
{
    public function new(Request $request){
        $maquina = new Maquina();
        $maquina->nombre = $request->nombre;
        $maquina->comentarios = $request->comentarios;
        $maquina->save();
        return $maquina;
    }
    public function index(){
        $maquinas = Maquina::orderBy('Id')->get();
        return json_encode($maquinas);
    }
    public function edit(Request $request, $id){
        DB::table('maquinas')
            ->where('id', $id)
            ->update(array('nombre' => $request->nombre, 'comentarios' => $request->comentarios));
        return json_encode($request);
    }
    public function delete($id){
        Maquina::where('id', '=', $id)->delete();
        return;
    }
    public function pornombre($dd){
        $maquinas = Maquina::where('nombre', 'LIKE', '%' . $dd . '%')->get();
        return response()->json($maquinas);
    }
    public function porid($id){
        $maquina = Maquina::find($id);
        return json_encode($maquina);
    }
    public function historial($ref){
        $historial = Albaranmaquina::where('referencia', 'LIKE', $ref)->orderBy('maquina_id')->orderBy('created_at', 'desc')->get();
        return json_encode($historial);
    }

}
