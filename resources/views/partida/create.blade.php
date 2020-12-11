@extends('layouts.app')
@section('title','Crear Partida Presupuestaria')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')

<form action="{{route('partida.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-8">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Partida Presupuestaria.</h3>
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
	                            	<input type="text" class="form-control form-control-sm" required name="codigo" autocomplete="off" placeholder="codigo partida." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Código Partida Presupuestaria.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="nombre" autocomplete="off" placeholder="Nombre partida presupuestaria." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Nombre Partida Presupuestaria.</small>
	                        </div>
	                    </div>
						<!-- === -->
					</div>
				</div>
				<div class="card-footer">
					@include('partida.partials.actions')
				</div>
			</div>
		</div>
		<!-- === -->
	</div>
</div>
</form>
@endsection
