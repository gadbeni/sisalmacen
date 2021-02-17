<!DOCTYPE html>
<html>
<head>
    <title>All Dependency</title>
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
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Secretarias con sus dependencias - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>
    <?php $numeroitems = 0;?>
    @foreach($direcciones as $direccion)
        @if($direccion->unidades->count()>0)
        <?php $numeroitems += $direccion->unidades->count();?>
        <div class="row">
            <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
                <thead>
                    <tr>
                        <th colspan="2"><strong>{{$direccion->nombre}}</strong></th>
                    </tr>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <thead>
                    @foreach($direccion->unidades as $unid)
                    <tr>
                        <td>{{$unid->codigo}}</td>
                        <td style="width:300px;">{{$unid->nombre}}</td>
                    </tr>
                    @endforeach
                </thead>
            </table>
        </div>
        <br>
        @endif
    @endforeach
    <br>
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
