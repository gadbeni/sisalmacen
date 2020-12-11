<div class="body table-responsive">
    <table class="table table-hover" style="font-size: 10pt">
        <thead>
            <tr>
                <th>Nro.</th>
                <th>Entidad + Nro. compra</th>
                <th>Proveedor</th>
                <th>Número factura</th>
                <th>Fecha factura</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
              <?php $numeroitems = 0; ?>
              @forelse($facturas as $fac)
              <?php $numeroitems++ ?>
            <tr>
                <td>{{$numeroitems}}</td>
                <td>{{$fac->solicitudcompra->entidad->nombre.' - '.$fac->solicitudcompra->numerosolicitud}}</td>
                <td style="width: 200pt">{{$fac->proveedor->razonsocial}}<br><strong>NIT: {{$fac->proveedor->nit}}</strong> </td>

                <td>{{$fac->numerofactura}}</td>
                <td>{{\Carbon\Carbon::parse($fac->fechafactura)->format('Y/m/d')}}<br><strong>Monto: {{$fac->montofactura}} Bs.</strong>
                </td>
                <td>
                    @can('pdf.comprobantecompra')
                    <a href="{{route('pdfdetallefactura',$fac->id)}}" title="Imprimir Detalle de Compra" class="btn btn-success" target="_blank"><i class="fas fa-print"></i></a>
                    @endcan

                    @can('factura.edit')
                    <a href="{{route('factura.edit',$fac->id)}}" title="Editar Detalle de Compra" class="btn btn-info"><i class="fas fa-edit"></i></a>
                    @endcan

                    @can('factura.destroy')
                    <a href="" data-target="#modal-delete-{{$fac->id}}" data-toggle="modal" title="Eliminar Detalle de Compra" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                    @endcan
                </td>
            </tr>
            @include('factura.modal')
            @empty
              <p style="text-align: center;">No hay registros para mostrar.</p>
            @endforelse
        </tbody>
    </table>
</div>