@extends('layouts.app')
@section('title','Solicitudes de Compra')

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
                    Socilitudes de Compra
                    <div class="card-tools">
                      <form action="{{route('solicitudcompra.index')}}" method="GET">
                        <div class="input-group input-group-sm" style="width: 300px;">
                        @include('solicitudcompra.search')

                        @can('solicitudcompra.create')
                        <a href="{{ route('solicitudcompra.create') }}"><button type="button" class="btn btn-default" title="Crear Solicitudes de Compra"><i class="fas fa-plus"></i></button></a>
                        @endcan
                        </div>
                      </form>
                    </div>
                </div>

                <div class="body table-responsive">
                    <table class="table table-hover" style="font-size: 10pt">
                        <thead>
                            <tr>
                                <th>Cod. registro</th>
                                <th>Entidad solicitante</th>
                                <th>Número solicitud compra</th>
                                <th>Fecha/hora recepción</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                              <?php $numeroitems = 0; ?>
                              @forelse($solicitudcompras as $solcomp)
                              <?php $numeroitems++ ?>
                            <tr>
                                <td>{{$numeroitems}}</td>
                                <td>{{$solcomp->entidad}}</td>
                                <td>{{$solcomp->numerosolicitud}}</td>
                                <td>{{$solcomp->fechaingreso}}</td>
                                <td>
                                  @can('solicitudcompra.edit')
                                  <a href="{{route('solicitudcompra.edit',$solcomp->id)}}" title="Editar Solicitud de Compra" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                  @endcan
                                  {{-- <a href="" title="Dar de Baja" class="btn btn-danger" data-target="#modal-delete-{{$solcomp->id}}" data-toggle="modal"><i class="fas fa-trash"></i></a> --}}
                                </td>
                            </tr>
                            @include('solicitudcompra.modal')
                            @empty
                              <p style="text-align: center;">No hay registros para mostrar.</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $solicitudcompras->links() }}
                  </ul>
                  @if(count($solicitudcompras) > 0)
                    <p>Mostrando {{ $solicitudcompras->firstItem() }} al {{ $solicitudcompras->lastItem() }} de {{ $solicitudcompras->total() }} Registros</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection