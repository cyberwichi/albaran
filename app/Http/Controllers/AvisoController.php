<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\DetalleAviso;
use App\Aviso;
use App\tbStockArt;

use Illuminate\Http\Request;

class AvisoController extends Controller
{
    public function delete($id)
    {
        DB::table('avisos')->where('id', '=', $id)->delete();
        DetalleAviso::where('aviso_id', '=', $id)->delete();
        return;
    }
    public function edit(Request $request, $id)
    {
        $aviso = Aviso::find($id);
        $aviso->contacto_id = $request->contacto_id;
        $aviso->fechaPrevista = $request->fechaPrevista;
        $aviso->comentario = $request->comentario;
        $aviso->empleado_id = $request->empleado_id;
        $aviso->update();
        return ($aviso);
    }

    public function new(Request $request)
    {
        if ($request->id == 0) {

            $aviso = new Aviso();
            $aviso->contacto_id = $request->clientid;
            $aviso->fechaPrevista = $request->fechaPrevista;
            $aviso->comentario = $request->observaciones;
            $aviso->save();

            foreach ($request->listaarticulos as $key => $linea) {
                $detalle = new DetalleAviso();
                $detalle->aviso_id = $aviso->id;
                $detalle->articulo_id = $linea['articuloId'];
                $detalle->articulo_nombre = $linea['articuloNombre'];
                $detalle->cantidad = $linea['articuloCantidad'];
                $detalle->precio = $linea['articuloPrecio'];
                $detalle->save();

                $stock = tbStockArt::where('Articulo', '=', $linea['articuloId'])->first();
                $stock->UdsPed = $stock->UdsPed + $linea['articuloCantidad'];
                $stock->update();
            };
        } else {
            $aviso = Aviso::find($request->id);
            $aviso->contacto_id = $request->clientid;
            $aviso->fechaPrevista = $request->fechaPrevista;
            $aviso->comentario = $request->observaciones;
            $aviso->empleado_id = $request->empleado;
            $aviso->update();
            if ($request->listaarticulos) {
                $detalle = DetalleAviso::where('aviso_id', $request->id)->get();
                foreach ($detalle as $key => $linea) {
                    $stock = tbStockArt::where('Articulo', '=', $linea['articulo_id'])->first();
                    $stock->UdsPed = $stock->UdsPed - $linea['cantidad'];
                    $stock->update();
                }
                $detalle = DetalleAviso::where('aviso_id', $request->id);
                $detalle->delete();
                foreach ($request->listaarticulos as $key => $linea) {
                    $detalle = new DetalleAviso();
                    $detalle->aviso_id = $aviso->id;
                    $detalle->articulo_id = $linea['articulo_id'];
                    $detalle->articulo_nombre = $linea['articulo_nombre'];
                    $detalle->cantidad = $linea['cantidad'];
                    $detalle->precio = $linea['precio'];
                    $detalle->save();

                    $stock = tbStockArt::where('Articulo', '=', $linea['articulo_id'])->first();
                    $stock->UdsPed = $stock->UdsPed + $linea['cantidad'];
                    $stock->update();
                };
            }
        }
        return $aviso->id;
    }
    public function  index()
    {
        $avisos = Aviso::orderBy('Id', 'desc')->with('tbContacto')->with('Empleado')->get();
        return ($avisos);
    }
    public function porid($id)
    {
        $aviso = Aviso::where('id', $id)->with('tbContacto')->with('Empleado')->get();
        return ($aviso);
    }
    public function porcliente($id)
    {
        $aviso = Aviso::where('contacto_id', $id)->orderBy('Id', 'desc')->with('tbContacto')->get();
        return json_encode($aviso);
    }
    public function finalizado($id)
    {
        Aviso::find($id)->update(['terminada' => "1"]);
        return "ok";
    }
    public function detalles($id)
    {
        $detalles = DetalleAviso::where('aviso_id', $id)->get();
        return json_encode($detalles);
    }
    public function porempleado($id){
        $avisos = Aviso::where('empleado_id', $id)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();
        return json_encode($avisos);
    }
    public function noterminados()
    {
        $avisos = Aviso::where('terminada', null)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();
        return json_encode($avisos);
    }
    public function noterminadosporempleado($id)
    {
        $avisos = Aviso::where('empleado_id', $id)->where('terminada', null)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();
        return json_encode($avisos);
    }
}
