<!DOCTYPE html>
<html>
<head>
    <title>Saldo de Productos por Categorías</title>
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
       <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Saldo de Categoría - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>



    <div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <thead>
                <tr>
                    <th colspan="7">{{$categoria->nombre}}</th>
                </tr>
                <tr>
                    <th>Sol. Compra</th>
                    <th>Artículo</th>
                    <th>Cod. Artículo</th>
                    <th>Presentación</th>
                    <th>Precio Uni.</th>
                    <th>Cantidad</th>
                    <th>Total Parc.</th>
                </tr>
            </thead>
            <thead>
                 <?php $suma_total = 0;?>
                @forelse($facturadetalles as $fdet)
                    <?php $suma_total += $fdet->preciocompra*$fdet->cantidadrestante; ?>
                    <tr>
                        <td>{{$fdet->factura->solicitudcompra->entidad->nombre}} - {{$fdet->factura->solicitudcompra->numerosolicitud}}</td>
                        <td style="width:300px;">{{$fdet->articulo->nombre}}</td>
                        <td>{{$fdet->articulo->id}}</td>
                        <td>{{$fdet->articulo->presentacion}}</td>
                        <td>{{$fdet->preciocompra}}</td>
                        <td>{{$fdet->cantidadrestante}}</td>
                        <td>{{number_format(($fdet->preciocompra*$fdet->cantidadrestante),2)}} Bs.</td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7">No existen datos de la categoría: {{$categoria->nombre}}</td>
                    </tr>
                @endforelse
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
