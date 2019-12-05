<?php

use App\Albaran;
use App\Aviso;
use App\DetalleAlbaran;
use App\Albaranmaquina;
use App\DetalleAviso;
use App\Empleado;
use App\Maquina;
use App\tbArticulo;
use App\tbContacto;
use App\tbStockArt;
use Illuminate\Routing\Middleware;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\Console\Input\Input;
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


//index contactos
Route::get('contactos', function () {
	try {
		$contactos = tbContacto::orderBy('Id')->get();
		return json_encode($contactos);
	} catch (\Throwable $th) {
		return $th;
	}
});
//contacto por id
Route::get('contactos/{id}', function ($id) {
	$articulo = tbContacto::find($id);
	return json_encode($articulo);
});
//nuevo contacto
Route::post('contactos', function (Request $request) {

	$contacto = new tbContacto();
	$ultimoContacto = tbContacto::orderBy('Id', 'DESC')->limit(1)->first();
	$contacto->Nombre = $request->Nombre;
	$contacto->Direccion = $request->Direccion;
	$contacto->Id = ($ultimoContacto->Id) + 1;
	$contacto->AutoId = ($ultimoContacto->Id) + 1;
	$contacto->Nif = $request->Nif;
	$contacto->Telefono = $request->Telefono;
	$contacto->Email = $request->Email;

	$contacto->save();
	return $contacto;
});
//bora un contacto
Route::get('delcontactos/{id}', function ($id) {

	DB::table('tbcontacto')->where('Id', '=', $id)->delete();
	return;
});
// actualizar contacto
Route::put('contactos/{id}', function (Request $request, $id) {

	DB::table('tbcontacto')
		->where('Id', $id)
		->update(array('Nombre' => $request->Nombre, 'Direccion' => $request->Direccion, 'Nif' => $request->Nif, 'Telefono' => $request->Telefono, 'Email' => $request->Email));

	return;
});
//buscar contacto por nombre
Route::get('searchcontacto/{dd}', function ($dd) {

	$contactos = tbContacto::where('Nombre', 'LIKE', '%' . $dd . '%')->get();
	return response()->json($contactos);
});


//articulo por id
Route::get('articulos/{id}', function ($id) {
	$articulo = tbArticulo::with('tbStockArt')->find($id);

	return json_encode($articulo);
});
//nuevo articulo
Route::post('articulos', function (Request $request) {

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
});

//bora un articulo y su stock
Route::get('delarticulos/{id}', function ($id) {

	DB::table('tbarticulo')->where('Id', '=', $id)->delete();
	DB::table('tbstockart')->where('Articulo', '=', $id)->delete();

	return;
});

// actualizar articulo y stock
Route::put('articulos/{id}', function (Request $request, $id) {

	DB::table('tbarticulo')
		->where('Id', $id)
		->update(array('Nombre' => $request->Nombre, 'UPC' => $request->UPC));

	DB::table('tbstockart')
		->where('Articulo', $id)
		->update(array('Stock' => $request->tb_stock_art['Stock']));
	return json_encode($request);
});

//buscar articulo por nombre y ordenado por stock
Route::get('searcharticulo/{dd}', function ($dd) {

	$articulos = tbArticulo::where('Nombre', 'LIKE', '%' . $dd . '%')->with('tbStockArt')->get();
	$ordenados = $articulos;


	$ordenados->sortBy('tbStockArt->Stock', SORT_REGULAR, true);

	return ($ordenados);
});
//index articulos
Route::get('articulos', function () {

	$articulos = tbArticulo::orderBy('Id')->with('tbStockArt')->get();

	return json_encode($articulos);
});



//index stock
Route::get('stock', function () {
	$stocks = tbStockArt::orderBy('AutoId')->get();
	return json_encode($stocks);
});

//stock por id
Route::get('stock/{id}', function ($id) {
	$stock = tbStockArt::where('Articulo', '=', $id)->get();
	return json_encode($stock);
});
// suma stock entrada de articulos
Route::put('articulossumastock/{id}', function (Request $request, $id) {

	$articulo = tbStockArt::where('Articulo', $id)->get();


	$articulo[0]->update(array('Stock' => $request->articuloCantidad + $articulo[0]->Stock));

	return json_encode($articulo);
});



//bora un aviso
Route::get('delaviso/{id}', function ($id) {

	DB::table('avisos')->where('id', '=', $id)->delete();
	DetalleAviso::where('aviso_id', '=', $id)->delete();


	return;
});

// actualizar aviso
Route::put('avisos/{id}', function (Request $request, $id) {

	$aviso = Aviso::find($id);
	$aviso->contacto_id = $request->contacto_id;
	$aviso->fechaPrevista = $request->fechaPrevista;
	$aviso->comentario = $request->comentario;
	$aviso->empleado_id = $request->empleado_id;
	$aviso->update();

	return ($aviso);
});

//guardar aviso
Route::post('aviso', function (Request $request) {
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
});
//index aviso
Route::get('avisos', function () {
	$avisos = Aviso::orderBy('Id', 'desc')->with('tbContacto')->with('Empleado')->get();

	return ($avisos);
});

//aviso por id
Route::get('avisos/{id}', function ($id) {
	$aviso = Aviso::where('id', $id)->with('tbContacto')->with('Empleado')->get();

	return ($aviso);
});
//aviso por cliente
Route::get('avisosporcliente/{id}', function ($id) {
	$aviso = Aviso::where('contacto_id', $id)->orderBy('Id', 'desc')->with('tbContacto')->get();

	return json_encode($aviso);
});
//señala como finalizado un aviso
Route::get('finaliza/{id}', function ($id) {

	Aviso::find($id)->update(['terminada' => "1"]);
	return "ok";
});

//detalle de aviso por id
Route::get('detalles/{id}', function ($id) {
	$detalles = DetalleAviso::where('aviso_id', $id)->get();
	return json_encode($detalles);
});
//avisos por empleado
Route::get('avisos/empleado/{id}', function ($id) {
	$avisos = Aviso::where('empleado_id', $id)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();

	return json_encode($avisos);
});
//avisos por no terminados
Route::get('avisosnoterminados', function () {
	$avisos = Aviso::where('terminada', null)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();

	return json_encode($avisos);
});




//albaranes index
Route::get('albaranes', function () {
	$albaranes = Albaran::orderBy('Id', 'desc')->with('detallealbaran')->with('albaranmaquina')->get();
	return json_encode($albaranes);
});

//albaranes por cliente

Route::get('albaranesporcliente/{id}', function ($id) {
	$avisos = Aviso::where('contacto_id', $id)->get();
	$albaranes = [];
	foreach ($avisos as $key => $aviso) {
		$albaranes[$key] = Albaran::where('aviso_id', $aviso->id)->with('detallealbaran')->with('albaranmaquina')->get();
	}

	return json_encode($albaranes);
});
//albaranes por aviso

Route::get('albaranesporaviso/{id}', function ($id) {
	$albaranes = Albaran::where('aviso_id', $id)->with('albaranmaquina')->orderBy('aviso_id', 'desc')->get();
	return json_encode($albaranes);
});

//guardamos albaran
Route::post('albaran', function (Request $request) {

	$albaran = new  Albaran();
	$albaran->aviso_id = $request->aviso_id;
	$albaran->observaciones = $request->observaciones;
	$albaran->firma_cliente = $request->firma_cliente;
	$albaran->firma_empleado = $request->firma_empleado;
	$albaran->save();
	foreach ($request->listaarticulos as $key => $linea) {
		$detalle = new DetalleAlbaran();
		$detalle->albaran_id = $albaran->id;
		$detalle->articulo_id = $linea['articulo_id'];
		$detalle->articulo_nombre = $linea['articulonombre'];
		$detalle->cantidad = $linea['cantidad'];
		$detalle->precio = $linea['precio'];
		$detalle->save();

		$stock = tbStockArt::where('Articulo', '=', $linea['articulo_id'])->first();
		$stock->Stock = $stock->Stock - $linea['cantidad'];
		$stock->UdsPed = $stock->UdsPed - $linea['cantidad'];
		$stock->update();
	}
	foreach($request->listamaquinas as $key => $linea){
		$maquina= new AlbaranMaquina();
		$maquina->albaran_id= $albaran->id;
		$maquina->maquina_id= $linea['id'];
		$maquina->referencia= $linea['referencia'];
		$maquina->save();

	}

	return $albaran->id;
});

//bora un albaran
Route::get('delalbaranes/{id}', function ($id) {

	Albaran::where('id', '=', $id)->delete();
	DetalleAlbaran::where('albaran_id', '=', $id)->delete();

	return;
});
//albaran por id
Route::get('albaran/{id}', function ($id) {
	$albaran = Albaran::where('id', $id)->with('detallealbaran')->get();

	return ($albaran);
});

//detalle de albaran por id de albaran
Route::get('detallesalbaran/{id}', function ($id) {
	$detalles = DetalleAlbaran::where('albaran_id', '=', $id)->get();
	return json_encode($detalles);
});





//nuevo empleado
Route::post('empleados', function (Request $request) {

	$empleado = new Empleado();
	$empleado->name = $request->name;
	$empleado->telefono = $request->telefono;
	$empleado->email=$request->email;
	$empleado->activo = $request->activo;
	$empleado->appcode=$request->appcode;

	$empleado->save();
	return $empleado;
});

//index empleados
Route::get('empleados', function () {
	try {
		$empleados = Empleado::orderBy('Id')->get();
		return json_encode($empleados);
	} catch (\Throwable $th) {
		return $th;
	}
});

//empleado por id
Route::get('empleados/{id}', function ($id) {
	$empleado = Empleado::find($id);
	return json_encode($empleado);
});

// actualizar empleado
Route::put('empleados/{id}', function (Request $request, $id) {

	DB::table('empleados')
		->where('id', $id)
		->update(array('name' => $request->name, 'telefono' => $request->telefono, 'activo' => $request->activo, 'email'=>$request->email));
	return json_encode(Empleado::get());
});

//bora un empleado
Route::get('/delempleados/{id}', function ($id) {
	DB::table('empleados')->where('id', '=', $id)->delete();
	return ('ok');
});

//empleados activos
Route::get('activos', function () {
	$empleados = Empleado::where('activo', '=', true)->get();
	return json_encode($empleados);
});





//nuevo maquina
Route::post('maquinas', function (Request $request) {
	$maquina = new Maquina();
	$maquina->nombre = $request->nombre;
	$maquina->comentarios = $request->comentarios;
	$maquina->save();	
	return $maquina;
});
//index maquinas
Route::get('maquinas', function () {

	$maquinas = Maquina::orderBy('Id')->get();

	return json_encode($maquinas);
});
// actualizar maquina
Route::put('maquinas/{id}', function (Request $request, $id) {

	DB::table('maquinas')
		->where('id', $id)
		->update(array('nombre' => $request->nombre, 'comentarios' => $request->comentarios));
	return json_encode($request);
});
//bora una maquina
Route::get('delmaquinas/{id}', function ($id) {

	Maquina::where('id', '=', $id)->delete();
	return;
});
//buscar maquina por nombre
Route::get('searchmaquina/{dd}', function ($dd) {

	$maquinas = Maquina::where('nombre', 'LIKE', '%' . $dd . '%')->get();
	return response()->json($maquinas);
});
//maquina por id
Route::get('maquinas/{id}', function ($id) {
	$maquina = Maquina::find($id);
	return json_encode($maquina);
});