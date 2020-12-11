@extends('layouts.app')
@section('title','Editar Categoría')
<style>
  input[type=text] {
    background-color: #F9F8A6;
  }

  input[type=number] {
    background-color: #F9F8A6;
  }
</style>
@section('content')
<form action="{{route('categoria.update',$categoria->id)}}" method="POST">
@csrf @method('PATCH')

<div class="container">
	<div class="row justify-content-center">
		<!-- === -->
		<div class="col-md-6">
			<div class="card card-secondary">
				<div class="card-header">
					<h3 class="card-title">Editar Categoría</h3>
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
						<div class="col-sm-12">
	                        <div class="form-group">
	                            <div class="form-line">
	                                <input type="text" class="form-control form-control-sm" required name="nombre" value="{{$categoria->nombre}}" autocomplete="off" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()">
	                            </div>
	                            <small>Categoría.</small>
	                        </div>
	                    </div>
						<!-- === -->
					</div>
				</div>
				<div class="card-footer">
					@include('categoria.partials.actions')
				</div>
			</div>
		</div>
		<!-- === -->
	</div>
</div>	
</form>
@endsection
