@extends('layouts.app')
@section('title','Saldo de Inventarios')

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
                      Saldos de Inventarios Almacenes
                    <div class="card-tools">
                      <form action="{{route('saldocompra.index')}}" method="GET">
                        <div class="input-group input-group-sm" style="width: 300px;">
                          @include('saldocompra.search')

                          <a href="{{ route('saldocompra.create') }}"><button type="button" class="btn btn-default" title="Crear saldo de inventario"><i class="fas fa-plus"></i></button></a>
                        </div>
                      </form>
                    </div>
                </div>

                <div class="body table-responsive">
                    <table class="table table-hover" style="font-size: 10pt">
                        <thead>
                            <tr>
                                <th>Sucursal</th>
                              	<th>Descripción</th>
                                <th>Saldo Inv Inicio</th>
                                <th>Saldo Inv Final</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($saldocompras as $salcomp)
                            <tr>
                                <td>{{ $salcomp->sucursal->sucursal}}</td>
                               	<td>
                                  {{-- {{route('saldocompra.show',$salcomp->id)}} --}}
                                  <a href="{{route('saldocompra.show',$salcomp->id)}}" title="Ver detalle de saldo de Inventario">{{$salcomp->descripcion}} GESTION: {{$salcomp->gestion}}</a>
                                </td>
                                <td>{{$salcomp->monto}}</td>
                                <td>{{$salcomp->saldo_final}}</td>
                                <td>{{$salcomp->condicion ? 'Abierto': 'Cerrado'}}</td>
                                @if ($salcomp->condicion)
                                <td>
                                  {{-- {{route('saldocompra.edit',$salcomp->id)}} --}}
                                  <a href="{{route('saldocompra.edit',$salcomp)}}" title="Editar detalle de saldo de Inventario" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                </td>
                                <td>
                                  <a href="" data-target="#modal-delete-{{$salcomp->id}}" data-toggle="modal" title="Serrar Gestion de este almacen" class="btn btn-success"><i class="fas fa-plus"></i></a>
                                </td>
                                @else
                                <td></td>
                                <td></td>
                                @endif
                            </tr>
                            @include('saldocompra.modal')
                            @empty
                            <p style="text-align: center;">No hay registros para mostrar.</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $saldocompras->links() }}
                  </ul>
                  @if(count($saldocompras) > 0)
                    <p>Mostrando {{ $saldocompras->firstItem() }} al {{ $saldocompras->lastItem() }} de {{ $saldocompras->total() }} Registros</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection