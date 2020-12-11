<!DOCTYPE html>
<html>
<head>
    <title>Inventario Anual</title>
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
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>DETALLE DE INGRESOS Y EGRESOS SECCION ALMACENES - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>

    <div class="row">

        <table width="100%" style="font-size: 10pt">
           <thead>
                <tr>
                    <th style="text-align:left;">SALDO INVENTARIO INICIAL GESTION {{$anio}}</th>
                    <th style="text-align:right">{{$saldoinicial->monto ?? 0}}</th>
                </tr>
            </thead>
        </table>
        <br/>
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <thead>
                <tr>
                    <th>MES.</th>
                    <th>INGRESOS</th>
                    <th>EGRESOS</th>
                    <th>SALDOS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $saldo = $saldoinicial->monto ?? 0;
                    $totalingresos= $reporte->sum('ingresos');
                    $totalegresos= $reporte->sum('egresos');
                ?>
                @foreach($reporte as $report)
                <?php $saldo+= $report['ingresos'] - $report['egresos']?>
                    <tr>
                        <td style="width: 30px">{{$report['mes']}}</td>
                        <td style="width: 30px">{{$report['ingresos']}}</td>
                        <td style="width: 30px">{{$report['egresos']}}</td>
                        <td style="width: 30px">{{$saldo}}</td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        <br>
        <table width="100%" style="font-size: 10pt">
           <thead>
            <tr>
                <th style="text-align:left;">SALDO INVENTARIO FINAL GESTION {{$anio}}</th>
                <th style="text-align:right">{{$saldo}}</th>
            </tr>
          </thead>
        </table>
    </div>
    <br>
    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <thead>
                <tr>
                    <th colspan="2">TOTALES DE INGRESOS Y EGRESOS</th>
                </tr>
                <tr>
                    <th>INGRESOS:</th>
                    <th>EGRESOS:</th>
                </tr>
                 <tr>
                   <th>{{$totalingresos}}</th>
                   <th>{{$totalegresos}}</th>
                 </tr>
            </thead>
            <tbody>

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