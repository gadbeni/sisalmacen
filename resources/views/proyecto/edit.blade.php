@extends('layouts.app')
@section('title','Editar Proyecto')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')
<form action="{{route('proyecto.update',$proyecto->id)}}" method="POST">
@csrf @method('PATCH')

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-12">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Editar Proyecto</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <select id="direccionadministrativa_id" name="direccionadministrativa_id" class="form-control form-control-sm select2bs4">
					                    @foreach ($direccionadministrativas as $direccionadministrativa)
						                  <option value="{{$direccionadministrativa->id}}" {{(collect($proyecto->direccionadministrativa_id)->contains($direccionadministrativa->id)) ? 'selected':''}}>{{$direccionadministrativa->nombre}}</option>
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
	                                <div id="select-unidadadministrativa"></div>
	                            </div>
	                            <small>Seleccionar Unidad Administrativa.</small>
	                        </div>
	                    </div>
          				<!-- === -->
          				<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <select required name="sucursal_id" class="form-control form-control-sm select2bs4">
					                    @foreach ($sucursales as $sucursal)
						                  <option value="{{$sucursal->id}}" {{(collect($proyecto->sucursal_id)->contains($sucursal->id)) ? 'selected':''}}>{{$sucursal->sucursal}}</option>
						                @endforeach
					                 </select>
	                            </div>
	                            <small>Sucursal del Usuario (Usuario del Sistema).</small>
	                        </div>
	                    </div>
	                    <div class="col-sm-2">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="number" class="form-control form-control-sm" required name="codigo" value="{{$proyecto->codigo}}" placeholder="Código Proyecto." autocomplete="off">
	                            </div>
	                            <small>Código Proyecto.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" required name="nombre" value="{{$proyecto->nombre}}" placeholder="Nombre Proyecto." autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
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

		  $.get('/sisalmacen/public/unidadadministrativa?dep_id=' + dep_id, function(data){

		    $('#unidadadministrativa_id').empty();
		    $('#unidadadministrativa_id').append('<option value="0" disabled="true" selected="true">Seleccione Unidad</option>');

		    $.each(data, function(index, dependenciasObj){
		      $('#unidadadministrativa_id').append('<option value="'+ dependenciasObj.id +'">'+ dependenciasObj.nombre +'</option>');
		    })
		  });
		});

		//Editar Unidad administrativa
	    let dep_id = $('#direccionadministrativa_id').val();
	    $.get('/sisalmacen/public/unidadadministrativa?dep_id=' + dep_id, function(data)
	    {
	      	let options = '';
	      	$.each(data, function(index, dependenciasObj)
	      	{
	        	options += '<option selected value="'+ dependenciasObj.id +'">'+ dependenciasObj.nombre +'</option>';
	      	});

	      	$('#select-unidadadministrativa').html('<select id="unidadadministrativa_id" name="unidadadministrativa_id"  class="form-control form-control-sm select2bs4">'+options+'</select>');
	      	$('#unidadadministrativa_id').val('{{$proyecto->unidadadministrativa_id}}');
	    });
	 
	</script>
@endpush
