<!DOCTYPE html>
<html>
<head>
    <title>Resumen de Egresos por Pedidos</title>
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
       <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Resumen de Egresos por Pedidos - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>

    <div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>Fecha Egreso</th>
                    <th>Número de Pedido</th>
                    <th>Monto de Pedido</th>
                </tr>
            </thead>
            <thead>
                <?php $suma_total = 0; $numeroitems = 0;?>
                @foreach($egresos as $egreso)
                <?php $numeroitems++ ?>
                {{-- <?php $suma_total += $egreso->sumaNumeroPedido; ?> --}}
                <tr>
                    <td>{{$numeroitems}}</td>
                    <td>{{$egreso->fechasalida}}</td>
                    <td>{{$egreso->codigopedido}}</td>
                    <td>{{number_format(($egreso->egresodetalle->sum('totalbs')),2)}} Bs.</td>

                </tr>
                <?php $suma_total += $egreso->egresodetalle->sum('totalbs');?>
                @endforeach
            </thead>
        </table>
    </div>

    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <td style="text-align: right">Total Final:
                 {{NumerosEnLetras::convertir($suma_total,'Bolivianos',true)}}
                </td>
            </tr>
        </table>
    </div><br>

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
