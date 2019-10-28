<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Modak|Roboto+Mono&display=swap" rel="stylesheet">
    <link href="{{asset('/css/open-iconic-bootstrap.min.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>

<body>
    <div id="app" class="container-fluid">
       

        {{--         <articulos-component class="mt-5"></articulos-component>
        <br>
        <contactos-component  class="mt-5"></contactos-component>
        <br>
        <pedidos-component  class="mt-5"></pedidos-component> --}}
        <principal-component></principal-component>


    </div>
    <script src="{{asset('js/app.js')}}"></script>
    
</body>

</html>