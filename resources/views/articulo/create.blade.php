@extends('layouts.app')
@section('title','Crear Artículo')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')

<form action="{{route('articulo.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-8">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Artículos/Productos</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<!-- === -->
						<div class="col-sm-12">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" required name="nombre" placeholder="Introducir Artículo" autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Artículo.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <select required name="categoria_id" class="form-control form-control-sm select2bs4">
					                    @foreach ($categorias as $categorias)
						                  <option value="{{$categorias->id}}">{{$categorias->nombre}}</option>
						                @endforeach
					                 </select>
	                            </div>
	                            <small>Categoría/Rubro.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" required name="presentacion" placeholder="Introducir presentacion" autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Presentación del Artículo.</small>
	                        </div>
	                    </div>
						<!-- === -->
					</div>
				</div>
				<div class="card-footer">
					@include('articulo.partials.actions')
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
		$(function () {

		    //Inicializa Select2 Elements
		    $('.select2bs4').select2({

		    })
	  	})
	</script>
@endpush

