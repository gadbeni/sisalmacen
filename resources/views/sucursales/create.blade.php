@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Registrar Sucursal</h3>
				</div>

			<form action="{{route('sucursales.store')}}" method="POST">
				@csrf
				<div class="card-body">
					<div class="form-group">
						<label for="sucursal">Sucursal</label>
						<input type="text" class="form-control form-control-sm" required name="sucursal" placeholder="Sucursal" autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
					</div>
					<div class="form-group">
						<label for="ubicacion">Ubicación</label>
						<input type="text" class="form-control form-control-sm" required name="ubicacion" placeholder="Ubicación sucursal" autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
					</div>
				</div>

				<div class="card-footer">
					@include('sucursales.partials.actions')
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
@endsection