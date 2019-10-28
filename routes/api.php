<?php

use App\tbArticulo;
use App\tbContacto;
use App\tbStockArt;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\Console\Input\Input;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//index contactos
Route::get('contactos', function () {
    $contactos = tbContacto::orderBy('Id')->get();
    return json_encode($contactos);
});

//index articulos
Route::get('articulos', function () {
 
    $articulos = tbArticulo::orderBy('Id')->get();
    return json_encode($articulos);
});

//index stock
Route::get('stock', function () {
    $stocks = tbStockArt::orderBy('AutoId')->get();
    return json_encode($stocks);
});

//stock por id
Route::get('stock/{id}', function ($id) {
    $stock = tbStockArt::get($id);
    return json_encode($stock);
});

//articulo por id
Route::get('articulos/{id}', function ($id) {
    $articulo = tbArticulo::find($id);
    return json_encode($articulo);
});


//nuevo contacto
Route::post('contactos', function (Request $request) {

    $contacto = new tbContacto();
    $ultimoContacto = tbContacto::orderBy('AutoId', 'DESC')->limit(1)->first();
    $contacto->Nombre = $request->Nombre;
    $contacto->Direccion = $request->Direccion;
    $contacto->Id = ($ultimoContacto->AutoId) + 1;
    $contacto->save();
    return $contacto;
});

//nuevo articulo
Route::post('articulos', function (Request $request) {

    $articulo = new tbArticulo();
    $ultimoArticulo = tbArticulo::orderBy('AutoId', 'DESC')->limit(1)->first();
    $articulo->Nombre = $request->Nombre;
    $articulo->UPC = $request->Upc;
    $articulo->Id = ($ultimoArticulo->AutoId) + 1;
    $articulo->save();
    return $articulo;
});


//bora un articulo
Route::get('delarticulos/{id}', function ($id) {

    DB::table('tbArticulo')->where('AutoId', '=', $id)->delete();
    return;
});

//bora un contacto
Route::get('delcontactos/{id}', function ($id) {

    DB::table('tbContacto')->where('AutoId', '=', $id)->delete();
    return;
});




// actualizar articulo
Route::put('articulos/{id}', function (Request $request, $id) {

    DB::table('tbArticulo')
        ->where('AutoId', $id)
        ->update(array('Nombre' => $request->Nombre, 'UPC' => $request->UPC));

    return;
});

// actualizar contacto
Route::put('contactos/{id}', function (Request $request, $id) {

    DB::table('tbContacto')
        ->where('AutoId', $id)
        ->update(array('Nombre' => $request->Nombre, 'Direccion' => $request->Direccion,));

    return;
});




//buscar articulo por nombre
Route::get('searcharticulo/{dd}', function ($dd) {

    $articulos = tbArticulo::where('Nombre', 'LIKE', '%' . $dd . '%')->get();
    return response()->json($articulos);
});

//buscar contacto por nombre
Route::get('searchcontacto/{dd}', function ($dd) {

    $contactos = tbContacto::where('Nombre', 'LIKE', '%' . $dd . '%')->get();
    return response()->json($contactos);
});
