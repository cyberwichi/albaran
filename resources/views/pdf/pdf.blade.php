<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parte de Trabajo</title>
    <style>
        body{
            margin: 0;
            padding: 0; 
            font-size: 12px;
            box-sizing: border-box;
            text-transform: uppercase;                   
        }
        .fondo{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200%;
            height: 100%;
            z-index: -1;
            background-image: url('/img/logo.jpeg');
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            opacity: 0.1;

        }
        tr{
            max-width: 100%;
        }
        td{
            padding: 5px!important;
        }
        .itemcabecera{
            width: 50%;
            font-size:10px; 
        }
        .tabla1{
            width:100%;
        }
        .imfirma{
            width: 100%;
            text-align: center;
        }
        .imfirma img{        
            margin:10px 50px;
        }
        .linfirma{
            display: flex;
            width: 100%;           
        }
        .cabecera {
        width: 100%;
        height: 200px;
        margin-bottom: 5px;
        }
        .center{
        text-align: center; 
        width: 100%;   
        }
        .right{
        text-align: center; 
        width: 50%;

        }
        .right-2{
        text-align: right; 
        width: 30%;

        }
        .right-3{
        text-align: right; 
        }
        .faldon {
        width: 100%;
        text-align: center;
        font-size: 8px;
        }
        .firmas {
        border: 1px solid #000;
        margin-bottom: 1px;     
        }
        
        h1 {
            text-align: center;
            text-transform: uppercase;
        }
    
        #primero {
            background-color: #ccc;
        }
    
        #segundo {
            color: #44a359;
        }
    
        #tercero {
            text-decoration: line-through;
        }
        .head{
            position:fixed;
            top: 0;
        }
        .foot{
            position:absolute;
            bottom: 2mm;
        }
        .cuerpo{
            margin-top:75mm;         
        }
        .articulo{
            height: 5mm!important;
            overflow: hidden;
        }
        .total {
            width: 58mm;
        }
        .finalizado
        {
            width: 35mm;
        }
</head>
<body>
<div class="fondo"></div>

    <div class="contenido">
        <div class="head">
            <img class="cabecera" src="img/cabecera.jpeg" alt="" />
        
            <table class="tabla1 firmas">
                <tbody>
                    <td class="itemcabecera">
                        <!-- Aviso -->
                        <div class="">
                            <div>
                                <strong>
                                    Parte de Trabajo numero: {{ $albaran[0]->id }}
                                </strong>
                            </div>
        
                            <div>
                                Numero de aviso : {{ $albaran[0]->aviso_id }}
                            </div>
        
                            <div>
                                Fecha Aviso:
                                {{$albaran[0]->aviso->created_at }}
                            </div>
                            <div>
                                Fecha del Parte:
                                {{$albaran[0]->created_at}}
                            </div>
                            <div>
                                Empleado asignado: {{$empleado->name }}
                            </div>
                        </div>
                    </td>
                    <td class="itemcabecera">
                        <!- Cliente-!>
                            <div>
                                <div>Cliente: {{ $cliente->Nombre }}</div>
                                <div>Direccion: {{ $cliente->Direccion }}</div>
                                <div>Telefono: {{ $cliente->Telefono }}</div>
                                <div>Nif: {{ $cliente->Nif }}</div>
                                <div>Email: {{ $cliente->Email }}</div>
                            </div>
        
                    </td>
                </tbody>
            </table>
        </div>
        <div class="cuerpo">
            <!-- maquinas -->
            <div class="tabla1 firmas">
                <table class="tabla1 center">
                    <thead>
                        <tr>
                            <th class="itemcabecera" scope="col">Maquina</th>
                            <th class="itemcabecera" scope="col">Numero de Serie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($albaran[0]->albaranmaquina as $maq)
                        <tr class="center">
                            <td class="firmas itemcabecera">{{ $maquina[$maq->maquina_id]->nombre }}</td>
                            <td class="firmas itemcabecera">
                                {{ $maq->referencia }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- articulos entregados -->
            <div class="firmas">
                <table class="tabla1">
                    <thead class="text-center">
                        <tr class="center">
                            <th scope="col">Referencia</th>
                            <th scope="col"></th>
                            <th scope="col">Articulos</th>
                            <th scope="col"></th>
                            <th scope="col">Entregados</th>
                            <th scope="col"></th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $subtotal =0 ?>
                        @foreach($albaran[0]->detalleAlbaran as $linea2 )
                        <tr>
                            @if (isset( $referencias[$linea2->articulo_id]))
                            <td class="firmas right">{{ $referencias[$linea2->articulo_id]->referencia}}</td>
                            @else
                            <td class="firmas right"> sin referencia</td>
                            @endif
                            <td colspan="5" class="firmas center articulo">{{ substr($linea2->articulo_nombre , 0, 40) }}</td>
                            <td class="firmas right-2">{{ $linea2->cantidad }}</td>
                            <td class="firmas right-2">{{ $linea2->precio }}</td>
                            <?php $subtotal += $linea2->cantidad * $linea2->precio ?>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        
        </div>
        <div class="foot">
            <table class="tablas1">
                <tr class="p-2">
                    <td colspan="2" class="firmas right-3 total">
                        <strong>Subtotal : {{ $subtotal }}€</strong>
                    </td>
                    <td colspan="3" class="firmas right-3 total">
                        <strong>21% Iva : {{ round(($subtotal * 0.21), 2) }}€</strong>
                    </td>
                    <td colspan="3" class="firmas right-3 total">
                        <strong>Total : {{ round(($subtotal * 0.21) + $subtotal, 2) }}€</strong>
                    </td>
                </tr>
            </table>
        
            <!-- observaciones -->
            <table class="tabla1 firmas">
                <tbody>
                <tr>
                    <td class="finalizado firmas">
                        <div>Trabajo Finalizado :
                            @if ($albaran[0]->aviso->terminada)
                            <strong>Si</strong>
                            @else
                            <strong>No</strong>
                            @endif
                        </div>
                    </td>
                    <td class="firmas">
                        <div class="center">
                            <strong>Observaciones / Material Pendiente</strong>
                        </div>
                        <p>{{ $albaran[0]->observaciones }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="firmas">
                        <div class="center">
                            <strong>Trabajos Realizados</strong>
                        </div>
                        <p>{{ $albaran[0]->trabajos }}</p>
                    </td>
                </tr>    
                </tbody>
            </table>
        
            <!-- firmas -->
            <div class="firmas">
                <div class="linfirma">
                    <div class="imfirma">
                        Firma Cliente
                        <img id="firmacli" width="100" height="100" src="{{$albaran[0]->firma_cliente}}" />
                        <img id="firmaemp" width="100" height="100" src="{{$albaran[0]->firma_empleado}}" />
                        Firma Empleado
                    </div>
                </div>
            </div>
            <div class="firmas faldon">
                C.I.F. B-72177827 - Telefono 956 59 125 -Pol. Ind. Puente Hierro, Crta. de la Carraca 74 - 11100 San Fernando
                (Cádiz) - gestion.aif@gmail.com - Movil: 685 696 156
            </div>
        </div>    
    </div>    
</body>
</html>