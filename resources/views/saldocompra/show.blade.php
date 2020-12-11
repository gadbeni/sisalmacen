@extends('layouts.app')
@section('title','Detalle de Saldo de Inventario')

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
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Detalle de Saldo de Inventario: {{$saldocompra->gestion}} - Monto Inicial: {{$saldocompra->monto}} Bs.</h3>
                </div>

                <div class="body table-responsive">
                    <table class="table table-hover" style="font-size: 10pt">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Ingreso</th>
                                <th>Egreso</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $saldo = $saldocompra->monto ?? 0;
                                $totalingresos= $arreglo->sum('ingresos');
                                $totalegresos= $arreglo->sum('egresos');
                            ?>
                            @forelse($arreglo as $scdet)
                            <?php $saldo+= $scdet['ingresos'] - $scdet['egresos']?>
                            <tr>
                                
                                <td >{{$scdet['mes']}}</td>
                                <td>{{$scdet['ingresos']}}</td>
                                <td>{{$scdet['egresos']}}</td>
                                <td>{{$saldo}}</td>
                            </tr>
                            @empty
                                <p style="text-align: center;">No hay registros para mostrar.</p>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{route('saldocompra.index')}}" class="btn btn-outline-info"><i class="fas fa-history"></i> Volver a la Lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection