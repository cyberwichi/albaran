<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parte de Trabajo</title>
    <style>
        @page {
                margin: 300px 25px 350px 25px;
            }
        body{            
            font-size: 10px;            
            text-transform: uppercase;  
            box-sizing:  border-box;              
        }
       
        tr{
            max-width: 100%;
        }
        td{
            padding: 0 1px!important;
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
        /* margin-bottom: 1px;      */
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
        .pageauto{         
          page-break-inside: avoid;
        }
        header{
            position: fixed;
                top: -300px;
                left: 0px;
                right: 0px;
                height: 220px;
        }
        footer{
            position: fixed; 
                bottom: -240px; 
                left: 0px; 
                right: 0px;
                height: 250px;
                font-size: 8px;
                
        }
        footer .page:after { content: counter(page, upper-roman); }

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
    
</head>
<body>

    <header>        
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
                                @if ($albaran[0]->aviso)
                                {{$albaran[0]->aviso->created_at }}
                                @endif
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
                                <div>Cliente: {{ $cliente['Nombre'] }}</div>
                                <div>Direccion: {{ $cliente['Direccion'] }}</div>
                                <div>Telefono: {{ $cliente['Telefono'] }}</div>
                                <div>Nif: {{ $cliente['Nif'] }}</div>
                                 <div>Trabajo Finalizado :
                        @if($albaran[0]->aviso)
                            @if ($albaran[0]->aviso->terminada)
                            <strong>Si</strong>
                            @else
                            <strong>No</strong>
                            @endif
                            @endif
                        
                        </div>
                               
                            </div>
        
                    </td>
                </tbody>
        </table>
        <div class="fondo"></div>
    </header>
     <footer>
         <!-- observaciones -->
            <table class="tabla1 firmas">
            <thead class="text-center">
                        <tr class="center">
                           
                            <th scope="col">  <strong>Observaciones / Material Pendiente</strong></th>                          
                          
                        </tr>
                    </thead>
                <tbody>
                <tr>
                   
                    <td  class="firmas">
                        
                        <p style="overflow:hidden;height:30px">{!! $albaran[0]->observaciones !!}</p>
                    </td>
                </tr>
                <tr>
                    <td  class="firmas">
                        <div class="center">
                            <strong>Trabajos Realizados</strong>
                        </div>
                    </td>
                    </tr><tr>
                    <td  class="firmas">                        
                        <p style="overflow:hidden;height:80px">{!! $albaran[0]->trabajos !!}</p>
                    </td>
                </tr>    
                </tbody>
            </table>
            <!-- firmas -->
            <div class="firmas" style="height:120px">
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
        </footer>  
    <main class="">   
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
        
            <table class="tabla1  firmas" style="margin-top:5px">
                    <thead class="text-center">
                        <tr class="center">
                            <th scope="col">Referencia</th>
                            <th scope="col"></th>
                            <th scope="col">Articulos</th>
                            <th scope="col"></th>
                            <th scope="col">Entregados</th>
                            <th scope="col"></th>
                            <th scope="col">Cantidad</th>
                            
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
                            	
                        </tr>
                        @endforeach
                    </tbody>
            </table>
         
    </main>
   </body>
</html>