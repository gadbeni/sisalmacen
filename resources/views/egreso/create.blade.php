@extends('layouts.app')
@section('title','Crear Egreso de Artículo/Producto')
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

@include('partials.errors')

<form id="form" action="{{route('egreso.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Egreso de Artículo/Producto</h3>
					<div class="card-tools">
                        <a href="{{ route('egreso.index') }}"><button type="button" class="btn btn-default" title="Volver a la lista de egresos."><i class="fas fa-history"></i></button></a>
                    </div>
				</div>
				<div class="card-body">
					<h5>Número de Pedido + Oficina Solicitante:</h5>
						<div class="row">
							<!-- === -->
							<div class="col-sm-6">
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
		                    <div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required id="direccionadministrativa_id" name="direccionadministrativa_id" class="form-control form-control-sm select2bs4">
						                  	<option selected value="">Seleccionar Dirección Administrativa</option>
						                    @foreach ($direccionadministrativas as $direccionadministrativa)
							                  <option value="{{$direccionadministrativa->id}}">{{$direccionadministrativa->nombre}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccionar Dirección Administrativa.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
		                        </div>
		                    </div>
		                    <!-- === -->
		                    <div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required id="unidadadministrativa_id" name="unidadadministrativa_id" class="form-control form-control-sm select2bs4">
					                   		<option value="">{{__("Seleccionar Dirección Administrativa")}}</option>
					                  	</select>
		                            </div>
		                            <small>Seleccionar Unidad Administrativa.</small> <a href="" data-toggle="modal" data-target="#modal-create_dependencia" title="Crear Nueva Unidad Administrativa."><i class="fas fa-plus-circle"></i> Crear Unidad Administrativa.</a>
		                        </div>
		                    </div>
		                    <!-- === -->
							<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" required id="codigopedido" name="codigopedido" placeholder="Introducir número de Pedido." autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
		                            </div>
		                            <small>Código de Pedido.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="date" class="form-control" id="fechasolicitud" name="fechasolicitud">
		                            </div>
		                            <small>Fecha Solicitud.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="datetime-local" class="form-control" id="fechasalida" name="fechasalida">
		                            </div>
		                            <small>Fecha Salida.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select name="cuenta_id" class="form-control form-control-sm select2bs4">
						                    @foreach ($cuentas as $cuentas)
							                  <option value="{{$cuentas->id}}">{{$cuentas->nombre}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccionar cuenta.</small>
		                        </div>
		                    </div>
		                    <!-- === -->
						</div>
					<hr>
					<h5>Egreso de Artículo/producto - Detalle:</h5>
						<div class="row">
							<!-- === -->
							 <div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required id="solicitudcompra_id" name="solicitudcompra_id" class="form-control form-control-sm select2bs4">
						                  	<option selected value="">Seleccionar Solicitud de Compra</option>
						                    @foreach ($solicitudcompras as $solicitudcompra)
							                  <option value="{{$solicitudcompra->id}}">{{$solicitudcompra->solicitudcompra}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccionar Solicitud de Compra.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
		                        </div>
		                    </div>
		                    <!-- === -->
							<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select id="idarticulo_select2bs4" required name="articulo_id" class="form-control form-control-sm select2bs4">
							              <option value="">{{__("Seleccionar Solicitud de Compra")}}</option>
							            </select>
		                            </div>
		                            <small>Seleccionar Artículo/Producto.</small>
		                        </div>
		                    </div>
		                    <!-- === -->
		                    <div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" readonly class="form-control form-control-sm" id="codigoarticulo" placeholder="Código">
		                            </div>
		                            <small>Codigo Artículo.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" readonly class="form-control form-control-sm" id="nombrecategoria" placeholder="Categoría Artículo.">
		                            </div>
		                            <small>Categoría.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" readonly class="form-control form-control-sm" id="presentacion" placeholder="Presentación Artículo.">
		                            </div>
		                            <small>Presentación.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" readonly class="form-control form-control-sm" id="precio" placeholder="Precio.">
		                            </div>
		                            <small>Precio.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" readonly class="form-control form-control-sm" id="stock" placeholder="Stock de Artículo.">
		                            </div>
		                            <small>Stock Artículo.</small>
		                        </div>
		                    </div>
		                    <!-- input axiliar-->
        					<input type="hidden" id="idfacturadetalle" class="form-control">
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" id="cantidad" placeholder="Introducir cantidad a egresar." autocomplete="off">
		                            </div>
		                            <small>Cantidad.</small>
		                        </div>
		                    </div>
							<!-- === -->
						</div>
				</div>

				<div class="container-fluid">
				    <div class="row justify-content-center">
				        <div class="col-md-12">
				        	<!-- === -->
				        	<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                            	<button type="button" id="bt_add" class="btn btn-success"><i class="fas fa-plus"></i> Agregar Artículo</button>
		                            </div>
		   	                    </div>
		                    </div>
		                    <!-- === -->
			                <div class="body table-responsive">
			                    <table id="detalles" class="table table-bordered table-striped" style="font-size: 10pt">
			                        <thead style="background-color: #6c757d; color: white;">
			                          <th>Opción</th>
				                      <th>Artículo</th>
				                      <th>Código Art.(Id)</th>
				                      <th>Solicitud Compra</th>
				                      <th>FacDetalle(Id)</th>
				                      <th>Precio Art.</th>
				                      <th>Cantidad</th>
				                      <th>SubTotal</th>
			                        </thead>
			                        <tfoot>
			                          <th colspan="7" style="text-align:right"><h5>TOTAL</h5></th>
			                          <th><h4 id="total">Bs. 0.00</h4></th>
			                        </tfoot>
			                      </table>
			                </div>
				        </div>
				    </div>
				</div>

				<div class="card-footer" id="guardar">
					@include('egreso.partials.actions')
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<!-- ==Modal== -->
<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-create_dependencia">
	<form action="{{route('create_dependencia')}}" method="POST">
		@csrf
		<div class="modal-dialog">
			<div class="modal-content bg-info">
		      	<div class="modal-header">
		        <h4 class="modal-title">Dependencia de Dirección Administrativa</h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hiden="true">x</span>
			        </button>
		      	</div>
		      	<div class="modal-body">
		        	<!-- === -->
			        <div class="col-sm-12">
			          <div class="form-group">
			            <div class="form-line">
			              <select required name="direccionadministrativa_id" class="form-control form-control-sm select2bs4">
			                @foreach ($direccionadministrativas as $direccionadministrativa)
			                  <option value="{{$direccionadministrativa->id}}">{{$direccionadministrativa->nombre}}</option>
			                @endforeach
			              </select>
			            </div>
			            <small>Seleccionar Dirección Administrativa.</small>
			          </div>
			        </div>
		        	<!-- === -->
		        	<div class="col-sm-12">
			          <div class="form-group">
			            <div class="form-line">
			              <input type="text" class="form-control form-control-sm" required name="codigo" placeholder=" Ingresar Código." autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
			            </div>
			            <small>Codigo Unidad.</small>
			          </div>
			        </div>
		        	<!-- === -->
			        <div class="col-sm-12">
			          <div class="form-group">
			            <div class="form-line">
			              <input type="text" class="form-control form-control-sm" required name="nombre" placeholder=" Ingresar unidad administrativa." autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
			            </div>
			            <small>Unidad Administrativa.</small>
			          </div>
			        </div>
		        	<!-- === -->
		      	</div>
			    <div class="modal-footer justify-content-between">
			    	<button type="button" class="btn btn-outline-light" data-dismiss="modal">cerrar</button>
			        <button type="submit" class="btn btn-outline-light">Confirmar</button>
			    </div>
		    </div>
		</div>
  	</form>
</div>
<!-- == Cerrar Modal== -->
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

		//variables.
		var cont=0;
		total=0;
		subtotal=[];

		//funcion agregar datos a la tabla.
		function agregar()
		{
		    idarticulo_select2bs4=$("#idarticulo_select2bs4").val();
		    nombre_articulo=$("#idarticulo_select2bs4 option:selected").text();
		    articulo_id=$("#codigoarticulo").val();
		    solicitudcompra_id=$("#solicitudcompra_id").val();
			solcomp=$("#solicitudcompra_id option:selected").text();
			facturadetalle_id=$("#idfacturadetalle").val();
		    precio=$("#precio").val();
		    cantidad=$("#cantidad").val();

		    if (idarticulo_select2bs4!="" && precio>0 && cantidad>0) {

		      	subtotal = precio*cantidad;

		      	var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-success" onclick="eliminar('+cont+')";>X</button></td><td><input type="hidden" value="'+idarticulo_select2bs4+'">'+nombre_articulo+'</td><td><input type="hidden" name="articulo_id[]" value="'+articulo_id+'">'+articulo_id+'</td><td><input type="hidden" name="solicitudcompra_id[]" value="'+solicitudcompra_id+'">'+solcomp+'</td><td><input type="hidden" name="facturadetalle_id[]" value="'+facturadetalle_id+'">'+facturadetalle_id+'</td><td><input type="hidden" name="precio[]" value="'+precio+'">'+precio+'</td><td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input type="hidden" class="input_subtotal" name="totalcompra[]" value="'+subtotal+'">'+subtotal+'</td></tr>';

			    	// variables de detalle de factura y total de factura
			    	let detalle_subtotal = parseFloat(calcular_total()+subtotal).toFixed(2);

		        	let cantidad_saliente = parseFloat($('#cantidad').val());
		        	let total_stock = parseFloat($('#stock').val());

		    		if (cantidad_saliente<=total_stock) {
		        		cont++;
		          		limpiar();
		          		$('#detalles').append(fila);
		          		$("#total").html("Bs. "+calcular_total().toFixed(2));
		          		evaluar();
		          		$('#btn_guardar').removeAttr('disabled');
		    		}else {
		    			alert("Error, la cantidad ingresada excede el stock actual del artículo/producto.");
		    			}
		    }else {
		    	alert("Error, Debe seleccionar un artículo.\n\nLas cantidades de los artículos a egresar deben ser mayor que cero.");
		    	}
		}

		//funcion limpiar.
		function limpiar()
		{
		  	$("#codigoarticulo").val("");
		  	$("#nombrecategoria").val("");
		  	$("#presentacion").val("");
		  	$("#precio").val("");
		  	$("#stock").val("");
		  	$("#cantidad").val("");
		}

		//funcion evaluar boton guardar.
		$("#guardar").hide();
		function evaluar() {
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
		}

		//==================================================
		//calcular total de factura
		function calcular_total()
		{
		  	let total = 0;
		  	$(".input_subtotal").each(function() {
		    	total += parseFloat($(this).val());
		  	});
		  	return total;
		}

		//==================================================
		//funcion que da mensaje de confirmacion al tratar de agregar artículo.
		function validarEgresoForm()
		{
		  	var codigopedido, fechasolicitud, fechasalida;
			codigopedido = document.getElementById("codigopedido").value;
			fechasolicitud = document.getElementById("fechasolicitud").value;
			fechasalida = document.getElementById("fechasalida").value;

			if (codigopedido ==="") {
				alert("El código de pedido está vacío.");
				return false;
			}
			else if (fechasolicitud ==="") {
				alert("La fecha de solicitud de pedido está vacío.");
				return false;
			}
			else if (fechasalida ==="") {
				alert("La fecha de salida de pedido está vacío.");
				return false;
			}
			else {
				var mensaje = confirm("Esta seguro de guardar este detalle de egreso de artículo/producto.");

			    if (mensaje == true) {
			    	return true;
			    }else {
			        return false;
			    }
			}
		}

		//Inicializa combo heredado
	  	$('#direccionadministrativa_id').on('change',function(e){
		  var dep_id  = e.target.value;

		  $.get('/sisalmacen/unidadadministrativa?dep_id=' + dep_id, function(data){

		    $('#unidadadministrativa_id').empty();
		    $('#unidadadministrativa_id').append('<option value="0" disabled="true" selected="true">Seleccione Unidad</option>');

		    $.each(data, function(index, dependenciasObj){
		      $('#unidadadministrativa_id').append('<option value="'+ dependenciasObj.id +'">'+ dependenciasObj.nombre +'</option>');
		    })
		  });
		});

		//Captura id del combo heredado
		$('#unidadadministrativa_id').on('change',function(e) {
		  let dep_id  = e.target.value;
		  console.log(dep_id);
		});

		//optiene detalle de las solicitudes de compra.
		$('#solicitudcompra_id').on('change',function(e)
		{
			var dep_id  = e.target.value;
		  	//$('#idarticulo').empty();
		  	$.get('/sisalmacen/egreso_facturadetalle?dep_id=' + dep_id, function(data)
		  	{
		    	$('#idarticulo_select2bs4').empty();
		    	$('#idarticulo_select2bs4').append('<option value="0" disabled="true" selected="true">Seleccione Artículo</option>');

		    	$.each(data, function(index, dependenciasObj){
		      		$('#idarticulo_select2bs4').append('<option value="'+ dependenciasObj.id +','+dependenciasObj.nombre_categoria+','+dependenciasObj.presentacion+','+dependenciasObj.preciocompra+','+dependenciasObj.cantidadrestante+','+dependenciasObj.idfacdet+'">'+ dependenciasObj.nombre +'</option>');
		    	})
		  	});
		});

		//Select filtro + extraccion de datos de articulos.
		$("#idarticulo_select2bs4").change(mostrarValoresArticulo);
		function mostrarValoresArticulo()
		{
			datoArticulo =  document.getElementById('idarticulo_select2bs4').value.split(',');
		  	$("#codigoarticulo").val(datoArticulo[0]);
		  	$("#nombrecategoria").val(datoArticulo[1]);
		  	$("#presentacion").val(datoArticulo[2]);
		  	$("#precio").val(datoArticulo[3]);
		  	$("#stock").val(datoArticulo[4]);
		  	$("#idfacturadetalle").val(datoArticulo[5]);
		}

		//mensaje de espera de enviado de formulario
		$('#form').on('submit', function(e) {
		    $('.loader').css('display', 'block')
		    document.getElementById("btn_guardar").disabled = true;
		    //e.preventDefault();
		});

	</script>
@endpush

