<?php

use App\tbArticulo;
use App\tbContacto;
use App\tbStockArt;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
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
    try {
        $contactos = tbContacto::orderBy('Id')->get();
        return json_encode($contactos);
    } catch (\Throwable $th) {
        return $th;
    }
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


/* "PDOException: could not find driver in /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php:70\n
Stack trace:\n
#0 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php(70): PDO->__construct('dblib:host=den1...', 'satdemo1', 'Nr79_N284e5-', Array)
\n#1 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connectors/Connector.php(46): Illuminate\\Database\\Connectors\\Connector->createPdoConnection('dblib:host=den1...', 'satdemo1', 'Nr79_N284e5-', Array)
\n#2 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connectors/SqlServerConnector.php(32): Illuminate\\Database\\Connectors\\Connector->createConnection('dblib:host=den1...', Array, Array)
\n#3 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connectors/ConnectionFactory.php(182): Illuminate\\Database\\Connectors\\SqlServerConnector->connect(Array)
\n#4 [internal function]: Illuminate\\Database\\Connectors\\ConnectionFactory->Illuminate\\Database\\Connectors\\{closure}()
\n#5 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(920): call_user_func(Object(Closure))
\n#6 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(945): Illuminate\\Database\\Connection->getPdo()
\n#7 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(400): Illuminate\\Database\\Connection->getReadPdo()
\n#8 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(326): Illuminate\\Database\\Connection->getPdoForSelect(true)
\n#9 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(658): Illuminate\\Database\\Connection->Illuminate\\Database\\{closure}('select * from [...', Array)
\n#10 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(625): Illuminate\\Database\\Connection->runQueryCallback('select * from [...', Array, Object(Closure))
\n#11 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(334): Illuminate\\Database\\Connection->run('select * from [...', Array, Object(Closure))\n#12 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2140): Illuminate\\Database\\Connection->select('select * from [...', Array, true)\n#13 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2128): Illuminate\\Database\\Query\\Builder->runSelect()\n#14 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2572): Illuminate\\Database\\Query\\Builder->Illuminate\\Database\\Query\\{closure}()\n#15 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2129): Illuminate\\Database\\Query\\Builder->onceWithColumns(Array, Object(Closure))\n#16 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(521): Illuminate\\Database\\Query\\Builder->get(Array)\n#17 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(505): Illuminate\\Database\\Eloquent\\Builder->getModels(Array)\n#18 /var/app/current/routes/api.php(29): Illuminate\\Database\\Eloquent\\Builder->get()\n#19 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Route.php(205): Illuminate\\Routing\\RouteFileRegistrar->{closure}()\n#20 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Route.php(179): Illuminate\\Routing\\Route->runCallable()\n#21 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Router.php(680): Illuminate\\Routing\\Route->run()\n#22 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(130): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))\n#23 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(41): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#24 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(171): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#25 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Middleware/ThrottleRequests.php(59): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#26 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(171): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure), 60, '1')\n#27 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(105): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#28 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Router.php(682): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#29 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Router.php(657): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))\n#30 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Router.php(623): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))\n#31 /var/app/current/vendor/laravel/framework/src/Illuminate/Routing/Router.php(612): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))\n#32 /var/app/current/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(176): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))\n#33 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(130): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))\n#34 /var/app/current/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#35 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(171): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#36 /var/app/current/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#37 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(171): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#38 /var/app/current/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#39 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(171): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#40 /var/app/current/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/CheckForMaintenanceMode.php(62): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#41 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(171): Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#42 /var/app/current/vendor/fideloper/proxy/src/TrustProxies.php(57): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#43 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(171): Fideloper\\Proxy\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))\n#44 /var/app/current/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(105): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))\n#45 /var/app/current/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(151): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#46 /var/app/current/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(116): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))\n#47 /var/app/current/public/index.php(55): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))\n#48 {main}\n\nNext Illuminate\\Database\\QueryException: could not find driver (SQL: select * from [tbContacto] order by [Id] asc) in /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php:665\nStack trace:\n#0 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(625): Illuminate\\Database\\Connection->runQueryCallback('select * from [...', Array, Object(Closure))\n#1 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Connection.php(334): Illuminate\\Database\\Connection->run('select * from [...', Array, Object(Closure))\n#2 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2140): Illuminate\\Database\\Connection->select('select * from [...', Array, true)\n#3 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2128): Illuminate\\Database\\Query\\Builder->runSelect()\n#4 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2572): Illuminate\\Database\\Query\\Builder->Illuminate\\Database\\Query\\{closure}()\n#5 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Query/Builder.php(2129): Illuminate\\Database\\Query\\Builder->onceWithColumns(Array, Object(Closure))\n#6 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(521): Illuminate\\Database\\Query\\Builder->get(Array)\n#7 /var/app/current/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Builder.php(505): Illuminate\\Database\\Eloquent\\Builder->getModels(Array)\n#8 /var/app/current/routes/api.php(29): Illuminate\\Database\\Eloquent\\Builder->get()\n#9 /var/app/current/vendor/laravel/framework/src/Il... (15168 total length)" */