@extends('layouts.app')
@section('title','Crear Proveedor')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')

<form action="{{route('proveedor.store')}}" method="POST">
@csrf

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-10">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Registrar Proveedor</h3>
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
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="nit" autocomplete="off" placeholder="Nit proveedor." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>NIT Proveedor.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="razonsocial" autocomplete="off" placeholder="Razon social proveedor." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Razon Social Proveedor.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="responsable" autocomplete="off" placeholder="Responsable." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Responsable.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="direccion" autocomplete="off" placeholder="Dirección." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Dirección.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-3">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="telefono" autocomplete="off" placeholder="Telefono." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Telefono.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-3">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="fax" autocomplete="off" placeholder="Fax." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Fax.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-12">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="comentario" autocomplete="off" placeholder="Comentario." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Comentario.</small>
	                        </div>
	                    </div>
						<!-- === -->
					</div>
				</div>
				<div class="card-footer">
					@include('proveedor.partials.actions')
				</div>
			</div>
		</div>
		<!-- === -->
	</div>
</div>
</form>
@endsection
