<?php

namespace App\Http\Controllers;

use App\tbStockArt;

use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = tbStockArt::orderBy('AutoId')->get();
        return ($stocks);
    }
    public function porid($id)
    {
        $stock = tbStockArt::where('Articulo', '=', $id)->get();
        return ($stock);
    }
    public function add(Request $request, $id)
    {
        $articulo = tbStockArt::where('Articulo', $id)->get();
        $articulo[0]->update(array('Stock' => $request->articuloCantidad + $articulo[0]->Stock));
        return json_encode($articulo);
    }
}
