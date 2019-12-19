<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Modak|Roboto+Mono&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="{{asset('/css/open-iconic-bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/print.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Calendario --}}
    <script src="https://unpkg.com/vue"></script>
  <script src="https://unpkg.com/vue-cal"></script>
  {{-- <link href="https://unpkg.com/vue-cal/dist/vuecal.css" rel="stylesheet"> --}}


</head>

<body>
    <div id="app">

        <div class="p-1">
            @yield('content')
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script src="{{asset('/js/print.js')}}"></script>
</body>

</html>