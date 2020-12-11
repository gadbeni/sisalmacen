<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Proveedores</title>
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
        <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Reporte de Proveedores - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
    </header>

    <div class="row">
        <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
            <thead>
                <tr>
                    <th>NIT</th>
                    <th>RAZON SOCIAL</th>
                    <th>REPONSABLE</th>
                    <th>DIRECCION</th>
                    <th>TELEFONO</th>
                </tr>
            </thead>
            <tbody>
            @foreach($proveedores as $proveedor)
                <tr>
                    <td style="text-align: left">{{ $proveedor->nit }}</td>
                    <td style="text-align: left">{{ $proveedor->razonsocial }}</td>
                    <td style="text-align: left">{{ $proveedor->responsable }}</td>
                    <td style="text-align: left">{{ $proveedor->direccion }}</td>
                    <td style="text-align: left">{{ $proveedor->telefono }}</td>
                </tr>
            @endforeach
            </tbody>
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