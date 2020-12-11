@extends('layouts.app')
@section('title','Crear Categoría')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')

<form action="{{route('categoria.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-6">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Categoría</h3>
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
					<div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <input type="text" class="form-control form-control-sm" required name="nombre" placeholder="Introducir categoría" autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
                            </div>
                            <small>Nombre categoria/rubro.</small>
                        </div>
                    </div>
					<!-- === -->
					</div>
				</div>
				<div class="card-footer">
					@include('categoria.partials.actions')
				</div>
			</div>
		</div>
		<!-- === -->
	</div>
</div>
</form>
@endsection
