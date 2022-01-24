<!DOCTYPE html>
<html>
<head>
  <title>Artículo Egresado</title>
  <link rel="stylesheet" href="{{ asset('css/print.style.css') }}" media="print">
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
<div class="noImprimir text-center">
  <button onclick="javascript:window.print()" class="btn btn-link">
      IMPRIMIR
  </button>
</div>
<body>
  <header>
    <p>{{$sucursal->sucursal}}<br>RESUMEN DE ALMACENES (BIENES DE CONSUMO) <br></p>
    
  </header>

  <div class="row">
    <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
      <thead>
          <tr>
            <th>Nro.</th>
            <th>Partida.</th>
            <th>Categotia.</th>
            <th>Articulo.</th>
            <th>Cantidad Inicial.</th>
            <th>Saldo Inicial.<br> <b>(Bs)</b>.</th>
            <th>Cantidad Final.</th>
            <th>Saldo Final<br> <b>(Bs)</b>.</th>
        </tr>
      </thead>
      <tbody>
        <?php $cantinicial = 0; $cantfinal = 0; $saldoinicial = 0; $saldofinal = 0; $n=1;?>
                @foreach($data as $item)
                    <tr>
                        <td style="width: 30px">{{$n}}</td>
                        <td style="width: 30px"></td>
                        <td style="width: 30px">{{$item->categoria}}</td>
                        <td style="width: 30px">{{$item->articulo}}</td>
                        <td style="width: 50px">{{round($item->cantinicial)}}</td>
                        <td style="width: 50px">{{$item->saldoinicial}}</td>
                        <td style="width: 50px">{{round($item->cantfinal)}}</td>
                        <td style="width: 50px">{{$item->saldofinal}}</td>
                    </tr>
                    <?php $cantinicial +=round($item->cantinicial); 
                          $cantfinal +=round($item->cantfinal); 
                          $saldoinicial +=$item->saldoinicial; 
                          $saldofinal +=$item->saldofinal;
                    ?>
                    <?php $n++;?>
                @endforeach
                
                <tr>
                  <td style="width: 30px"></td>
                  <td style="width: 30px"></td>
                  <td style="width: 30px"></td>
                  <td style="width: 30px">Total</td>
                  <td style="width: 50px">{{$cantinicial}}</td>
                  <td style="width: 50px">{{$saldoinicial}}</td>
                  <td style="width: 50px">{{$cantfinal}}</td>
                  <td style="width: 50px">{{$saldofinal}}</td>
              </tr>
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
