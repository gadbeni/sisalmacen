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
    <p>GOBIERNO AUTONOMO DEPARTAMENTAL DEL BENI<br>UNIDAD DE ALMACENES MATERIALES Y SUMINISTROS<br>Artículos/Productos Egresados (Cantidades) - Trinidad, <?php $time = time(); echo date("d-m-Y", $time); ?></p>
  </header>

  <div class="row">
    <table cellspacing="0" width="100%" align="center" border="1" style="font-size: 7pt">
	    <tr>
	    	  <th>Nro.</th>
          <th>Fecha Egre.</th>
          <th>Nro Pedido.</th>
	       	<th>Solic. Comp.</th>
          <th>Oficina</th>
          <th>Categoría</th>
	       	<th>Artículo.</th>
          <th>Cod. Artículo</th>
	       	<th>presentación</th>
	       	<th>Precio Uni.</th>
	       	<th>Cant.</th>
	       	<th>Total Parc.</th>
	    </tr>
	      <?php $numeroitems = 0; $suma_total = 0; ?>
	      @foreach($articulos as $art)
          @foreach($art->egresodetalles as $egr)
          <?php $suma_total += $egr->totalbs; ?>
          <?php $numeroitems++ ?>
      <tr>
      		<td>{{$numeroitems}}</td>
          <td style="width: 40pt">{{\Carbon\Carbon::parse($egr->fechasalida)->format('d/m/Y')}}</td>
          <td style="width: 40pt">{{$egr->codigopedido}}</td>
	        <td style="width: 50pt">{{$egr->solicitudcompra}}</td>
          <td style="width: 120pt">{{$egr->oficina}}</td>
          <td style="width: 120pt">{{$art->categoria}}</td>
	        <td style="width: 120pt">{{$art->articulo}}</td>
          <td>{{$art->id}}</td>
	        <td>{{$art->presentacion}}</td>

	        <td>{{number_format(($egr->totalbs/$egr->cantidadegresada),2)}} Bs.</td>
	        <td>{{$egr->cantidadegresada}}</td>
	        <td>{{$egr->totalbs}} Bs.</td>
      </tr>
      	  @endforeach
        @endforeach
    </table>
  </div>

  <div class="row">
    <table width="100%" align="center" style="font-size: 7pt">
      <tr>
        <th style="text-align: right">Monto Total de Artículos Egresados: {{NumerosEnLetras::convertir($suma_total,'Bolivianos',true)}}</th>
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
