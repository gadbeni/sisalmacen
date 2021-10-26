@extends('layouts.app')
@section('title','Editar Egreso de Artículo/Producto')
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

<form id="form" action="" method="POST">
    @csrf @method('PATCH')

<div class="container" id="egreso">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Editar Egreso de Artículo/Producto</h3>
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
		                                <select  
										class="form-control form-control-sm select2bs4" 
										v-model="form.direccionadministrativa_id"
										@change="getunidades">
						                  	<option selected value="">Seleccionar Dirección Administrativa</option>
						                    @foreach ($direccionadministrativas as $dir)
							                  <option value="{{$dir->id}}">{{$dir->nombre}}</option>
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
		                                <select class="form-control form-control-sm select2bs4" v-model="form.unidadadministrativa_id">
											<option v-for="unid in unid_administrativas" :value="unid.id">
												@{{ unid.nombre }}
											</option>
					                  	</select>
		                            </div>
		                            <small>Seleccionar Unidad Administrativa.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
		                        </div>
		                    </div>
		                    <!-- === -->
		                    <div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" class="form-control form-control-sm" required  placeholder="Introducir número de Pedido." v-model="form.codigopedido">
		                            </div>
		                            <small>Número de Pedido.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="date" class="form-control" v-model="form.fechasolicitud">
		                            </div>
		                            <small>Fecha Solicitud.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input
		                                type="text"
		                                class="form-control"
		                                v-model="form.fechasalida"
		                                >
		                            </div>
		                            <small>Fecha Salida.</small>
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
		                                <select name="solicitudcompra_id" v-model="solicitudecompra" class="form-control form-control select2bs4" @change="fetchProductos">
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
		                                <select id="idarticulo_select2bs4" name="articulo_id" class="form-control form-control-sm select2bs4" v-model="producto">
		                                  <option value="">Seleccione Producto</option>
							              <option v-for="producto in productos" :value="producto">@{{producto.nombre}}</option>
							            </select>
		                            </div>
		                            <small>Seleccionar Artículo/Producto.</small>
		                        </div>
		                    </div>
		                    <!-- === -->
		                    <div class="col-sm-2">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" readonly class="form-control form-control-sm" v-model="producto.id" placeholder="Código">
		                            </div>
		                            <small>Codigo Artículo.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-6">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" readonly class="form-control form-control-sm" v-model="producto.nombre_categoria" placeholder="Categoría Artículo.">
		                            </div>
		                            <small>Categoría.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="text" readonly class="form-control form-control-sm" v-model="producto.presentacion" placeholder="Presentación Artículo.">
		                            </div>
		                            <small>Presentación.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" readonly class="form-control form-control-sm" v-model="producto.preciocompra" placeholder="Precio.">
		                            </div>
		                            <small>Precio.</small>
		                        </div>
		                    </div>
							<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <input type="number" readonly class="form-control form-control-sm" v-model="producto.cantidadrestante" placeholder="Stock de Artículo.">
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
		                                <input type="number" class="form-control form-control-sm" v-model="cantidad" placeholder="Introducir cantidad a egresar." autocomplete="off">
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
		                            	<button type="button" @click="agregarDetalle()" class="btn btn-success"><i class="fas fa-plus"></i> Agregar Artículo</button>
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
			                        <tbody>

						              <tr class="selected" v-for="item in items">
						                <td><button type="button" class="btn btn-danger" @click="remove(item)">X</button></td>
			                            <td><input type="text" readonly v-model="item.articulo">
			                            </td>
			                            <td><p>@{{item.codigo}}</p></td>
			                             <td><p>@{{item.solicitudcompra_id}}</p></td>
			                            <td><p>@{{item.facturadetalle_id}}</p></td>
			                            <td><p>@{{item.preciocompra}}</p></td>
			                            <td><input type="text" v-model="item.cantidad"></td>
			                            <td><p>@{{(item.preciocompra * item.cantidad)}}</p></td>
						              </tr>

			                        </tbody>
			                        <tfoot>
			                        	<th colspan="7" style="text-align:right"><h5>TOTAL</h5></th>
                          				<th><h4 id="total">@{{Total}}Bs. </h4></th>
			                        </tfoot>
			                      </table>
			                </div>
				        </div>
				    </div>
				</div>

				<div class="card-footer">
					@include('egreso.partials.actions_update')
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
    <script src="{{asset('js/vue.js')}}"></script>
    <script src="{{asset('js/vue-resource.min.js')}}"></script>
    <script src="{{asset('js/axios.min.js')}}"></script>
    <script src="{{asset('js/sweetalert2.min.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
	<script type="text/javascript">
		Vue.http.headers.common['X-CSRF-TOKEN'] = '{{csrf_token()}}';
		window._form = {!! $egreso->toJson() !!};
	</script>
	 <script src="{{asset('js/egreso.js')}}"></script>
@endpush

