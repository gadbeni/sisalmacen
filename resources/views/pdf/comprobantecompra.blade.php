<!DOCTYPE html>
<html>
<head>
    <title>Comprobante de Compra</title>

</head>
<style>

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
        height: 2.3cm;
        background-color: #46C66B;
        color: white;
        text-align: center;
        line-height: 15px;
    }

</style>
<body>
    <header>
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Acta de Recepción de Materiales y Suministros<br>Solicitud de Compra [{{$factura->solicitudcompra->entidad->nombre}} - {{$factura->solicitudcompra->numerosolicitud}}/{{\Carbon\Carbon::parse($factura->created_at)->format('Y')}}]</p>
    </header>

    <div class="row">
        <table width="100%" align="center" style="font-size: 8pt">
            <tr>
                <th>PROVEEDOR</th>
                <th>NIT</th>
                <th>FACTURA(S)</th>
                <th>FECHA INGRESO</th>
            </tr>
            <tr>
                <td>{{$factura->proveedor->razonsocial}}</td>
                <td>{{$factura->proveedor->nit}}</td>
                <td>{{$factura->numerofactura}}</td>
                <td>{{\Carbon\Carbon::parse($factura->solicitudcompra->fechaingreso)->format('Y/m/d')}}</td>
            </tr>
        </table>
    </div>

    <div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 8pt">
            <tr>
                <th>Item</th>
                <th>Articulo</th>
                <th>Cod. Articulo</th>
                <th>Presentación</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Total Parcial</th>
            </tr>
                <?php $numeroitems = 0; $sumatotalfactura = 0; $totalitems = 0; ?>
                @foreach($factura->facturadetalle as $det)
                <?php $sumatotalfactura += $det->cantidadsolicitada*$det->preciocompra; ?>
                <?php $numeroitems++ ?>
            <tr>
                <td>{{$numeroitems}}</td>
                <td>{{$det->articulo->nombre}}</td>
                <td>{{$det->articulo->id}}</td>
                <td>{{$det->articulo->presentacion}}</td>
                <td>{{$det->cantidadsolicitada}}</td>
                <td>{{number_format(($det->totalbs/$det->cantidadsolicitada),2)}} Bs.</td>
                <td>{{$det->cantidadsolicitada*$det->preciocompra}} Bs.</td>
            </tr>
                @endforeach
        </table>
    </div>

    <div class="row">
        <table width="100%" align="center" style="font-size: 8pt">
            <tr>
                <th style="text-align: right">Total Detalle de Compra: {{NumerosEnLetras::convertir($sumatotalfactura,'Bolivianos',true)}}</th>
            </tr>
        </table>
    </div>
    <br><br><br><br>
    <div class="row">
        <table width="100%" align="center" style="font-size: 8pt">
            <tr>
                <th>RECIBIDO</th>
                <th>RECIBIDO</th>
                <th>ENTREGADO</th>
            </tr>
            <tr>
                <td>RESPONSABLE ALMACENES</td>
                <td>JEFE DE ADQUISICIONES</td>
                <td>PROVEEDOR</td>
            </tr>
        </table>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(270, 820, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
            ');
        }
    </script>

</body>
</html>

