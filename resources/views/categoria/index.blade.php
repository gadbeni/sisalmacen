@extends('layouts.app')
@section('title','Categorías')

<style>
    table th {
      text-align: center;
    }

    table td {
      text-align: center;
    }
</style>

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Categorías de Artículos/Productos
                    <div class="card-tools">
                      <form action="{{route('categoria.index')}}" method="GET">
                        <div class="input-group input-group-sm" style="width: 300px;">
                        @include('categoria.search')

                        @can('categoria.create')
                        <a href="{{ route('categoria.create') }}"><button type="button" class="btn btn-default" title="Crear categoria"><i class="fas fa-plus"></i></button></a>
                        @endcan
                        </div>
                      </form>
                    </div>
                </div>

                <div class="body table-responsive">
                    <table class="table table-hover" style="font-size: 10pt">
                        <thead>
                            <tr>
                                <th>Id</th>
                              	<th>Nombre categoría/rubro</th>
				              	<th>Estado</th>
				              	<th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categorias as $cat)
                            <tr>
                                <td>{{$cat->id}}</td>
                               	<td>{{$cat->nombre}}</td>
				                <td>
				                  @if($cat->condicion == 1)
				                  	<span class="badge bg-warning"><i class="far fa-bell"></i> ACTIVO</span>
				                  @else
				                  	<span class="badge bg-danger"><i class="far fa-bell"></i> INACTIVO</span>
				                  @endif
				                </td>
				                <td>
                                    @can('categoria.edit')
				                    <a href="{{route('categoria.edit',$cat->id)}}" title="Editar Categoría"  class="btn btn-info"><i class="fas fa-edit"></i></a>
                                    @endcan

                                    @can('categoria.destroy')
				                    <a data-target="#modal-delete-{{$cat->id}}" data-toggle="modal" title="Inhabilitar/Habilitar Categoría" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    @endcan
				                </td>
                            </tr>
                            @include('categoria.modal')
                            @empty
                            <p style="text-align: center;">No hay registros para mostrar.</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $categorias->links() }}
                  </ul>
                  @if(count($categorias) > 0)
                    <p>Mostrando {{ $categorias->firstItem() }} al {{ $categorias->lastItem() }} de {{ $categorias->total() }} Registros</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection