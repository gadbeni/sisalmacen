@extends('layouts.app')
@section('title','Partidas Presupuestarias')

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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                      Partidas Presupuestarias
                    <div class="card-tools">
                      <form action="{{route('partida.index')}}" method="GET">
                        <div class="input-group input-group-sm" style="width: 300px;">
                          @include('partida.search')

                          @can('partida.create')
                          <a href="{{ route('partida.create') }}"><button type="button" class="btn btn-default" title="Crear partida"><i class="fas fa-plus"></i></button></a>
                          @endcan
                        </div>
                      </form>
                    </div>
                </div>

                <div class="body table-responsive">
                    <table class="table table-hover" style="font-size: 10pt">
                        <thead>                  
                            <tr>
                              	<th>Código</th>
                                <th>Partida</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($partidas as $part)
                            <tr>
                               	<td>{{$part->codigo}}</td>
                                <td>{{$part->nombre}}</td>
                                <td>
                                  @if($part->condicion == 1)
                                    <span class="badge bg-warning"><i class="far fa-bell"></i> ACTIVO</span>
                                  @else
                                    <span class="badge bg-danger"><i class="far fa-bell"></i> INACTIVO</span>
                                  @endif
                                </td>
                                <td style="width: 120px">
                                  @can('partida.edit')
                                  <a href="{{route('partida.edit',$part->id)}}" class="btn btn-info" title="Editar partida"><i class="fas fa-edit"></i></a>
                                  @endcan

                                  @can('partida.destroy')
                                  <a data-target="#modal-delete-{{$part->id}}" data-toggle="modal" class="btn btn-danger" title="Eliminar partida"><i class="fas fa-trash"></i></a>
                                  @endcan
                                </td>
                            </tr>
                            @include('partida.modal')
                            @empty
                            <p style="text-align: center;">No hay registros para mostrar.</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $partidas->links() }}
                  </ul>
                  @if(count($partidas) > 0)
                    <p>Mostrando {{ $partidas->firstItem() }} al {{ $partidas->lastItem() }} de {{ $partidas->total() }} Registros</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection