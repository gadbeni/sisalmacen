<!DOCTYPE html>
<html>
<head>
    <title>Comprobante de Entrega</title>
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
       <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Acta de Entrega de Materiales y Suministros<br>Código de Solicitud de Pedido [{{$egreso->codigopedido}}] - Fecha de Solicitud: {{\Carbon\Carbon::parse($egreso->fechasolicitud)->format('d/m/Y')}}</p>
    </header>

    <p>TRINIDAD, {{\Carbon\Carbon::parse($egreso->fechasalida)->format('d/m/Y - h:i A')}}</p>

    <div class="row">
        <table cellspacing="0" width="100%" align="center" style="font-size: 7pt">
            <tr>
                <th style="width: 100px">CUENTA:</th>
                <td style="text-align:left;">{{$egreso->cuenta->nombre}}</td>
            </tr>
            <tr>
                <th style="width: 100px">SOLICITANTE:</th>
                <td style="text-align:left;">{{$egreso->direccionadministrativa->nombre}} : {{$egreso->unidadadministrativa->nombre}}</td>
            </tr>
        </table>
    </div><br>

    <div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <tr>
                <th>Item</th>
                <th>Nro. Solicitud</th>
                <th>Articulo</th>
                <th>Cod. Articulo</th>
                <th>Presentación</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Total Parcial</th>
            </tr>
            <?php $numeroitems = 0; $sumatotalfactura = 0; ?>
            @foreach($egreso->egresodetalle as $det)
                <?php $sumatotalfactura += $det->totalbs; ?>
                <?php $numeroitems++ ?>
                <tr>
                    <td>{{$numeroitems}}</td>
                    <td>{{$det->solicitudcompra->entidad->nombre}} - {{$det->solicitudcompra->numerosolicitud}}</td>
                    <td>{{$det->facturadetalle->articulo->nombre}}</td>
                    <td>{{$det->facturadetalle->articulo->id}}</td>
                    <td>{{$det->facturadetalle->articulo->presentacion}}</td>
                    <td>{{$det->cantidad}}</td>
                    <td>{{$det->facturadetalle->preciocompra}} Bs.</td>
                    <td>{{number_format(($det->cantidad*$det->facturadetalle->preciocompra),2)}} Bs.</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <th style="text-align: right">Total Detalle de Egreso: {{NumerosEnLetras::convertir($sumatotalfactura,'Bolivianos',true)}}</th>
            </tr>
        </table>
    </div>
    <br><br><br><br>
    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <th>ENTREGUE CONFORME</th>
                <th>RECIBI CONFORME</th>
            </tr>
            <tr>
                <td>RESPONSABLE ALMACENES</td>
                <td>OFICINA SOLICITANTE</td>
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