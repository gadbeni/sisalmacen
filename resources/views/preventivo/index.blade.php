@extends('layouts.app')
@section('title','Preventivos de Compras')

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
            <div class="card">
                <div class="card-header">
                      Preventivos
                    <div class="card-tools">
                      <form action="{{route('preventivo.index')}}" method="GET">
                        <div class="input-group input-group-sm" style="width: 300px;">
                          @include('preventivo.search')

                          @can('preventivo.create')
                          <a href="{{ route('preventivo.create') }}"><button type="button" class="btn btn-default" title="Crear preventivo"><i class="fas fa-plus"></i></button></a>
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
                                <th>Solicitud de compra</th>
                                <th>Preventivos</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                              <?php $numeroitems = 0; ?>
                              @forelse($preventivos as $prev)

                            <tr>
                               	<td>{{$prev->id}}</td>
                                <td>{{$prev->solicitudcompra}}</td>
                                <td>
                                  @foreach($prev->preventivodetalle as $det)
                                    {{$det->numeropreventivo}},
                                  @endforeach
                                </td>
                                <td>
                                  @can('pdf.preventivo')
                                  <a href="{{route('pdfpreventivo',$prev->id)}}" title="Ver Detalle de Preventivo"  class="btn btn-success" target="_blank"><i class="fas fa-print"></i></a>
                                  @endcan

                                  @can('preventivo.destroy')
                                  <a href="" data-target="#modal-delete-{{$prev->id}}" data-toggle="modal" title="Eliminar Detalle de Preventivos" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                  @endcan
                                </td>
                            </tr>
                            @include('preventivo.modal')
                            @empty
                              <p style="text-align: center;">No hay registros para mostrar.</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $preventivos->links() }}
                  </ul>
                  @if(count($preventivos) > 0)
                    <p>Mostrando {{ $preventivos->firstItem() }} al {{ $preventivos->lastItem() }} de {{ $preventivos->total() }} Registros</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection