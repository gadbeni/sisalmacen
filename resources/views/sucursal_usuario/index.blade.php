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
                              <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sucursal_usuarios as $sucursal_usuario)
                            <tr>
                              <td>{{$sucursal_usuario->id}}</td>
                              <td>{{$sucursal_usuario->sucursal}}</td>
                              <td>{{$sucursal_usuario->name}}</td>
                              <th>
                                 <a data-target="#modal-delete-{{$sucursal_usuario->id}}" data-toggle="modal"><button title="Eliminar asignación de sucursal" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> </button></a>
                              </th>
                            </tr>
                            @include('sucursal_usuario.modal')
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