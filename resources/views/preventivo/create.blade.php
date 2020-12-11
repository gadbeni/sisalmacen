@extends('layouts.app')
@section('title','Crear Preventivo')
<style>
  	input[type=text] {
    	background-color: #F9F8A6;
  	}

  	input[type=number] {
    	background-color: #F9F8A6;
  	}

  	table th {
        text-align: center;
    }

    table td {
        text-align: center;
    }

    .loader{
    	text-align: center;
    	color:#ff6e4a;
    	display: none
  	}
</style>
@section('content')

<div class="loader">
	<h4>Por favor espere, Se está enviando el formulario! <img src="{{asset('theme/dist/img/loader.gif')}}" width="100px"> </h4>
</div>

<form id="form" action="{{route('preventivo.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-12">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Preventivo</h3>
					<div class="card-tools">
                        <a href="{{ route('preventivo.index') }}"><button type="button" class="btn btn-default" title="Volver a la lista de preventivos."><i class="fas fa-history"></i></button></a>
                    </div>
				</div>
				<div class="card-body">
					<h5>Preventivo de Solicitud de Compra:</h5>
					<div class="row">
	                    <!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <select required name="sucursal_id" class="form-control form-control-sm select2bs4">
					                    @foreach ($sucursales as $sucursal)
						                  <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
						                @endforeach
					                 </select>
	                            </div>
	                            <small>Sucursal del Usuario (Usuario del Sistema).</small>
	                        </div>
	                    </div>
	                    <!-- === -->
	                   	<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <select required id="solicitudcompra_id" class="form-control form-control-sm select2bs4">
	                                	<option disabled selected value="">Seleccionar Solicitud de Compra</option>
					                    @foreach ($solicitudcompras as $solicitudcompra)
						                  <option value="{{$solicitudcompra->id}}_{{$solicitudcompra->montofactura}}">{{$solicitudcompra->solicitudcompra}}</option>
						                @endforeach
					                 </select>
	                            </div>
	                            <small>Solicitudes de Compras.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
	                        </div>
	                        <!-- input axiliar -->
              				<input type="hidden" id="idsolicitudcompra_input" class="form-control">
	                    </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" readonly id="montocompra" placeholder="MONTO DE SOLICITUD DE COMPRA (FACTURA).">
	                            </div>
	                            <small>Monto de Factura de la Solicitud de Compra.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <select required id="proyecto_id" class="form-control form-control-sm select2bs4">
	                                	<option disabled selected value="">Seleccionar Proyecto</option>
					                    @foreach ($proyectos as $proyecto)
						                  <option value="{{$proyecto->id}}_{{$proyecto->direccionadministrativa}}_{{$proyecto->unidadejecutora}}">{{$proyecto->proyecto}}</option>
						                @endforeach
					                 </select>
	                            </div>
	                            <small>Seleccionar Proyecto.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
	                        </div>
	                        <!-- input axiliar -->
              				<input type="hidden" id="idproyecto_input" class="form-control">
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" readonly id="direccionadministrativa_id" placeholder="DIRECCION ADMINISTRATIA.">
	                            </div>
	                            <small>Dirección Administrativa.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" readonly id="unidadadministrativa_id" placeholder="UNIDAD ADMINISTRATIVA.">
	                            </div>
	                            <small>Unidad Administrativa.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <select required id="partida_id" class="form-control form-control-sm select2bs4">
					                    @foreach ($partidas as $partida)
						                  <option value="{{$partida->id}}">{{$partida->partida}}</option>
						                @endforeach
					                 </select>
	                            </div>
	                            <small>Seleccionar Partida.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="number" class="form-control form-control-sm" id="numeropreventivo" name="numeropreventivo" placeholder="MONTO DE PREVENTIVO.">
	                            </div>
	                            <small>Número de Preventivo.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="number" class="form-control form-control-sm" id="monto" placeholder="MONTO DE PREVENTIVO." onkeyup="validar_monto()">
	                            </div>
	                            <small>Monto Preventivo.</small>
	                        </div>
	                    </div>
						<!-- === -->
					</div>
				</div>

				<div class="container-fluid">
				    <div class="row justify-content-center">
				        <div class="col-md-12">
				        	<!-- === -->
				        	<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                            	<button type="button" id="bt_add" class="btn btn-success"><i class="fas fa-plus"></i>
		                            	Agregar Proyecto + Partida + Preventivo</button>
		                            </div>
		   	                    </div>
		                    </div>
		                    <!-- === -->
			                <div class="body table-responsive">
			                    <table id="detalles" class="table table-bordered table-striped" style="font-size: 9pt">
			                        <thead style="background-color: #6c757d; color: white;">
				                          <th>Opción</th>
				                          <th>Solicitud Comp.</th>
				                          <th>Proyecto</th>
				                          <th>Partida</th>
				                          <th>Número Preventivo</th>
				                          <th>SubTotal</th>
			                        </thead>
			                        <tfoot>
			                          		<th colspan="5" style="text-align:right"><h5>TOTAL</h5></th>
                          					<th><h4 id="total">Bs. 0.00</h4></th>
			                        </tfoot>
			                      </table>
			                </div>
				        </div>
				    </div>
				</div>

				<div class="card-footer" id="guardar">
					@include('preventivo.partials.actions')
				</div>
			</div>
		</div>
		<!-- === -->
	</div>
</div>

</form>

@endsection

@push ('styles')
	<!-- Select2 -->
    <link rel="stylesheet" href="{{asset('theme/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush

@push ('script')
	<!-- Select2 -->
    <script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>

	<script>
		$(document).ready(function() {
			$('.select2bs4').select2({});

			$('#bt_add').click(function() {
		    	agregar();
		  	});
		});

		//Filtrar datos de solicitud de compra
	  	$("#solicitudcompra_id").change(mostrarMontofactura);
		function mostrarMontofactura()
		{
		datoMontofactura = document.getElementById('solicitudcompra_id').value.split('_');
			$("#idsolicitudcompra_input").val(datoMontofactura[0]);
			$("#montocompra").val(datoMontofactura[1]);
		}

		//Filtrar datos de proyectos
		$("#proyecto_id").change(mostrarValoresProyecto);
		function mostrarValoresProyecto()
		{
		datoProyecto = document.getElementById('proyecto_id').value.split('_');
			$("#idproyecto_input").val(datoProyecto[0]);
			$("#direccionadministrativa_id").val(datoProyecto[1]);
			$("#unidadadministrativa_id").val(datoProyecto[2]);
		}

		//variables.
		var cont=0;
		total=0;
		subtotal=[];

		//funcion agregar datos a la tabla.
		function agregar()
		{
			solicitudcompra=$("#solicitudcompra_id option:selected").text();
		    solicitudcompra_id	=$("#idsolicitudcompra_input").val();
		    proyecto_id=$("#idproyecto_input").val();
		    proyecto=$("#proyecto_id option:selected").text();
		    partida_id=$("#partida_id").val();
		    partida=$("#partida_id option:selected").text();
		    numeropreventivo=$("#numeropreventivo").val();
		    monto=$("#monto").val();

		    let detalle_subtotal = parseFloat(calcular_total()) + parseFloat(monto);
		    let monto_total = parseFloat($('#montocompra').val());

		    if (detalle_subtotal>monto_total){
		      alert('Error, el monto del preventivo excede el monto de la factura.')
		      return 0;
		    }

		    if (solicitudcompra_id!="" && numeropreventivo>0 && monto>0) {
		    	subtotal = monto;

		      	var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-success" onclick="eliminar('+cont+')";>X</button></td><td><input type="hidden" name="solicitudcompra_id[]" value="'+solicitudcompra_id	+'">'+solicitudcompra+'</td><td><input type="hidden" name="proyecto_id[]" value="'+proyecto_id+'">'+proyecto+'</td><td ><input type="hidden" name="partida_id[]" value="'+partida_id+'">'+partida+'</td><td><input type="hidden" name="numeropreventivo[]" value="'+numeropreventivo+'">'+numeropreventivo+'</td><td><input type="hidden" class="span6 m-wrap input_subtotal" name="monto[]" value="'+subtotal+'">'+subtotal+'</td></tr>';

		        cont++;
		        limpiar();
		        $('#detalles').append(fila);
		        $("#total").html("Bs. "+calcular_total().toFixed(2));
		        evaluar();
		        if(detalle_subtotal==monto_total)
		        {
		          $('#btn_guardar').removeAttr('disabled');
		        }
		    }else {
		    	alert("Error, Seleccionar solicitud de compra y proyecto.\n\nNúmero de preventivo y monto de preventivo las cantidades deben ser Mayor que cero.");
		    	}
		}

		//funcion limpiar.
		function limpiar()
		{
		  	$("#numeropreventivo").val("");
		  	$("#monto").val("");
		}

		//funcion evaluar boton guardar.
		$("#guardar").hide();
		function evaluar()
		{
		  	if(calcular_total()>0) {
		    	$("#guardar").show();
		  	}else {
		    	$("#guardar").hide();
		  		}
		}

		//eliminar filas en la tabla
		function eliminar(index)
		{
		  	total=total-subtotal[index];
		  	$("#total").html("Bs/." + total);
		  	$("#fila" + index).remove();
		  	$("#total").html("Bs. "+calcular_total().toFixed(2));
		  	evaluar();
		  	$('#btn_guardar').attr('disabled', true);
		}

		//calcular total de factura
		function calcular_total(){
		  	let total = 0;
		  	$(".input_subtotal").each(function(){
		    	total += parseFloat($(this).val());
		  	});
		  	return total;
		}

		// Validacion de monto de solicitud
		function validar_monto()
		{
		  	let monto_compra = parseFloat($('#montocompra').val());
		  	let monto = parseFloat($('#monto').val());

		  	if(monto_compra<monto) {
		    	$('#monto').val('');
		    	alert('Error, el monto del preventivo excede el monto de la factura.');
		  	}
		}

		//mensaje de espera de enviado de formulario
		$('#form').on('submit', function(e) {
		    $('.loader').css('display', 'block')
		    document.getElementById("btn_guardar").disabled = true;
		    //e.preventDefault();
		});

	</script>
@endpush
