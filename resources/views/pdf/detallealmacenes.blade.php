<!DOCTYPE html>
<html>
<head>
  <title>Reporte Detalle Almacen</title>
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
    <p>{{$sucursal->sucursal}}<br>DETALLE DE ALMACENES (BIENES DE CONSUMO) <br></p>
    
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
        <?php $ccinicial = 0; $ccentrada = 0; $ccsalida = 0; $ccsaldofinal = 0;
              $binicial = 0; $bentrada = 0; $bsalida = 0; $bsaldofinal = 0; 
        $n=1;?>
        @foreach($data as $item)
            <tr>
                <td style="width: 30px">{{$n}}</td>
                <td style="width: 30px">{{$item->nombre}}</td>
                <td style="width: 30px">{{$item->presentacion}}</td>
                <td style="width: 50px">{{$item->preciocompra}}</td>

                <td style="width: 50px">{{round($item->cinicial)}}</td>
                <td style="width: 50px">{{round($item->centrada)}}</td>
                <td style="width: 50px">{{round($item->csalida)}}</td>
                <td style="width: 50px">{{round($item->saldofinal)}}</td>

                <td style="width: 50px">{{round($item->BSsaldoinicial)}}</td>
                <td style="width: 50px">{{round($item->BSentrada)}}</td>
                <td style="width: 50px">{{round($item->BSsalida)}}</td>
                <td style="width: 50px">{{round($item->BSsaldofinal)}}</td>
            </tr>
            <?php 
                 $ccinicial += round($item->cinicial);
                 $ccentrada += round($item->centrada);
                 $ccsalida += round($item->csalida);
                 $ccsaldofinal += round($item->saldofinal);
                 $binicial += round($item->BSsaldoinicial);
                 $bentrada += round($item->BSentrada);
                 $bsalida +=round($item->BSsalida);
                 $bsaldofinal += round($item->BSsaldofinal);
            ?>
            <?php $n++;?>
        @endforeach

        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td><b>TOTAL</b></td>
          <td style="width: 30px">{{$ccinicial}}</td>
          <td style="width: 30px">{{$ccentrada}}</td>
          <td style="width: 30px">{{$ccsalida}}</td>
          <td style="width: 30px">{{$ccsaldofinal}}</td>
          <td style="width: 50px">{{$binicial}}</td>
          <td style="width: 50px">{{$bentrada}}</td>
          <td style="width: 50px">{{$bsalida}}</td>
          <td style="width: 50px">{{$bsaldofinal}}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="row">
    <table width="100%" align="center" style="font-size: 7pt">
      <tr>
        {{-- <th style="text-align: right">Monto Total de Artículos Egresados: </th> --}}
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
