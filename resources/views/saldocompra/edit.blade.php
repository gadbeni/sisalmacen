@extends('layouts.app')
@section('title','Editar Saldo de Inventario')
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
</style>
@section('content')

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-6">
			<form action="{{route('saldocompra.update',$saldocompra)}}" method="POST">
				@method('PUT')
				@csrf
				<div class="card card-secondary">
					<div class="card-header">
						<h3 class="card-title">Editar Detalle de Saldo de Inventario</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<!-- === -->
							<div class="col-sm-5">
								<div class="form-group">
									<div class="form-line">
										<select name="sucursal_id" class="form-control form-control-sm select2bs4">
											@foreach($sucursales as $sucursal)
											<option {{(int)old('sucursal_id') === $sucursal->id || $saldocompra->sucursal_id === $sucursal->id ? 'selected' : ''}} value="{{ $sucursal->id }}" class="form-control">{{ $sucursal->sucursal }} </option>
											@endforeach
										</select>
									</div>
									<small>Sucursal del Usuario.</small>
								</div>
							</div>
							<!-- === -->
							<div class="col-sm-4">
								<div class="form-group">
									<div class="form-line">
										<input type="text" class="form-control form-control-sm" name="descripcion"   style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()" value="{{$saldocompra->descripcion}}">
									</div>
									<small>Descripción.</small>
								</div>
							</div>
							<!-- === -->
							<div class="col-sm-2">
								<div class="form-group">
									<div class="form-line">
										<input type="text" class="form-control form-control-sm" name="monto" value="{{$saldocompra->monto}}">
									</div>
									<small>Monto.</small>
								</div>
							</div>
							<!-- === -->
						</div>
					</div>
					<div class="card-footer">
						@include('saldocompra.partials.actions')
					</div>
				</div>
			</form>
		</div>
		<!-- === -->
	</div>
</div>

@endsection
