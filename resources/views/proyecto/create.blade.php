@extends('layouts.app')
@section('title','Crear Proyecto')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')

<form action="{{route('proyecto.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-12">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Proyecto</h3>
				</div>
				<div class="card-body">
					@if(count($errors)>0)
					<div class="alert alert-dark">
					  <ul>
					    @foreach($errors->all() as $error)
					    <li>{{$error}}</li>
					    @endforeach
					  </ul>
					</div>
					@endif
					<div class="row">

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
	                                <select id="unidadadministrativa_id" name="unidadadministrativa_id" class="form-control form-control-sm select2bs4">
				                   		<option value="">{{__("Seleccionar Dirección Administrativa")}}</option>
				                  	</select>
	                            </div>
	                            <small>Seleccionar Unidad Administrativa.</small> <a href="" data-toggle="modal" data-target="#modal-create_dependencia" title="Crear Nueva Unidad Administrativa."><i class="fas fa-plus-circle"></i> Crear Unidad Administrativa.</a>
	                        </div>
	                    </div>
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
	                    <div class="col-sm-2">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="number" class="form-control form-control-sm" required name="codigo" placeholder="Código Proyecto." autocomplete="off">
	                            </div>
	                            <small>Código Proyecto.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" required name="nombre" placeholder="Nombre Proyecto." autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Nombre Proyecto.</small>
	                        </div>
	                    </div>
						<!-- === -->
					</div>
				</div>
				<div class="card-footer">
					@include('proyecto.partials.actions')
				</div>
			</div>
		</div>
		<!-- === -->
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
		//==================================================
		$(function ()
		{

		    //Inicializa Select2 Elements
		    $('.select2bs4').select2({
		    })
	  	})

		//==================================================
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
		$('#unidadadministrativa_id').on('change',function(e){
		  let dep_id  = e.target.value;
		  console.log(dep_id);
		});
	</script>
@endpush
