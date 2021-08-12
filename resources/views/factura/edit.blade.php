@extends('layouts.app')
@section('title','Editar Solicitud de Compra')
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

<form id="form" action="{{route('factura.update',$factura->id)}}" method="POST">
    @csrf @method('PATCH')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Editar Solicitud de Compra</h3>
				</div>
				<div class="card-body">
				<h5>Solicitud de Compra:</h5>
						<div class="row">
		                    <!-- === -->
		                    <div class="col-sm-5">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required name="entidad_id" class="form-control form-control-sm select2bs4">
						                    @foreach ($entidades as $entidad)
											  <option {{(int)old('entidad_id') === $entidad->id ||$solicitud->entidad_id === $entidad->id ? 'selected' : ''}} value="{{ $entidad->id }}">{{ $entidad->nombre }}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccionar Entidad Solicitante.</small>
		                        </div>
		                    </div>
		                    <!-- === -->
							<div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" name="numerosolicitud" value="{{old('numerosolicitud') ? :$solicitud->numerosolicitud}}">
		                            </div>
		                            <small>Número Solicitud.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-5">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="date" class="form-control" id="fechaingreso" name="fechaingreso" value="{{ old('fechaingreso') ? :$solicitud->fechaingreso}}">
		                            </div>
		                            <small>Fecha Ingreso.</small>
		                        </div>
		                    </div>
							<!-- === -->
						</div>
					<hr>
					<h5>Proveedor + Detalle de Factura:</h5>
						<div class="row">
							<!-- === -->
							<div class="col-sm-8">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required name="sucursal_id" class="form-control form-control-sm select2bs4">
						                    @foreach ($sucursales as $sucursal)
							                  <option value="{{$sucursal->id}}" {{(collect($factura->sucursal_id)->contains($sucursal->id)) ? 'selected':''}}>{{$sucursal->sucursal}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Sucursal del Usuario (Usuario del Sistema).</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" readonly class="form-control form-control-sm" name="registro_clientIP" value="{{$factura->registro_clientIP}}">
		                            </div>
		                            <small>Ip-red Usuario.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" readonly class="form-control form-control-sm" name="gestion" value="{{$factura->gestion}}">
		                            </div>
		                            <small>Gestión.</small>
		                        </div>
		                    </div>
		                    <!-- input axiliar -->
        					<input type="hidden" name="created_at" value="{{$factura->created_at}}" class="form-control form-control-sm">
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required name="proveedor_id" class="form-control form-control-sm select2bs4">
						                    @foreach ($providers as $provider)
							                  <option value="{{ $provider->id }}" {{ $provider->id == $factura->proveedor_id ? 'selected' : '' }}>{{ $provider->razonsocial }}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccion del proveedor.</small>
		                        </div>
		                    </div>
							<div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" class="form-control form-control-sm" required name="numerofactura" value="{{$factura->numerofactura}}">
		                            </div>
		                            <small>Número Factura.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" class="form-control form-control-sm" readonly id="montofactura" value="{{$factura->montofactura}}" >
		                            </div>
		                            <small>Monto Factura.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="date" name="fechafactura" value="{{$factura->fechafactura}}">
		                            </div>
		                            <small>Fecha Factura.</small>
		                        </div>
		                    </div>
							<!-- === -->

						</div>
					<hr>
					<h5>Detalle de Compra Artículo/producto:</h5>
						<div class="row">
							<!-- === -->
							<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select id="idarticulo_select2bs4" class="form-control form-control-sm select2bs4">
		                                	<option selected value="">Seleccionar Artículo/Producto</option>
						                    @foreach ($articulos as $articulo)
							                  <option value="{{$articulo->id}}_{{$articulo->presentacion}}_{{$articulo->categoria->nombre}}">{{$articulo->nombre}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccionar Artículo.</small>
		                        </div>
		                    </div>
		                    <!-- === -->
		                    <div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" class="form-control form-control-sm" readonly id="codigoarticulo" placeholder="CÓDIGO.">
		                            </div>
		                            <small>Código Artículo.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" class="form-control form-control-sm" readonly id="presentacion" placeholder="PRESENTACIÓN.">
		                            </div>
		                            <small>Presentación.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" class="form-control form-control-sm" readonly id="nombrecategoria" placeholder="CATEGORÍA ARTÍCULO.">
		                            </div>
		                            <small>Categoria.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" id="precio" placeholder="Precio" autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
		                            </div>
		                            <small>Precio Artículo.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" id="cantidad" name="cantidad" placeholder="Cantidad" autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
		                            </div>
		                            <small>Cantidad Artículo.</small>
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
			                          <th>Precio Art.</th>
			                          <th>Cantidad</th>
			                          <th>SubTotal</th>
			                        </thead>
			                        <tbody>
			                          @php
			                            $cont = 0;
			                            $total = 0;
			                          @endphp
			                          @foreach($facturadetalles as $item)
			                          @php
			                            $cont++;
			                            $total += $item->totalbs;
			                          @endphp
						              <tr class="selected" id="fila{{$cont}}">
						                <td><button type="button" class="btn btn-danger" onclick="eliminar('{{$cont++}}')";>X</button></td>
						                <td><input type="hidden" name="articulo_id[]" value="{{ $item->articulo_id}}">{{ $item->articulo }}</td>
						                <td><input type="hidden" name="precio[]" value="{{ $item->preciocompra }}">{{ $item->preciocompra }}</td>
						                <td><input type="hidden" name="cantidad[]" value="{{ $item->cantidadrestante }}">{{ $item->cantidadrestante }}</td>
						                <td><input type="hidden" class="input_subtotal" name="totalcompra[]" value="{{ $item->totalbs }}">{{ $item->totalbs }}</td>
						              </tr>
			                          @endforeach
			                        </tbody>
			                        <tfoot>
			                          <th colspan="4" style="text-align:right"><h5>TOTAL</h5></th>
			                          <th><h4 id="total">Bs. {{ $total }}</h4></th>
			                        </tfoot>
			                      </table>
			                </div>
				        </div>
				    </div>
				</div>

				<div class="card-footer">
					@include('factura.partials.actions_update')
				</div>
			</div>
		</div>
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


		//variables.
		var cont=0;
		total=0;
		subtotal=[];


		//funcion agregar datos a la tabla.
		function agregar()
		{
		    articulo_id=$("#codigoarticulo").val();
		    nombre_articulo=$("#idarticulo_select2bs4 option:selected").text();
		    precio=$("#precio").val();
		    cantidad=$("#cantidad").val();

		    if (articulo_id!="" && precio>0 && cantidad>0) {

		    	subtotal = precio*cantidad;

		      	var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger" onclick="eliminar('+cont+')";>X</button></td><td><input type="hidden" name="articulo_id[]" value="'+articulo_id+'">'+nombre_articulo+'</td><td><input type="hidden" name="precio[]" value="'+precio+'">'+precio+'</td><td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input type="hidden" class="input_subtotal" name="totalcompra[]" value="'+subtotal+'">'+subtotal+'</td></tr>';

		      	// variables de detalle de factura y total de factura
		      	let detalle_subtotal = parseFloat(calcular_total()+subtotal).toFixed(2);

		      	let monto_total = parseFloat($('#montofactura').val());

		      	if (detalle_subtotal<=monto_total) {
		        	cont++;
		        	limpiar();
		        	$('#detalles').append(fila);
		        	$("#total").html("Bs. "+calcular_total().toFixed(2));
		        	//evaluar();
		        	if (calcular_total().toFixed(2)==monto_total.toFixed(2)) {
		          		$('#btn_guardar').removeAttr('disabled');
		        	}
		      	}else {
		      		alert("Error, Verificar el Monto de la Factura que ha sido introducido.");
		      		}
		    }else {
		    	alert("Error, Debe seleccionar un artículo.\n\nPrecio artículo y Cantidad artículo.\nLas cantidades deben ser Mayor que cero.");
		    	}
		}

		//funcion limpiar.
		function limpiar()
		{
		  	$("#codigoarticulo").val("");
		  	$("#nombrecategoria").val("");
		  	$("#presentacion").val("");
		  	$("#precio").val("");
		  	$("#cantidad").val("");
		  	$("#totalbs").val("");
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
		function calcular_total()
		{
		  	let total = 0;
		  	$(".input_subtotal").each(function(){
		    	total += parseFloat($(this).val());
		  	});

		  	return total;
		}

		//funcion que da mensaje de confirmacion al tratar de agrehar artículo.
		function confirmarguardado()
		{
		  	var mensaje = confirm("Esta seguro de guardar este detalle de compra");
		    if (mensaje == true) {
		    	return true;
		    }else {
		        return false;
		    	}
		}

		//Select filtro + extraccion de datos de articulos y categoria
		$("#idarticulo_select2bs4").change(mostrarValoresArticulo);
		function mostrarValoresArticulo()
		{
			datoArticulo = document.getElementById('idarticulo_select2bs4').value.split('_');
		  	$("#codigoarticulo").val(datoArticulo[0]);
		  	$("#presentacion").val(datoArticulo[1]);
		  	$("#nombrecategoria").val(datoArticulo[2]);
		}

		//mensaje de espera de enviado de formulario
		$('#form').on('submit', function(e) {
		    $('.loader').css('display', 'block')
		    document.getElementById("btn_guardar").disabled = true;
		    //e.preventDefault();
		});

	</script>
@endpush

