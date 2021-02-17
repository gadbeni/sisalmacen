<!DOCTYPE html>
<html>
<head>
    <title>Report dependencias</title>
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
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Reporte de Dependencias por Secretarias - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>

    <div class="row">
        <div  style="text-align: center">
        <H4>{{$direccionesadm->nombre}}</H4>
        </div>
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <br>
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                </tr>
            </thead>
            <tbody>
            <?php $numeroitems = 0;?>
            @forelse($unidades as $unidad)
                <tr>
                    <td style="text-align: center">{{ $unidad->codigo }}</td>
                    <td style="text-align: left">{{ $unidad->nombre }}</td>
                </tr>
                 <?php $numeroitems ++; ?>
                @empty
                <tr>
                    <th colspan="2">No cuenta con ninguna dependencia....</th>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <td style="text-align: right">Total Items;
                    {{ $numeroitems}}
                </td>
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