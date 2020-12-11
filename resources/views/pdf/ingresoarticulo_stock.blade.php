<!DOCTYPE html>
<html>
<head>
	<title>Ingreso de Artículo a Stock</title>
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
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Ingreso de Artículo a Stock (Solicitudes de Compras) - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>

    <div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Fecha Ing.</th>
                    <th>Solicitud Comp.</th>
                    <th>Preventivo</th>
                    <th>Proveedor</th>
                    <th>Factura</th>
                    <th>Artículo</th>
                    <th>Cod. Artículo</th>
                    <th>Categoría</th>
                    <th>Presentación</th>
                    <th>Precio Uni.</th>
                    <th>Cant.</th>
                    <th>Total Parc.</th>
                </tr>
            </thead>
            <tbody>
                <?php $numeroitems = 0; $suma_parcial = 0;?>
                @foreach($articulos as $articulo)
                    @foreach($articulo->factura->facturadetalle as $fdet)
                    <?php $suma_parcial += $fdet->preciocompra*$fdet->cantidadsolicitada; ?>
                    <?php $numeroitems++ ?>
                    <tr>
                        <td style="width: 30px">{{$numeroitems}}</td>
                        <td style="width: 50px">{{$articulo->fechaingreso}}</td>
                        <td style="width: 70px">{{$articulo->entidad->nombre}} - {{$articulo->numerosolicitud}}</td>
                            <td style="width: 50px">
                                @foreach($articulo->preventivo as $prev)
                                    {{$prev->numeropreventivo}};
                                @endforeach
                            </td>
                        <td>{{$articulo->factura->proveedor->razonsocial}}</td>
                        <td style="width: 60px">{{$articulo->factura->numerofactura}}</td>
                        <td>{{$fdet->articulo->nombre}}</td>
                        <td>{{$fdet->articulo->id}}</td>
                        <td>{{$fdet->articulo->categoria->nombre}}</td>
                        <td style="width: 60px">{{$fdet->articulo->presentacion}}</td>
                        <td style="width: 60px">{{$fdet->preciocompra}} Bs.</td>
                        <td style="width: 40px">{{$fdet->cantidadsolicitada}}</td>
                        <td>{{number_format(($fdet->preciocompra*$fdet->cantidadsolicitada),2)}} Bs.</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <td style="text-align: right">Total Final:
                    {{NumerosEnLetras::convertir($suma_parcial,'Bolivianos',true)}}
                </td>
            </tr>
        </table>
    </div><br>

    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
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
