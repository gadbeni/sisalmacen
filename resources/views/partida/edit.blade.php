@extends('layouts.app')
@section('title','Editar Partidas Presupuestarias')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')
<form action="{{route('partida.update',$partida->id)}}" method="POST">
@csrf @method('PATCH')

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-8">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Editar Partida Presupuestaria</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="codigo" value="{{$partida->codigo}}" autocomplete="off" placeholder="codigo partida." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Código Partida Presupuestaria.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="nombre" value="{{$partida->nombre}}" autocomplete="off" placeholder="Nombre partida presupuestaria." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
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
