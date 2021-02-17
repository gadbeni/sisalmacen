@extends('layouts.app')

<style>
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
        <div class="col-md-8">
            <div class="card card-info">
                <div class="card-header">
                    Asignación de Sucursales a Usuarios    
                    <div class="card-tools">
                        <a href="{{ route('sucursal_usuario.create') }}"><button type="button" class="btn btn-default" title="Crear sucursal"><i class="fas fa-plus"></i></button></a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>                  
                            <tr>
                              <th>#</th>
                              <th>Sucursal</th>
                              <th>Usuario</th>
                              <th>Estado</th>
                              <th>Fecha Inactivado</th>
                              <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sucursal_usuarios as $sucursal_usuario)
                            <tr>
                              <td>{{$sucursal_usuario->id}}</td>
                              <td>{{$sucursal_usuario->sucursal}}</td>
                              <td>{{$sucursal_usuario->name}}</td>
                              <td>{{$sucursal_usuario->estado}}</td>
                              <td>{{$sucursal_usuario->fecha_inactivacion}}</td>
                              <th>
                              @if($sucursal_usuario->estado == 'ACTIVO')
                               <a data-target="#modal-delete-{{$sucursal_usuario->id}}" data-toggle="modal"><button title="Eliminar asignación de sucursal" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> </button></a>
                              @else
                              <a data-target="#modal-active-{{$sucursal_usuario->id}}" data-toggle="modal"><button title="Activar usuario" type="button" class="btn btn-info"><i class="fas fa-print"></i> </button></a>
                              @endif 
                              </th>
                            </tr>
                            @include('sucursal_usuario.modal')
                            @include('sucursal_usuario.modalactive')
                            @empty
                            <p>No hay registros para mostrar.</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection