@extends('layouts.app')
@section('title','Crear Solicitud de Compra')
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

<form id="form" action="{{route('solicitudcompra.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Solicitud de Compra</h3>
					<div class="card-tools">
                        <a href="{{ route('solicitudcompra.index') }}"><button type="button" class="btn btn-default" title="Volver a la lista de Solicitudes de compra."><i class="fas fa-history"></i></button></a>
                    </div>
				</div>
				<div class="card-body">
					<h5>Solicitud de Compra:</h5>
						<div class="row">
							<!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required name="sucursal_id" class="form-control form-control-sm select2bs4">
						                    @foreach ($sucursales as $sucursal)
							                  <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Sucursal (Usuario del Sistema).</small>
		                        </div>
		                    </div>
		                    <!-- === -->
		                    <div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required name="entidad_id" class="form-control form-control-sm select2bs4">
						                    @foreach ($entidades as $entidad)
							                  <option value="{{$entidad->id}}">{{$entidad->nombre}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccionar Entidad Solicitante.</small>
		                        </div>
		                    </div>
		                    <!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" required id="numerosolicitud" name="numerosolicitud" placeholder="Introducir número de solicitud" autocomplete="off">
		                            </div>
		                            <small>Número Solicitud.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="date" class="form-control" id="fechaingreso" name="fechaingreso">
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
							<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required id="idproveedor" name="proveedor_id" class="form-control form-control-sm select2bs4">
		                                	<option selected value="">Seleccionar Proveedor</option>
						                    @foreach ($proveedors as $proveedor)
							                  <option value="{{$proveedor->id}}_{{$proveedor->nit}}">{{$proveedor->razonsocial}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccionar Proveedor.</small>
		                        </div>
		                    </div>
		                    <!-- input axiliar -->
        					<input type="hidden" id="idproveedor_input" name="idproveedor_input" class="form-control">
		                    <!-- === -->
		                    <div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" class="form-control form-control-sm" id="nitproveedor" placeholder="NIT Proveedor" readonly>
		                            </div>
		                            <small>NIT.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" class="form-control form-control-sm" required id="numerofactura" name="numerofactura" placeholder="Introducir número factura" autocomplete="off">
		                            </div>
		                            <small>Número Factura.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="date" id="fechafactura" class="form-control" name="fechafactura">
		                            </div>
		                            <small>Fecha Factura.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" required id="montofactura" name="montofactura" placeholder="Introducir monto" autocomplete="off">
		                            </div>
		                            <small>Monto Factura.</small>
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
		                                <select required id="idarticulo_select2bs4" class="form-control form-control-sm select2bs4">
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
		                                <input type="number" class="form-control form-control-sm" id="precio" placeholder="Precio" autocomplete="off">
		                            </div>
		                            <small>Precio Artículo.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-3">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" id="cantidad" placeholder="Cantidad" autocomplete="off">
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
			                          <th>Código art.</th>
			                          <th>Categoría</th>
			                          <th>Presentación</th>
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
					@include('solicitudcompra.partials.actions')
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

		//funcion limpiar.
		function limpiar()
		{
		  	$("#codigoarticulo").val("");
		  	$("#presentacion").val("");
		  	$("#nombrecategoria").val("");
		  	$("#precio").val("");
		  	$("#cantidad").val("");
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
		  	$(".input_subtotal").each(function() {
		    	total += parseFloat($(this).val());
		  	});

		  	return total;
		}

		//funcion agregar datos a la tabla.
		function agregar()
		{
			idarticulo_select2bs4=$("#idarticulo_select2bs4").val();
		    nombre_articulo=$("#idarticulo_select2bs4 option:selected").text();
		    articulo_id=$("#codigoarticulo").val();
		    presentacion=$("#presentacion").val();
		    categoria=$("#nombrecategoria").val();
		    precio=$("#precio").val();
		    cantidad=$("#cantidad").val();

		    if (idarticulo_select2bs4!="" && precio>0 && cantidad>0) {

		    	subtotal = precio*cantidad;

		      	var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-success" onclick="eliminar('+cont+')";>X</button></td><td><input type="hidden" value="'+idarticulo_select2bs4+'">'+nombre_articulo+'</td><td><input type="hidden" name="articulo_id[]" value="'+articulo_id+'">'+articulo_id+'</td><td><input type="hidden" value="'+categoria+'">'+categoria+'</td><td><input type="hidden" value="'+presentacion+'">'+presentacion+'</td><td><input type="hidden" name="precio[]" value="'+precio+'">'+precio+'</td><td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input type="hidden" class="input_subtotal" name="totalbs[]" value="'+subtotal+'">'+subtotal+'</td></tr>';

		      	//captura la suma de Subtotales
		      	let monto_subtotal = parseFloat(calcular_total()+subtotal).toFixed(2);

		      	//captura el valor del monto de la factura
		      	let monto_factura = parseFloat($('#montofactura').val());

		      	//compara si el monto de la factura es menor o igual que el subtotal
		      	if (monto_subtotal<=monto_factura) {
			        cont++;
			        limpiar();
			        $('#detalles').append(fila);
			        $("#total").html("Bs. "+calcular_total().toFixed(2));
			        evaluar();
		        	if (calcular_total().toFixed(2)==monto_factura.toFixed(2)) {
		          		$('#btn_guardar').removeAttr('disabled');
		        	}
		      	}else {
		      		alert("Error, Verificar el Monto de la Factura que ha sido introducido.");
		      		}
		    }else {
		    	alert("Error, Debe seleccionar un artículo.\n\nPrecio artículo y Cantidad artículo.\nLas cantidades deben ser Mayor que cero.");
		    	}
		}

		//funcion que da mensaje de confirmacion al tratar de agrehar artículo.
		function validarSolicitudCompraForm()
		{
			var numerosolicitud, fechaingreso, numerofactura, fechafactura;
			numerosolicitud = document.getElementById("numerosolicitud").value;
			fechaingreso = document.getElementById("fechaingreso").value;
			numerofactura = document.getElementById("numerofactura").value;
			fechafactura = document.getElementById("fechafactura").value

			if (numerosolicitud ==="") {
				alert("El número de solicitud de Compra está vacío.");
				return false;
			}
			else if (fechaingreso ==="") {
				alert("La fecha ingreso de solicitud de compra está vacío.");
				return false;
			}
			else if (numerofactura ==="") {
				alert("El número de la factura está vacío.");
				return false;
			}
			else if (fechafactura ==="") {
				alert("La fecha de factura de compra está vacío.");
				return false;
			}
			else {
				var mensaje = confirm("Esta seguro de guardar esta solicitud de compra con el detalle de artículo/producto?");

				if (mensaje == true) {
					return true;
				}else {
			    	return false;
			    	}
			}
		}

	  	//Select filtro + extraccion de datos de los proveedores.
		$("#idproveedor").change(mostrarValoresProveedores);
		function mostrarValoresProveedores()
		{
		  	datoProveedor = document.getElementById('idproveedor').value.split('_');
		  	$("#idproveedor_input").val(datoProveedor[0]);
		  	$("#nitproveedor").val(datoProveedor[1]);
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

