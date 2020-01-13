<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbArticulo;
use App\tbStockArt;
use App\Referencia;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{
    public function porid($id)
    {
        $articulo = tbArticulo::with('tbStockArt')->with('referencias')->find($id);
        return $articulo;
    }
    public function new(Request $request)
    {
        $articulo = new tbArticulo();
        $ultimoArticulo = tbArticulo::orderBy('AutoId', 'DESC')->limit(1)->first();
        $articulo->Nombre = $request->Nombre;
        $articulo->UPC = $request->Upc;
        $articulo->Id = ($ultimoArticulo->AutoId) + 1;
        $articulo->AutoId = ($ultimoArticulo->AutoId) + 1;
        $articulo->FechaAlta = $request->fechaalta;
        $articulo->save();
        $stock = new tbStockArt();
        $stock->Articulo = $articulo->Id;
        $stock->Stock = $request->stock;
        $stock->save();
        return $articulo;
    }
    public function delete($id)
    {
        DB::table('tbarticulo')->where('Id', '=', $id)->delete();
        DB::table('tbstockart')->where('Articulo', '=', $id)->delete();
        return;
    }
    public function edit(Request $request, $id)
    {
        DB::table('tbarticulo')
            ->where('Id', $id)
            ->update(array('Nombre' => $request->Nombre, 'UPC' => $request->UPC));

        DB::table('tbstockart')
            ->where('Articulo', $id)
            ->update(array('Stock' => $request->tb_stock_art['Stock']));
        return json_encode($request);
    }
    public function pornombre($dd)
    {
        $articulos = tbArticulo::where('Nombre', 'LIKE', '%' . $dd . '%')->with('tbStockArt')->with('referencias')->get();
        $ordenados = $articulos;
        $ordenados->sortBy('tbStockArt->Stock', SORT_REGULAR, true);
        return json_encode($ordenados);
    }
    public function index()
    {
        $articulos = tbArticulo::orderBy('Id')->with('tbStockArt')->with('referencias')->get();
        return json_encode($articulos);
    }
}
