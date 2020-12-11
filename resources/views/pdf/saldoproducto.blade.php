<!DOCTYPE html>
<html>
<head>
    <title>Saldo de Artículo/Producto</title>
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
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Saldo de Artículos/Productos - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>

    @foreach($categorias as $categoria)
        @if($categoria->articulos->count()>0)
        <div class="row">
            <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
                <thead>
                    <tr>
                        <th colspan="7"><strong>{{$categoria->nombre}}</strong></th>
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
                    <?php $numeroitems = 0; $suma_parcial = 0; $suma_total = 0;?>
                    @foreach($categoria->articulos as $art)
                    <?php $suma_parcial += $art->preciocompra*$art->cantidadrestante; ?>
                    <tr>
                        <td>{{$art->entidad}} - {{$art->numerosolicitud}}</td>
                        <td style="width:300px;">{{$art->articulo}}</td>
                        <td>{{$art->idarticulo}}</td>
                        <td>{{$art->presentacion}}</td>
                        <td>{{$art->preciocompra}}</td>
                        <td>{{$art->cantidadrestante}}</td>
                        <td>{{number_format(($art->preciocompra*$art->cantidadrestante),2)}} Bs.</td>
                    </tr>
                    @endforeach
                </thead>
            </table>
        </div>

        <div class="row">
            <table width="100%" align="center" style="font-size: 7pt">
                <tr>
                    <td style="text-align: right">Total Parcial:
                        {{NumerosEnLetras::convertir($suma_parcial,'Bolivianos',true)}}
                    </td>
                </tr>
            </table>
        </div><br>
        @endif
    @endforeach
        <div class="row">
            <table width="100%" align="center" style="font-size: 7pt">
                <tr>
                    <td style="text-align: right">Total Final - Categorías:
                        @foreach($sumaTotalFacturadetalle as $sumfdet)
                            {{NumerosEnLetras::convertir($sumfdet->sumaTotal,'Bolivianos',true)}}
                        @endforeach
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
