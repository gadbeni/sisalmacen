<html mmoznomarginboxes="" mozdisallowselectionprint="">
    <head>
        <title>RESUMEN ALMACEN</title>
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
                margin-left: auto;
                margin-right: auto;
                /*border: 1px solid #777;*/
                display: grid;
                padding: 10mm !important;
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
                                        <h4 style="font-size: 22px;"><strong>{{$sucursal->sucursal}}<br>RESUMEN DE ALMACENES (BIENES DE CONSUMOS)</strong></h4>
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
                    <th>Partida.</th>
                    <th>Cantidad Inicial.</th>
                    <th>Saldo Inicial.<br> <b>(Bs)</b>.</th>
                    <th>Cantidad Final.</th>
                    <th>Saldo Final<br> <b>(Bs)</b>.</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=0;$cantinicial = 0; $cantfinal = 0; $saldoinicial = 0; $saldofinal = 0; $n=1;

                        $codigo=0; $cinicial=0; $sinicial=0; $cfinal=0; $sfinal=0;

                        $codigo=$data[0]->codigo; 
                        $cinicial=$data[0]->cantinicial;
                        $sinicial=$data[0]->saldoinicial;
                        $cfinal=$data[0]->cantfinal;
                        $sfinal=$data[0]->saldofinal;


                        $cat = count($data);
                    ?>
                @foreach($data as $item)
                    
                    @if($i>=1)
                        @if($item->codigo == $data[$i-1]->codigo)
                            <?php
                                $cinicial +=number_format((float)$item->cantinicial, 2, '.', '');
                                $sinicial +=number_format((float)$item->saldoinicial, 2, '.', '');
                                $cfinal +=number_format((float)$item->cantfinal, 2, '.', '');
                                $sfinal +=number_format((float)$item->saldofinal, 2, '.', '');


                            ?>
                        @else
                            <tr>
                                <td style="width: 30px">{{$n}}</td>
                                <td style="width: 30px">{{$data[$i-1]->codigo}}</td>
                                <td style="width: 30px">{{number_format((float)$cinicial, 2, '.', '')}}</td>
                                <td style="width: 30px">{{number_format((float)$sinicial, 2, '.', '')}}</td>
                                <td style="width: 30px">{{number_format((float)$cfinal, 2, '.', '')}}</td>
                                <td style="width: 30px">{{number_format((float)$sfinal, 2, '.', '')}}</td>
                            </tr>
                            
                            <?php
                                $cantinicial += $cinicial;
                                $cantfinal += $cfinal;
                                $saldoinicial += $sinicial;
                                $saldofinal +=$sfinal;

                                $cinicial=round($item->cantinicial);
                                $sinicial=$item->saldoinicial;
                                $cfinal=$item->cantfinal;
                                $sfinal =$item->saldofinal;
                                $n++;
                            ?>
                        @endif

                        
                        
                    @else


                    @endif
                    
                    <?php
                        $i++;
                    ?>
                    
                @endforeach

                <tr>
                    <td style="width: 30px">{{$n++}}</td>
                    <td style="width: 30px">{{$item->codigo}}</td>
                    <td style="width: 30px">{{number_format((float)$cinicial, 2, '.', '')}}</td>
                    <td style="width: 30px">{{number_format((float)$sinicial, 2, '.', '')}}</td>
                    <td style="width: 30px">{{number_format((float)$cfinal, 2, '.', '')}}</td>
                    <td style="width: 30px">{{number_format((float)$sfinal, 2, '.', '')}}</td>
                </tr>



                <tr>
                  <td style="width: 30px"></td>
                  
                  <td style="width: 30px">Total</td>
                  <td style="width: 50px">{{number_format((float)$cantinicial+$cinicial, 2, '.', '')}}</td>
                  <td style="width: 50px">{{number_format((float)$saldoinicial+$sinicial, 2, '.', '')}}</td>
                  <td style="width: 50px">{{number_format((float)$cantfinal+$cfinal, 2, '.', '')}}</td>
                  <td style="width: 50px">{{number_format((float)$saldofinal+$sfinal, 2, '.', '')}}</td>
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