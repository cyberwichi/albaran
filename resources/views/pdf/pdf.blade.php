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
            margin: 0;
            padding: 5px;
            text-align: center;
        }
        .imfirma img{        
            margin:0px 50px;
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
        text-align: right; 
        width: 100%;

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
</head>
<body>
    <div class="contenido">
        <div id="">
            <img class="cabecera" src="img/cabecera.jpeg" alt="" />
            
            <h4>
                
            </h4>
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
                    <td  class="itemcabecera">
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
                            <!-- maquinas -->
                    <div class="tabla1 firmas">
                        <table  class="tabla1 itemcabecera center">
                            <thead >
                                <tr>
                                    <th class="itemcabecera" scope="col">Maquina</th>
                                    <th class="itemcabecera" scope="col">Numero de Serie</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($albaran[0]->albaranmaquina as $maq)
                                <tr class="center" >
                                    <th class="firmas itemcabecera">{{ $maquina[$maq->maquina_id]->nombre }}</th>
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
                   <h5 class="center">Articulos Entregados</h5>
                    
                        <table class="tabla1 table table-primary">
                            <thead class="">
                                <tr>
                                    <th scope="col">Referencia</th>
                                    <th scope="col" >Articulo</th>
                                    <th scope="col" ></th>
                                    <th scope="col" ></th>
                                    <th scope="col" ></th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $subtotal =0 ?>
                                @foreach($albaran[0]->detalleAlbaran  as $linea2 )
                                <tr>
                                    <td class="firmas center">{{ $referencias[$linea2->articulo_id]->referencia}}</td>
                                    <td colspan="4" class="firmas center">{{ $linea2->articulo_nombre }}</td>
                                    <td class="firmas right">{{ $linea2->cantidad }}</td>
                                    <td class="firmas right">{{ $linea2->precio }}</td>
                                   <?php $subtotal += $linea2->cantidad * $linea2->precio ?>
                                </tr>
                                @endforeach
                                <tr class="p-2">
                                    <td colspan="1" class="firmas right">
                                        <strong>Subtotal : {{ $subtotal }}€</strong>
                                    </td>
                                    <td colspan="1" class="firmas right "> 
                                        <strong>21% Iva : {{ round(($subtotal * 0.21), 2) }}€</strong>
                                    </td>
                                    <td colspan="4" class="firmas right">
                                        <strong>Total : {{ round(($subtotal * 0.21) + $subtotal, 2) }}€</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>                    
                </div>

                <!-- observaciones -->
                <div class="firmas">
                    <div class="">
                        <h5>
                            Trabajo Finalizado :
                            @if ($albaran[0]->aviso->terminada)
                            <strong>Si</strong>
                            @else
                            <strong>No</strong>
                            @endif

                        </h5>
                    </div>
                    <div class="">
                        <h5>
                        <strong>Observaciones / Material Pendiente</strong>
                        </h5>
                        <p>{{ $albaran[0]->observaciones }}</p>
                    </div>
                </div>                
                  
                <!-- firmas -->
                <div class="firmas">
                    <div class="">
                        <h4>Firmas</h4>
                    </div>
                    <div class="linfirma">
                        <div class="imfirma">
                            Cliente
                            <img id="firmacli" width="100" height="100" src="{{$albaran[0]->firma_cliente}}" />
                            <img id="firmaemp" width="100" height="100" src="{{$albaran[0]->firma_empleado}}" />
                            Empleado
                        </div>
                    </div>
                </div>


        </div>
    </div>

    <div class="firmas faldon">
        C.I.F. B-72177827 - Telefono 956 59 125 -Pol. Ind. Puente Hierro, Crta. de la Carraca 74 - 11100 San Fernando (Cádiz) - gestion.aif@gmail.com - Movil: 685 696 156</div>
</body>
</html>