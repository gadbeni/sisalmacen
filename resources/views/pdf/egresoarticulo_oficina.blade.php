<!DOCTYPE html>
<html>
<head>
	<title>Detalle Egreso de Productos</title>
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
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Artículos/Productos Egresados por Oficina - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>

	<div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <tr>
                <th>Nro.</th>
                <th>Fecha egre.</th>
                <th>Nro. Pedido</th>
                <th>Preventivo</th>
                <th>Oficina</th>
                <th>Artículo</th>
                <th>Categoría</th>
                <th>Presentación</th>
                <th>Precio Uni.</th>
                <th>Cant.</th>
                <th>Total Parc.</th>
            </tr>
            <?php $numeroitems = 0; $suma_Total = 0; ?>
            @foreach($oficinas as $oficina)
                @foreach($oficina->egresodetalle as $edet)
            <?php $suma_Total += $edet->facturadetalle->preciocompra*$edet->cantidad; ?>
            <?php $numeroitems++ ?>
            <tr>
                <td style="width: 30px">{{$numeroitems}}</td>
                <td style="width: 50px">{{$oficina->fechasalida}}</td>
                <td style="width: 50px">{{$oficina->codigopedido}}</td>
                    <td style="width: 50px">
                    	@foreach($edet->solicitudcompra->preventivo as $prev)
                    	{{$prev->numeropreventivo}};
                    	@endforeach
                    </td>

                <td style="width: 250px">{{$oficina->direccionadministrativa->nombre}}<br><strong>{{$oficina->unidadadministrativa->nombre}}</strong></td>
                <td>{{$edet->facturadetalle->articulo->nombre}}</td>
                <td>{{$edet->facturadetalle->articulo->categoria->nombre}}</td>
                <td style="width: 60px">{{$edet->facturadetalle->articulo->presentacion}}</td>
                <td style="width: 60px">{{$edet->facturadetalle->preciocompra}} Bs.</td>
                <td style="width: 40px">{{$edet->cantidad}}</td>
                <td>{{number_format(($edet->facturadetalle->preciocompra*$edet->cantidad),2)}} Bs.</td>
            </tr>
             @endforeach
            @endforeach
        </table>
    </div>

    <div class="row">
        <table width="100%" align="center" style="font-size: 7pt">
            <tr>
                <th style="text-align: right">Total - Detalle de Egreso de Artículo por Oficina: {{NumerosEnLetras::convertir($suma_Total,'Bolivianos',true)}}</th>
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


