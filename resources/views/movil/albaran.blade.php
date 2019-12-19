@extends('layouts.app2')

@section('content')
<div>
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
  <nuevoalbaran-component :numeroaviso="{{$id}}" ></nuevoalbaran-component>
</div>
@endsection