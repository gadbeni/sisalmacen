@extends('layouts.app')
@section('title','Crear Detalle de Saldo')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')

<form action="" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-6">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Detalle de Saldo de Inventario</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<!-- === -->
							<div class="col-sm-4">
		                        <div class="form-group">
		                            <div class="form-line">
		                                <select required name="mes_id" class="form-control form-control-sm select2bs4">
						                    @foreach ($meses as $mes)
							                  <option value="{{$mes->id}}">{{$mes->nombre}}</option>
							                @endforeach
						                 </select>
		                            </div>
		                            <small>Seleccionar Mes.</small>
		                        </div>
		                    </div>
		                    <!-- === -->
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="ingreso" autocomplete="off" placeholder="Monto.">
	                            </div>
	                            <small>Ingreso.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="egreso" autocomplete="off" placeholder="Monto.">
	                            </div>
	                            <small>Egreso.</small>
	                        </div>
	                    </div>
						<!-- === -->
					</div>
				</div>
				<div class="card-footer">
					@include('saldocompradetalle.partials.actions')
				</div>
			</div>
		</div>
		<!-- === -->
	</div>
</div>
</form>
@endsection
