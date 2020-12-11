<!DOCTYPE html>
<html>
<head>
    <title>Kardex de Artículo</title>
</head>
<style>
    #watermark {
        position: fixed;
        top: 25%;
        width: 100%;
        text-align: center;
        opacity: .15;
        transform-origin: 50% 50%;
        z-index: -1000;
    }

    /*centrado de datos th + td*/
    table th {
        text-align: center;
    }

    /*centrado de datos th + td*/
    table td {
        text-align: center;
    }

    /*Margenes*/
    @page {
        margin: 0cm 0cm;
        font-size: 1em;
    }

    /*Margenes*/
    body {
        margin: 2.5cm 1cm 1cm;
    }

    /*Encabezado del Reporte (Titulos)*/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
        background-color: #46C66B;
        color: white;
        text-align: center;
        line-height: 15px;
    }

    /*Efecto striped*/
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

</style>
<body>
    <header>
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Kardex de Solicitud de Compra - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>

        <div class="row">
            <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
                <thead>
                    <tr>
                        @foreach($solcomp_factura as $sfac)
                        <th colspan="7">
                            {{$sfac->entidad->nombre}} - {{$sfac->numerosolicitud}} : Monto de Factura: {{$sfac->factura->montofactura}}
                        </th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>Fecha Solicitud</th>
                        <th>Categoría</th>
                        <th>Artículo</th>
                        <th>Presentación</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad Solicitada</th>
                        <th>Cantidad Restante</th>
                    </tr>
                </thead>
                <thead>
                    @foreach($solicitudescompras as $Solcomp)
                        @foreach($Solcomp->factura->facturadetalle as $fdet)
                        <tr>
                            <td>{{$Solcomp->fechaingreso}}</td>
                            <td style="width: 180pt">{{$fdet->articulo->categoria->nombre}}</td>
                            <td style="width: 200pt">{{$fdet->articulo->nombre}}</td>
                            <td>{{$fdet->articulo->presentacion}}</td>
                            <td>{{$fdet->preciocompra}}</td>
                            <td>{{$fdet->cantidadsolicitada}}</td>
                            <td>{{$fdet->cantidadrestante}}</td>
                        </tr>
                        @endforeach
                    @endforeach
                </thead>
            </table>
        </div><br>

        <div class="row">
            <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
                <thead>
                    <tr>
                        <th colspan="8">Detalle Egreso de Artículos</th>
                    </tr>
                    <tr>
                        <th>Fecha Egreso</th>
                        <th>Solic. Compra</th>
                        <th>Nro. Pedido</th>
                        <th>Oficina</th>
                        <th>Categoría</th>
                        <th>Artículo</th>
                        <th>Presentación</th>
                        <th>Cant. Egresada</th>
                    </tr>
                </thead>
                <thead>
                    @foreach($egresodetalles as $egredet)

                        <tr>
                            <td style="width: 50pt">{{\Carbon\Carbon::parse($egredet->egreso->fechasalida)->format('d/m/Y')}}</td>
                            <td style="width: 60pt">{{$egredet->solicitudcompra->entidad->nombre}} - {{$egredet->solicitudcompra->numerosolicitud}}</td>
                            <td style="width: 40pt">{{$egredet->egreso->codigopedido}}</td>
                            <td style="width: 190pt">{{$egredet->egreso->unidadadministrativa->nombre}}</td>
                            <td style="width: 150pt">{{$egredet->facturadetalle->articulo->categoria->nombre}}</td>
                            <td style="width: 170pt">{{$egredet->facturadetalle->articulo->nombre}}</td>
                            <td>{{$egredet->facturadetalle->articulo->presentacion}}</td>
                            <td style="width: 60pt">{{$egredet->cantidad}}</td>
                        </tr>

                    @endforeach
                </thead>
            </table>
        </div>

        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(400, 570, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
                ');
            }
        </script>
</body>
</html>
