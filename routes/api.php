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
use Barryvdh\DomPDF\Facade as PDF;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

//nuevo albaran
//index contactos
Route::get('movil/albaran/{id}', function ($id) {
	return view("movil/albaran", compact('id'));
});


//index contactos
Route::get('contactos', function () {
	$contactos = tbContacto::get();
	return json_encode($contactos);
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
//avisos no terminados por empleado
Route::get('avisos/noterminados/empleado/{id}', function ($id) {
	$avisos = Aviso::where('empleado_id', $id)->where('terminada', null)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();

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
	if ($request->terminada == true) {
		Aviso::find($request->aviso_id)->update(['terminada' => "1"]);
	}
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
		$detalle->articulo_nombre = $linea['articulo_nombre'];
		$detalle->cantidad = $linea['cantidad'];
		$detalle->precio = $linea['precio'];
		$detalle->save();

		$stock = tbStockArt::where('Articulo', '=', $linea['articulo_id'])->first();
		$stock->Stock = $stock->Stock - $linea['cantidad'];
		$stock->UdsPed = $stock->UdsPed - $linea['cantidad'];
		$stock->update();
	}
	foreach ($request->listamaquinas as $key => $linea) {
		$maquina = new AlbaranMaquina();
		$maquina->albaran_id = $albaran->id;
		$maquina->maquina_id = $linea['id'];
		$maquina->referencia = $linea['referencia'];
		$maquina->save();
	
	}
	$id= $albaran->id;
	$albaran = Albaran::where('id', $id)->with('aviso')->with('detallealbaran')->with('albaranmaquina')->get();
	$aviso = Aviso::find($albaran[0]->aviso_id);
	$cliente= tbContacto::find($aviso->contacto_id);
	$empleado= Empleado::find($aviso->empleado_id);
	$maquina=[];
	if ($albaran[0]->albaranmaquina !== []){
		foreach($albaran[0]->albaranmaquina as $maq){
			$maquina[$maq->maquina_id]= Maquina::find($maq->maquina_id);
		}
	}
	$pdf = PDF::loadView('pdf/pdf', compact('albaran', 'cliente', 'empleado','maquina'));
	$pdf->save('albaranes/albaran' . $id . '.pdf');
	/*Configuracion de variables para enviar el correo*/
	$mail_username="cyberwichi@gmail.com";//Correo electronico saliente ejemplo: tucorreo@gmail.com
	$mail_userpassword="huertagomple";//Tu contraseña de gmail
	$mail_addAddress=$cliente->Email;//correo electronico que recibira el mensaje
	$template='
	<h1> Corrreo de envio de albaran</h1>
	<img src="/img/logo.jpeg"  style="margin:auto;" alt="">
	<h4> por favor no responda a este correo este es un mensaje atomatico para el envio de albaranes a clientes</h4>
	<p> correo enviado a: <strong>'.$cliente->Nombre.'</strong> </p>
	<p> albaran numero <strong> '.$id.' </strong> </p>
	<p> Gracias por su confianza</p>
	'; //Ruta de la plantilla HTML para enviar nuestro mensaje
				
	/*Inicio captura de datos enviados por $_POST para enviar el correo */
	$mail_setFromEmail=$mail_username;
	$mail_setFromName=$mail_username;
	$txt_message=$mail_username;
	$mail_subject="yo";
	try {
		$mail = new PHPMailer(true);
		$mail->isSMTP();                            // Establecer el correo electrónico para utilizar SMTP
		$mail->Host = 'smtp.gmail.com';             // Especificar el servidor de correo a utilizar 
		$mail->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
		$mail->Username = $mail_username;          // Correo electronico saliente ejemplo: tucorreo@gmail.com
		$mail->Password = $mail_userpassword; 		// Tu contraseña de gmail
		$mail->SMTPSecure = 'tls';                  // Habilitar encriptacion, `ssl` es aceptada
		$mail->Port = 25;                          // Puerto TCP  para conectarse 
		$mail->setFrom($mail_setFromEmail, $mail_setFromName);//Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
		$mail->addReplyTo($mail_setFromEmail, $mail_setFromName);//Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
		$mail->addAddress($mail_addAddress);   // Agregar quien recibe el e-mail enviado
		 $mail->addAttachment('albaranes/albaran' . $id . '.pdf');         // Add attachments
		$message = $template;
		$mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML
		
		$mail->Subject = $mail_subject;
		$mail->msgHTML($message);
		if(!$mail->send()) {
			echo '<p style="color:red">No se pudo enviar el mensaje..';
			echo 'Error de correo: ' . $mail->ErrorInfo;
			echo "</p>";
		} else {
			echo '<p style="color:green">Tu mensaje ha sido enviado!</p>';
		}
	}
	catch (Exception $e) {
		echo $e->getMessage();
	};
	
});

//bora un albaran
Route::get('delalbaranes/{id}', function ($id) {

	Albaran::where('id', '=', $id)->delete();
	DetalleAlbaran::where('albaran_id', '=', $id)->delete();

	return;
});
//albaran por id
Route::get('albaran/{id}', function ($id) {
	$albaran = Albaran::where('id', $id)->with('detallealbaran')->with('albaranmaquina')->get();

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
	$empleado->email = $request->email;
	$empleado->activo = $request->activo;
	$empleado->appcode = $request->appcode;

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
		->update(array('name' => $request->name, 'telefono' => $request->telefono, 'activo' => $request->activo, 'email' => $request->email));
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

//historial de intervenciones en maquinas por referencia

Route::get('maquinashistorial/{ref}', function ($ref) {
	$historial = Albaranmaquina::where('referencia', 'LIKE', $ref)->orderBy('maquina_id')->orderBy('created_at', 'desc')->get();
	return json_encode($historial);
});

//crear pdf y los almacena en public/albaran
Route::get('/imprimir/{id}', function ($id) {
	$albaran = Albaran::where('id', $id)->with('aviso')->with('detallealbaran')->with('albaranmaquina')->get();
	$aviso = Aviso::find($albaran[0]->aviso_id);
	$cliente= tbContacto::find($aviso->contacto_id);
	$empleado= Empleado::find($aviso->empleado_id);
	foreach($albaran[0]->albaranmaquina as $maq){
		$maquina[$maq->maquina_id]= Maquina::find($maq->maquina_id);
	}
	$pdf = PDF::loadView('pdf/pdf', compact('albaran', 'cliente', 'empleado','maquina'));
	$pdf->save('albaranes/albaran' . $id . '.pdf');
	return ($maquina);
});

//produce albaran pdf y envia por mail al cliente
Route::get('/enviar/{id}', function ($id) {
	$albaran = Albaran::where('id', $id)->with('aviso')->with('detallealbaran')->with('albaranmaquina')->get();
	$aviso = Aviso::find($albaran[0]->aviso_id);
	$cliente= tbContacto::find($aviso->contacto_id);
	$empleado= Empleado::find($aviso->empleado_id);
	$maquina=[];
	if ($albaran[0]->albaranmaquina !== []){
		foreach($albaran[0]->albaranmaquina as $maq){
			$maquina[$maq->maquina_id]= Maquina::find($maq->maquina_id);
		}
	}
	$pdf = PDF::loadView('pdf/pdf', compact('albaran', 'cliente', 'empleado','maquina'));
	$pdf->save('albaranes/albaran' . $id . '.pdf');
	/*Configuracion de variables para enviar el correo*/
	$mail_username="cyberwichi@gmail.com";//Correo electronico saliente ejemplo: tucorreo@gmail.com
	$mail_userpassword="huertagomple";//Tu contraseña de gmail
	$mail_addAddress=$cliente->Email;//correo electronico que recibira el mensaje
	$template='
	<h1> Corrreo de envio de albaran</h1>
	<img src="/img/logo.jpeg"  style="margin:auto;" alt="">
	<h4> por favor no responda a este correo este es un mensaje atomatico para el envio de albaranes a clientes</h4>
	<p> correo enviado a: <strong>'.$cliente->Nombre.'</strong> </p>
	<p> albaran numero <strong> '.$id.' </strong> </p>
	<p> Gracias por su confianza</p>
	
	'; //Ruta de la plantilla HTML para enviar nuestro mensaje
				
	/*Inicio captura de datos enviados por $_POST para enviar el correo */
	$mail_setFromEmail=$mail_username;
	$mail_setFromName=$mail_username;
	$txt_message=$mail_username;
	$mail_subject="yo";
	try {
		$mail = new PHPMailer(true);
		$mail->isSMTP();   
		$mail->SMTPDebug = 2;                         // Establecer el correo electrónico para utilizar SMTP
		$mail->Host = 'smtp.gmail.com';             // Especificar el servidor de correo a utilizar 
		$mail->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
		$mail->Username = $mail_username;          // Correo electronico saliente ejemplo: tucorreo@gmail.com
		$mail->Password = $mail_userpassword; 		// Tu contraseña de gmail
		$mail->SMTPSecure = 'tls';                  // Habilitar encriptacion, `ssl` es aceptada
		$mail->Port = 587;                          // Puerto TCP  para conectarse 
		$mail->setFrom($mail_setFromEmail, $mail_setFromName);//Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
		$mail->addReplyTo($mail_setFromEmail, $mail_setFromName);//Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
		$mail->addAddress($mail_addAddress);   // Agregar quien recibe el e-mail enviado
		 $mail->addAttachment('albaranes/albaran' . $id . '.pdf');         // Add attachments
		$message = $template;
		$mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML
		
		$mail->Subject = $mail_subject;
		$mail->msgHTML($message);
		if(!$mail->send()) {
			echo '<p style="color:red">No se pudo enviar el mensaje..';
			echo 'Error de correo: ' . $mail->ErrorInfo;
			echo "</p>";
		} else {
			echo '<p style="color:green">Tu mensaje ha sido enviado!</p>';
		}
	}
	catch (Exception $e) {
		echo $e->getMessage();
	};
});