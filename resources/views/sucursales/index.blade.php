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
                    Sucursales        
                    <div class="card-tools">
                        <a href="{{ route('sucursales.create') }}"><button type="button" class="btn btn-default" title="Crear sucursal"><i class="fas fa-plus"></i></button></a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>                  
                            <tr>
                              <th>#</th>
                              <th>Sucursal</th>
                              <th>Ubicación</th>
                              <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sucursales as $sucursal)
                            <tr>
                              <td>{{$sucursal->id}}</td>
                              <td>{{$sucursal->sucursal}}</td>
                              <td>{{$sucursal->ubicacion}}</td>
                              <td style="width: 120px">
                                <a href="{{route('sucursales.edit',$sucursal->id)}}"><button title="Editar sucursal" type="button" class="btn btn-info"><i class="fas fa-edit"></i> </button></a>

                                <a data-target="#modal-delete-{{$sucursal->id}}" data-toggle="modal"><button title="Eliminar sucursal" type="button" class="btn btn-danger"><i class="fas fa-trash"></i> </button></a>
                              </td>
                            </tr>
                            @include('sucursales.modal')
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