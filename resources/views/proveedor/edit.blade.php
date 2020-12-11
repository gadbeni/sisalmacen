@extends('layouts.app')
@section('title','Editar Proveedor')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')
<form action="{{route('proveedor.update',$proveedor->id)}}" method="POST">
@csrf @method('PATCH')

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-10">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Editar Proveedor</h3>
				</div>
				<div class="card-body">
					@if(count($errors)>0)
					<div class="alert alert-danger">
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
	                            	<input type="text" class="form-control form-control-sm" required name="nit" value="{{$proveedor->nit}}" autocomplete="off" placeholder="Nit proveedor." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>NIT Proveedor.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="razonsocial" value="{{$proveedor->razonsocial}}" autocomplete="off" placeholder="Razon social proveedor." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Razon Social Proveedor.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-4">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="responsable" value="{{$proveedor->responsable}}" autocomplete="off" placeholder="Responsable." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Responsable.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-6">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="direccion" value="{{$proveedor->direccion}}" autocomplete="off" placeholder="Dirección." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Dirección.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-3">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="telefono" value="{{$proveedor->telefono}}" autocomplete="off" placeholder="Telefono." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Telefono.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-3">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="fax" value="{{$proveedor->fax}}" autocomplete="off" placeholder="Fax." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Fax.</small>
	                        </div>
	                    </div>
						<!-- === -->
						<div class="col-sm-12">
	                        <div class="form-group">
	                            <div class="form-line">
	                            	<input type="text" class="form-control form-control-sm" required name="comentario" value="{{$proveedor->comentario}}" autocomplete="off" placeholder="Comentario." style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
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
