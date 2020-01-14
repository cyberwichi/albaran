<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
//para el movil
/* Route::get('movil/albaran/{id}', function ($id) {
	return view("movil/albaran", compact('id'));
}); */


//index contactos
Route::get('contactos', 'ContactoController@index')->name('indexcontacto');

//contacto por id
Route::get('contactos/{id}', 'ContactoController@porid')->name('poridcontacto');

//nuevo contacto
Route::post('contactos',  'ContactoController@new')->name('newcontacto');

//bora un contacto
Route::get('delcontactos/{id}', 'ContactoController@delete')->name('deletecontacto');

// actualizar contacto
Route::put('contactos/{id}', 'ContactoController@edit')->name('editcontacto');

//buscar contacto por nombre
Route::get('searchcontacto/{dd}', 'ContactoController@pornombre')->name('pornombrecontacto');




//articulo por id
Route::get('articulos/{id}', 'ArticuloController@porid')->name('poridarticulo');

//nuevo articulo
Route::post('articulos', 'ArticuloController@new')->name('newarticulo');

//bora un articulo y su stock
Route::get('delarticulos/{id}', 'ArticuloController@delete')->name('deletearticulo');

// actualizar articulo y stock
Route::put('articulos/{id}', 'ArticuloController@edit')->name('editarticulo');

//buscar articulo por nombre y ordenado por stock
Route::get('searcharticulo/{dd}', 'ArticuloController@pornombre')->name('pornombrearticulo');

//index articulos
Route::get('articulos', 'ArticuloController@index')->name('indexarticulo');




//index stock
Route::get('stock', 'StockController@index')->name('indexstock');

//stock por id
Route::get('stock/{id}', 'StockController@porid')->name('poridstock');

// suma stock entrada de articulos
Route::put('articulossumastock/{id}', 'StockController@add')->name('addstock');




//bora un aviso
Route::get('delaviso/{id}', 'AvisoController@delete')->name('deleteaviso');

// actualizar aviso
Route::put('avisos/{id}', 'AvisoController@edit')->name('editaviso');

//guardar aviso
Route::post('aviso', 'AvisoController@new')->name('newaviso');

//index aviso
Route::get('avisos', 'AvisoController@index')->name('indexaviso');

//aviso por id
Route::get('avisos/{id}', 'AvisoController@porid')->name('poridaviso');

//aviso por cliente
Route::get('avisosporcliente/{id}', 'AvisoController@porcliente')->name('porclienteaviso');

//señala como finalizado un aviso
Route::get('finaliza/{id}', 'AvisoController@finalizado')->name('finalizadoaviso');

//detalle de aviso por id
Route::get('detalles/{id}', 'AvisoController@detalles')->name('detallesaviso');

//avisos por empleado
Route::get('avisos/empleado/{id}', 'AvisoController@porempleado')->name('porempleadoaviso');

//avisos por no terminados
Route::get('avisosnoterminados', 'AvisoController@noterminados')->name('noterminadosaviso');

//avisos no terminados por empleado
Route::get('avisos/noterminados/empleado/{id}', 'AvisoController@noterminadosporempleado')->name('noterminadosporempleadoaviso');





//albaranes index
Route::get('albaranes', 'AlbaranController@index')->name('indexalbaran');

//albaranes por cliente
Route::get('albaranesporcliente/{id}', 'AlbaranController@porcliente')->name('porclientealbaran');

//albaranes por aviso
Route::get('albaranesporaviso/{id}', 'AlbaranController@poraviso')->name('poravisoalbaran');

//guardamos albaran
Route::post('albaran', 'AlbaranController@new')->name('newalbaran');


//bora un albaran
Route::get('delalbaranes/{id}', 'AlbaranController@delete')->name('deletealbaran');

//albaran por id
Route::get('albaran/{id}', 'AlbaranController@porid')->name('poridalbaran');


//detalle de albaran por id de albaran
Route::get('detallesalbaran/{id}', 'AlbaranController@detalleporid')->name('detalleporidalbaran');




//nuevo empleado
Route::post('empleados', 'EmpleadoController@new')->name('newempleado');

//index empleados
Route::get('empleados', 'EmpleadoController@index')->name('indexempleado');

//empleado por id
Route::get('empleados/{id}', 'EmpleadoController@porid')->name('poridempleado');

// actualizar empleado
Route::put('empleados/{id}', 'EmpleadoController@edit')->name('editempleado');

//bora un empleado
Route::get('/delempleados/{id}', 'EmpleadoController@delete')->name('deleteempleado');

//empleados activos
Route::get('activos', 'EmpleadoController@activos')->name('activosempleado');




//index user
Route::get('administradores', 'UserController@index')->name('indexuser');

//guardamos user
Route::post('administradores/{id}', 'UserController@edit')->name('edituser');

//borramos user
Route::get('deladministradores/{id}', 'UserController@delete')->name('deleteuser');






//nuevo maquina
Route::post('maquinas', 'MaquinaController@new')->name('newmaquina');

//index maquinas
Route::get('maquinas', 'MaquinaController@index')->name('indexmaquina');

// actualizar maquina
Route::put('maquinas/{id}', 'MaquinaController@edit')->name('editmaquina');

//bora una maquina
Route::get('delmaquinas/{id}', 'MaquinaController@delete')->name('deletemaquina');

//buscar maquina por nombre
Route::get('searchmaquina/{dd}', 'MaquinaController@pornombre')->name('pornombremaquina');

//maquina por id
Route::get('maquinas/{id}', 'MaquinaController@porid')->name('poridmaquina');

//historial de intervenciones en maquinas por referencia
Route::get('maquinashistorial/{ref}', 'MaquinaController@historial')->name('historialmaquina');




//crear pdf y los almacena en public/albaran
Route::get('/imprimir/{id}', 'PdfController@imprimir')->name('imprimirpdf');

//produce albaran pdf y envia por mail al cliente
Route::get('/enviar/{id}', 'PdfController@enviar')->name('enviarpdf');




// nueva referencia
Route::post('/referencia', 'ReferenciaController@store')->name ('nuevareferencia');
//articulos por Referencia
Route::get('/referencia/{referencia}', 'ReferenciaController@articulosporreferencia')->name('articulosporreferencia');
//referencia por articulo
Route::get('/referenciaid/{id}', 'ReferenciaController@referenciaid')->name('idreferencia');
//index referencias
Route::get('/referencias', 'ReferenciaController@index')->name('indexreferencias');
//borrar referencia
Route::get('/delreferencia/{id}', 'ReferenciaController@destroy')->name('deletereferencia');
//actualizar referencia
Route::put('/referencias/{id}', 'ReferenciaController@update')->name('updatereferencia');


//obtener Configuracion
Route::get('/config', 'ConfiguracionController@index')->name('indexconfig');
//modificar Configuracion
Route::put('/config', 'ConfiguracionController@edit')->name('editconfig');

