<!DOCTYPE html>
<html>
<head>
  <title>Prveedor - Detalle de Compras</title>
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
    <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Proveedor - Detalle de Compra - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
</header>

    <?php $suma_total = 0;?>
    @foreach($proveedores as $item)
        <div class="row">
            <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 6pt">
                <thead>
                    <tr>
                        <th colspan="10">{{$item->proveedor->razonsocial}}</th>
                    </tr>
                    <tr>
                        <th>Fecha Factura</th>
                        <th>Solicitud Comp.</th>
                        <th>Factura</th>
                        <th>Artículo</th>
                        <th>Cod. Artículo</th>
                        <th>Categoría</th>
                        <th>Presentación</th>
                        <th>Precio Uni.</th>
                        <th>Cant.</th>
                        <th>Total Parc.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($item->facturadetalle as $fdet)
                    <?php $suma_total += $fdet->preciocompra*$fdet->cantidadsolicitada;?>
                    <tr>
                        <td style="width: 50px">{{$item->fechafactura}}</td>
                        <td style="width: 60px">{{$item->solicitudcompra->entidad->nombre}} {{$item->solicitudcompra->numerosolicitud}}</td>
                        <td style="width: 80px">{{$item->numerofactura}}</td>
                        <td style="width: 300px">{{$fdet->articulo->nombre}}</td>
                        <td style="width: 40px">{{$fdet->articulo->id}}</td>
                        <td style="width: 200px">{{$fdet->articulo->categoria->nombre}}</td>
                        <td style="width: 70px">{{$fdet->articulo->presentacion}}</td>
                        <td style="width: 60px">{{$fdet->preciocompra}}</td>
                        <td style="width: 40px">{{$fdet->cantidadsolicitada}}</td>
                        <td>{{number_format(($fdet->preciocompra*$fdet->cantidadsolicitada),2)}} Bs.</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><br>
    @endforeach

    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <td style="text-align: right">Total Total:
                    {{NumerosEnLetras::convertir($suma_total,'Bolivianos',true)}}
                </td>
            </tr>
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