@extends('layouts.app')
@section('title','Proyectos')

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
                      Proyectos
                    <div class="card-tools">
                      <form action="{{route('proyecto.index')}}" method="GET">
                        <div class="input-group input-group-sm" style="width: 300px;">
                          @include('proyecto.search')

                          @can('proyecto.create')
                          <a href="{{ route('proyecto.create') }}"><button type="button" class="btn btn-default" title="Crear proyecto"><i class="fas fa-plus"></i></button></a>
                          @endcan
                        </div>
                      </form>
                    </div>
                </div>

                <div class="body table-responsive">
                    <table class="table table-hover" style="font-size: 10pt">
                        <thead>
                            <tr>
                              	<th>Dirección administrativa</th>
                                <th>Unidad ejecutora</th>
                                <th>Proyecto</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proyectos as $proy)
                            <tr>
                               	<td>{{$proy->codigo_da}} - {{$proy->direccionadministrativa}}</td>
                                <td>{{$proy->codigo_ua}} - {{$proy->unidadadministrativa}}</td>
                                <td>{{$proy->codigo.' - '.$proy->nombre}}</td>
                                <td style="width: 80px">
                                  @can('proyecto.edit')
                                  <a href="{{route('proyecto.edit',$proy->id)}}" class="btn btn-info" title="Editar Proyecto"><i class="fas fa-edit"></i></a>
                                  @endcan
                                </td>
                            </tr>
                            @empty
                            <p style="text-align: center;">No hay registros para mostrar.</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $proyectos->links() }}
                  </ul>
                  @if(count($proyectos) > 0)
                    <p>Mostrando {{ $proyectos->firstItem() }} al {{ $proyectos->lastItem() }} de {{ $proyectos->total() }} Registros</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection