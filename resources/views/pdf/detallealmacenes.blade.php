<!DOCTYPE html>
<html>
<head>
  <title>Artículo Egresado</title>

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
    <p>{{$sucursal->sucursal}}<br>DETALLE DE ALMACENES (BIENES DE CONSUMO) <br>{{\Carbon\Carbon::parse($fechainicio)->format('d/m/Y')}} al {{\Carbon\Carbon::parse($fechafin)->format('d/m/Y')}}</p>
    
  </header>

  <div class="row">
    <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
      <thead>
          <tr>
            <th>Nro.</th>
            <th>DESCRIPCION (ITEM).</th>
            <th>UNIDAD DE MEDIDA.</th>
            <th>PRECIO UNITARIO.</th>
            <th>SALDO INICIAL.</th>
            <th>ENTRADAS.</th>
            <th>SALIDAS.</th>
            <th>SALDO FINAL.</th>
            <th>SALDO INICIAL.</th>
            <th>ENTRADAS.</th>
            <th>SALIDAS.</th>
            <th>SALDO FINAL.</th>
        </tr>
      </thead>
      <tbody>
        <?php $cantinicial = 0; $cantfinal = 0; $saldoinicial = 0; $saldofinal = 0; $n=1;?>
                
      </tbody>
    </table>
  </div>

  <div class="row">
    <table width="100%" align="center" style="font-size: 7pt">
      <tr>
        <th style="text-align: right">Monto Total de Artículos Egresados: </th>
      </tr>
    </table>
  </div>
  <div class="text-center">
    <p style="font-size: 13px;"><b>NOTA:</b> La información expuesta en el presente cuadro cuenta con la documentacion de soporte correspondiente, en el marco de las normas Básicas del Sistema de Contabilidad Integrada.</p>
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
