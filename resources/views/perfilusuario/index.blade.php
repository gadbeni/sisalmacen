@extends('layouts.app')
@section('title','Perfil Usuario')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
              	<div class="card-body box-profile">
	                <div class="text-center">
	                  <img class="profile-user-img img-fluid img-circle"
	                       src="{{asset('theme/dist/img/user-account.png')}}"
	                       alt="User profile picture">
	                </div>
	                @forelse($perfils as $perfil)
		                <h3 class="profile-username text-center">{{$perfil->nombre}} {{$perfil->apaterno}} {{$perfil->amaterno}}</h3>
		                <p class="text-muted text-center">Responsable de almacenes</p>

		                <ul class="list-group list-group-unbordered mb-3">
		                  	<li class="list-group-item">
		                    	<b>Carnet identidad:</b> {{$perfil->ci}}
		                  	</li>
		                  	<li class="list-group-item">
		                    	<b>Teléfono:</b> {{$perfil->telefono}}
		                  	</li>
		                  	<li class="list-group-item">
		                    	<b>Dirección:</b> {{$perfil->direccion}}
		                  	</li>
		                </ul>

		                <a href="{{route('perfilusuario.edit',$perfil->id)}}" class="btn btn-primary btn-block"><b>Actualizar Datos del Usuario.</b></a>
		            @empty
                    	<p style="text-align: center;">No hay datos del usuario !{{ Auth::user()->name }}! para mostrar.</p>
                      	<a href="{{route('perfilusuario.create')}}" class="btn btn-primary btn-block"><b>Registrar Datos del Usuario.</b></a>
                    @endforelse

	            </div>
            </div>
        </div>
    </div>
</div>
@endsection