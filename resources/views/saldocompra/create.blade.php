@extends('layouts.app')
@section('title','Crear Saldo de Inventario')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')

<form action="{{route('saldocompra.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-10">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Saldo de Inventario</h3>
				</div>
				<div class="card-body">
					<div class="row">
						<!-- === -->
						<div class="col-sm-5">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <select required name="sucursal_id" class="form-control form-control-sm select2bs4">
					                    @foreach ($sucursales as $sucursal)
						                  <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
						                @endforeach
					                 </select>
	                            </div>
	                            <small>Sucursal del Usuario.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-5">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="descripcion" autocomplete="off" placeholder="Descripción." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Descripción.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-2">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="monto" autocomplete="off" placeholder="Monto.">
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
		</div>
		<!-- === -->
	</div>
</div>
</form>
@endsection
