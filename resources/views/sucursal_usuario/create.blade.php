@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Registrar Sucursal</h3>
				</div>

			<form action="{{route('sucursal_usuario.store')}}" method="POST">
				@csrf
				<div class="card-body">
					<!-- === -->
					<div class="form-group">
	                  <label>Sucursales</label>
	                  <select required name="sucursal_id" class="form-control form-control-sm" style="width: 70%;">
	                    @foreach ($sucursales as $sucursal)
		                  <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
		                @endforeach
	                  </select>
	                </div>
					<!-- === -->

					<div class="form-group">
	                  <label>Usuario del Sistema</label>
	                  <select required name="user_id" class="form-control form-control-sm" style="width: 70%;">
	                    @foreach ($users as $usuer)
		                  <option value="{{$usuer->id}}">{{$usuer->name}}</option>
		                @endforeach
	                  </select>
	                </div>
					<!-- === -->
				</div>

				<div class="card-footer">
					@include('sucursal_usuario.partials.actions')
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
@endsection