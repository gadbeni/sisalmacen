@extends('layouts.app')
@section('title','Editar Solicitud de Compra')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')
<form action="{{route('solicitudcompra.update',$solicitudcompra->id)}}" method="POST">
@csrf @method('PATCH')

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-8">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Editar Solicitud de Compra</h3>
				</div>
				<div class="card-body">
					<div class="row">		
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" required name="numerosolicitud" placeholder="Introducir número de solicitud" autocomplete="off" value="{{$solicitudcompra->numerosolicitud}}">
	                            </div>
	                            <small>Número Solicitud.</small>
	                        </div>
		                </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="date" name="fechaingreso" value="{{$solicitudcompra->fechaingreso}}">
	                            </div>
	                            <small>Fecha Ingreso.</small>
	                        </div>
	                    </div>
	                    <!-- === -->
                    </div>
				</div>
				<div class="card-footer">
					@include('solicitudcompra.partials.actions_update')
				</div>
			</div>
		</div>
		<!-- === -->
	</div>
</div>	
</form>
@endsection
