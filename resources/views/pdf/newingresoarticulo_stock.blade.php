<html mmoznomarginboxes="" mozdisallowselectionprint="">
    <head>
        <title>INGR</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/print.style.css') }}" media="print">
        <style type="text/css">
            html
            {
                background-color: #FFFFFF; 
                margin: 0px;  /* this affects the margin on the html before sending to printer */
            }
            body {
                font-size: 14px !important;
            }
            table {
                font-size: 10px !important;
            }
            .centrar{
                width: 240mm;
                margin-left: auto;
                margin-right: auto;
                /*border: 1px solid #777;*/
                display: grid;
                padding: 10mm !important;
                -webkit-box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1);
                -moz-box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1);
                box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1);
            }
            /*For each sections*/
            .box-section {
                margin-top: 1mm;
                border: 1px solid #000;
                padding: 8px;
            }
            .alltables {
                width: 100%;
            }
            .alltables td{
                padding: 2px;
            }
            .box-margin {
                border: 1px solid #000;
                width: 120px;
            }
            .caja {
                border: 1px solid #000;
            }
        </style>
    </head>
    <body>
        <div class="noImprimir text-center">
            <button onclick="javascript:window.print()" class="btn btn-link">
                IMPRIMIR
            </button>
        </div>
        <div class="centrar">
            {{-- ENCABEZADO --}}
            <table class="alltables text-center">
                <tbody>
                    <tr>
                        <td><img src="{{ asset('images/lg.png') }}" width="100px"></td>
                        <td>
                            <table class="alltables">
                                <tr>
                                    <td  class="text-center">
                                        <h4 style="font-size: 22px;"><strong>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI</strong></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 40%">
                                        <span style="font-size: 20px;">
                                            <strong>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS</strong>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="width: 40%">
                                        <span style="font-size: 15px;">
                                            <strong>Artículos|Productos Egresados de Stock - Trinidad</strong>
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
           
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nº.</th>
                        <th>F. Ing.</th>
                        <th>Sol. Comp.</th>
                        <th>Prev</th>
                        <th>Proveedor</th>
                        <th>Factura</th>
                        <th>Artículo</th>
                        <th>Cod. Artículo</th>
                        <th>Unidad</th>
                        <th>Precio</th>
                        <th>Cant.</th>
                        <th>Subtotal.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $numeroitems = 0; $suma_parcial = 0;?>
                    @forelse ($articulos as $articulo)
                        @foreach ($articulo->factura->facturadetalle as $fdet)
                            <?php 
                                $suma_parcial += $fdet->preciocompra*$fdet->cantidadsolicitada; 
                                $numeroitems++
                            ?>
                            <tr>
                                <td>{{$numeroitems}}</td>
                                <td>{{$articulo->fechaingreso}}</td>
                                <td>{{$articulo->entidad->nombre}} - {{$articulo->numerosolicitud}}</td>
                                    <td>
                                        @foreach($articulo->preventivo as $prev)
                                            {{$prev->numeropreventivo}};
                                        @endforeach
                                    </td>
                                <td>{{$articulo->factura->proveedor->razonsocial}}</td>
                                <td>{{$articulo->factura->numerofactura}}</td>
                                <td>{{$fdet->articulo->nombre}}</td>
                                <td>{{$fdet->articulo->id}}</td>
                                <td>{{$fdet->articulo->presentacion}}</td>
                                <td>{{$fdet->preciocompra}} Bs.</td>
                                <td>{{$fdet->cantidadsolicitada}}</td>
                                <td>{{number_format(($fdet->preciocompra*$fdet->cantidadsolicitada),2)}} Bs.</td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="10"></td>
                            <td>SIN DATOS</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="row" style="font-size: 9pt">
                <p style="text-align: right">Total - Final:   {{NumerosEnLetras::convertir($suma_parcial,'Bolivianos',true)}}</p>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th colspan="2">Resumen de Solicitudes de Compras</th>
                    </tr>
                    <tr>
                        <th>Solicitudes de Compras:</th>
                        <th>Motos de Compras:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sumaTotalSolcomp as $sumSolComp)
                    <tr>
                        <td>{{$sumSolComp->entidad}} - {{$sumSolComp->numerosolicitud}}</td>
                        <td style="text-align: left;">{{NumerosEnLetras::convertir($sumSolComp->sumaSolcomp,'Bolivianos',true)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- end section body --}}
            <div class="text-center">
                <p style="font-size: 13px;"><b>NOTA:</b> Este reporte muestra a detalle los productos ingresados de fecha {{$fechainicio}} hasta {{$fechafin}}.</p>
            </div>
            <div>
                <table style="width: 100%;">
                    <tr>
                        <td class="text-left" style="font-size: 10px;">{{ 'Imprimido por: ' . auth()->user()->name }}</td>
                        <td class="text-right" style="font-size: 10px;">{{ 'Fecha y hora de impresión: ' . date('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
    </div>
    </body>
</html>