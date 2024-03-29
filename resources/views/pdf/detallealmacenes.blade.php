<html mmoznomarginboxes="" mozdisallowselectionprint="">
    <head>
        <title>DETALLE ALMACEN</title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/print.style.css') }}" media="print">
        <style type="text/css">
            html
            {
                background-color: #FFFFFF; 
                margin: 0px;  /* this affects the margin on the html before sending to printer */
            }
            body {
                font-size: 14px !important;
            }
            table {
                font-size: 10px !important;
            }
            .centrar{
                width: 240mm;
                margin-left: 5;
                margin-right: 5;
                /*border: 1px solid #777;*/
                display: grid;
                padding: 1mm !important;
                /* -webkit-box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1);
                -moz-box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1);
                box-shadow: inset 2px 2px 46px 1px rgba(209,209,209,1); */
            }
            /*For each sections*/
            .box-section {
                margin-top: 1mm;
                border: 1px solid #000;
                padding: 8px;
            }
            .alltables {
                width: 100%;
            }
            .alltables td{
                padding: 2px;
            }
            .box-margin {
                border: 1px solid #000;
                width: 120px;
            }
            .caja {
                border: 1px solid #000;
            }
        </style>
    </head>
    <body>
        <div class="noImprimir text-center">
            <button onclick="javascript:window.print()" class="btn btn-link">
                IMPRIMIR
            </button>
        </div>
        <div class="centrar">
            {{-- ENCABEZADO --}}
            <table class="alltables text-center">
                <tbody>
                    <tr>
                        {{-- <td><img src="{{ asset('images/lg.png') }}" width="100px"></td> --}}
                        <td>
                            <table class="alltables">
                                <tr>
                                    <td  class="text-center">
                                        <h4 style="font-size: 22px;"><strong>{{$sucursal->sucursal}}<br>DETALLE DE ALMACENES (BIENES DE CONSUMO)</strong></h4>
                                    </td>
                                </tr>
                                
                                  
                                <tr>
                                    {{-- <td class="text-center" style="width: 40%">
                                        <span style="font-size: 15px;">
                                            <strong>{{$anio}}</strong>
                                        </span>
                                    </td> --}}
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
           
            <table class="table table-striped table-bordered">
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
          
                          <td style="width: 50px">{{number_format((float)$item->cinicial, 2, '.', '')}}</td>
                          <td style="width: 50px">{{number_format((float)$item->centrada, 2, '.', '')}}</td>
                          <td style="width: 50px">{{number_format((float)$item->csalida, 2, '.', '')}}</td>
                          <td style="width: 50px">{{number_format((float)$item->saldofinal, 2, '.', '')}}</td>
          
                          <td style="width: 50px">{{number_format((float)$item->BSsaldoinicial, 2, '.', '')}}</td>
                          <td style="width: 50px">{{number_format((float)$item->BSentrada, 2, '.', '')}}</td>
                          <td style="width: 50px">{{number_format((float)$item->BSsalida, 2, '.', '')}}</td>
                          <td style="width: 50px">{{number_format((float)$item->BSsaldofinal, 2, '.', '')}}</td>
                      </tr>
                      <?php 
                          //  $ccinicial += round($item->cinicial);
                          //  $ccentrada += round($item->centrada);
                          //  $ccsalida += round($item->csalida);
                          //  $ccsaldofinal += round($item->saldofinal);
                          //  $binicial += round($item->BSsaldoinicial);
                          //  $bentrada += round($item->BSentrada);
                          //  $bsalida +=round($item->BSsalida);
                          //  $bsaldofinal += round($item->BSsaldofinal);


                           $ccinicial += number_format((float)$item->cinicial, 2, '.', '');
                           $ccentrada += number_format((float)$item->centrada, 2, '.', '');
                           $ccsalida += number_format((float)$item->csalida, 2, '.', '');
                           $ccsaldofinal += number_format((float)$item->saldofinal, 2, '.', '');
                           $binicial += number_format((float)$item->BSsaldoinicial, 2, '.', '');
                           $bentrada += number_format((float)$item->BSentrada, 2, '.', '');
                           $bsalida += number_format((float)$item->BSsalida, 2, '.', '');
                           $bsaldofinal += number_format((float)$item->BSsaldofinal, 2, '.', '');
                      ?>
                      <?php $n++;?>
                  @endforeach
          
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>TOTAL</b></td>
                    <td style="width: 30px">{{number_format((float)$ccinicial, 2, '.', '')}}</td>
                    <td style="width: 30px">{{number_format((float)$ccentrada, 2, '.', '')}}</td>
                    <td style="width: 30px">{{number_format((float)$ccsalida, 2, '.', '')}}</td>
                    <td style="width: 30px">{{number_format((float)$ccsaldofinal, 2, '.', '')}}</td>
                    <td style="width: 50px">{{number_format((float)$binicial, 2, '.', '')}}</td>
                    <td style="width: 50px">{{number_format((float)$bentrada, 2, '.', '')}}</td>
                    <td style="width: 50px">{{number_format((float)$bsalida, 2, '.', '')}}</td>
                    <td style="width: 50px">{{number_format((float)$bsaldofinal, 2, '.', '')}}</td>
                  </tr>
                </tbody>
            </table>
            <div class="row" style="font-size: 9pt">
                {{-- <p style="text-align: right">Total - Final:   {{NumerosEnLetras::convertir($suma_parcial,'Bolivianos',true)}}</p> --}}
            </div>
            

            {{-- end section body --}}
            <div class="text">
                <p style="font-size: 13px;"><b>NOTA:</b> La información expuesta en el presente cuadro cuenta con la documentacion de soporte correspondiente, en el marco de las Normas Básicas del Sistema de Contabilidad Integrada.</p>
            </div>
            
  
       
        <div class="card-body">
            <div class="row">
                <div class="text-center col-6">
                    <br>
                    <br>
                    <br>
                    ________________________________________
                    <br>
                    <b>Firma Contabilidad</b>
                </div>
                <div class="text-center col-6">
                    <br>
                    <br>
                    <br>
                    ________________________________________
                    <br>
                    <b>Firma Responsable</b>
                </div>
            </div>
            <div class="row">
                <div class="text-center col-3">
                    
                </div>
                <div class="text-center col-6">
                    <br>
                    <br>
                    <br>
                    ________________________________________
                    <br>
                    <b>Firma DGAA-DAF</b>
                    <br>
                </div>
                <div class="text-center col-3">
                    
                </div>
            </div>
        </div>  
          
 
            {{-- <div>
                <table style="width: 100%;">
                    <tr>
                        <td class="text-left" style="font-size: 10px;">{{ 'Imprimido por: ' . auth()->user()->name }}</td>
                        <td class="text-right" style="font-size: 10px;">{{ 'Fecha y hora de impresión: ' . date('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div> --}}
    </div>
    </body>
</html>