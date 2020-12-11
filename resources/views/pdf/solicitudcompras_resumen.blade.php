<!DOCTYPE html>
<html>
<head>
    <title>Resumen de Solicitudes de Compra</title>
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
       <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Resumen de Solicitudes de Compras - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>



    <div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <thead>
                <tr>
                    <th colspan="5">{{$entidad->nombre}}</th>
                </tr>
                <tr>
                    <th>Nro.</th>
                    <th>Fecha Solicitud</th>
                    <th>Nro. Solicitud</th>
                    <th>Proveedor</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <thead>
                <?php $numeroitems = 0; $suma_total = 0;?>
                @foreach($entidades as $entidad)
                <?php $suma_total += $entidad->factura->montofactura; ?>
                <?php $numeroitems++ ?>
                <tr>
                    <td>{{$numeroitems}}</td>
                    <td>{{$entidad->fechaingreso}}</td>
                    <td>{{$entidad->entidad->nombre}} - {{$entidad->numerosolicitud}}</td>
                    <td>{{$entidad->factura->proveedor->razonsocial}}</td>
                    <td>{{$entidad->factura->montofactura}} Bs.</td>
                </tr>
                @endforeach
            </thead>
        </table>
    </div>

    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <td style="text-align: right">Total Total:
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
