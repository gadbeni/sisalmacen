<!DOCTYPE html>
<html>
<head>
    <title>Preventivo</title>
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
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Acta de Preventivo de Solicitud de Compra<br>Solicitud de Compra [{{$solcomp_preventivo->entidad->nombre}} : {{$solcomp_preventivo->numerosolicitud}}] - Monto Factura: {{$solcomp_preventivo->factura->montofactura}} Bs.</p>
    </header>
    
    <p>TRINIDAD, <?php $time = time(); echo date("d-m-Y (H:i:s)", $time); ?></p>
   
    <div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <tr>
                <th>Nro.</th>
                <th>Dirección Admi.</th>
                <th>Unidad Admi.</th>
                <th>Proyecto</th>
                <th>Partida</th>
                <th>Nro. Preventivo</th>
                <th>Monto Parcial</th>
            </tr>
            <?php $numeroitems = 0; $sumatotalfactura = 0; ?>
            @foreach($solcomp_preventivo->preventivo as $det)
            <?php $sumatotalfactura += $det->monto; ?>
            <?php $numeroitems++ ?>
            <tr>
                <td>{{$numeroitems}}</td>
                <td>{{$det->proyecto->direccionadministrativa->nombre}}</td>
                <td>{{$det->proyecto->unidadadministrativa->nombre}}</td>
                <td>{{$det->proyecto->nombre}}</td>
                <td>{{$det->partida->nombre}}</td>
                <td>{{$det->numeropreventivo}}</td>
                <td>{{$det->monto}}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <th style="text-align: right">Total Monto de Preventivos: {{NumerosEnLetras::convertir($sumatotalfactura,'Bolivianos',true)}}</th>
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