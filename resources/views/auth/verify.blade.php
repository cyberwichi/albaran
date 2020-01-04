@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pendiente de autorizacion') }}</div>

                <div class="card-body">
                    

                    {{ __('Antes de empezar a operar debe ser autorizado por otro administrador.') }}
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
