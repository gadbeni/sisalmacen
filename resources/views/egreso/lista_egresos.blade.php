<div class="body table-responsive">
    <table class="table table-hover" style="font-size: 10pt">
        <thead>
            <tr>
                <th>Cod. registro</th>
                <th>Nro. pedido</th>
                <th>Fecha solicitud</th>
                <th>Fecha salida</th>
                <th>Oficina</th>
                <th>Cuenta</th>
                <th colspan="2">Opciones</th>

            </tr>
        </thead>
        <tbody>
              <?php $numeroitems = 0; ?>
              @forelse($egresos as $egre)
              <?php $numeroitems++ ?>
            <tr>
                <td>{{$numeroitems}}</td>
                <td>{{$egre->codigopedido}}</td>
                <td>{{$egre->fechasolicitud}}</td>
                <td>{{$egre->fechasalida}}</td>

                <td style="width: 300pt">{{$egre->da_nombre}}<br><strong>{{$egre->ua_nombre}}</strong> </td>
                <td>{{$egre->codigo}}</td>
                <td style="width: 90pt">
                    @can('pdf.comprobanteegreso')
                    <a href="{{route('pdfdetalleegreso',$egre->id)}}" title="Imprimir Detalle de Compra" class="btn btn-success" target="_blank"><i class="fas fa-print"></i></a>
                    @endcan

                    @can('egreso.edit')
                    <a href="{{route('egreso.edit',$egre->id)}}" title="Editar Detalle del Egreso" class="btn btn-info"><i class="fas fa-edit"></i></a>
                    @endcan
                </td>
                @can('egreso.destroy')
                <td style="width: 25pt">
                   <a href="" data-target="#modal-delete-{{$egre->id}}" data-toggle="modal" title="Anular Egreso" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                </td>
                @endcan
            </tr>
             @include('egreso.modal')
            @empty
              <p style="text-align: center;">No hay registros para mostrar.</p>
            @endforelse
        </tbody>
    </table>
</div>