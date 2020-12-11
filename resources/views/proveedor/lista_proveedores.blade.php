<div class="body table-responsive">
    <table class="table table-hover" style="font-size: 10pt">
        <thead>
            <tr>
              	<th>NIT</th>
                <th>Razon social + Responsable</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Fax</th>
                <th>Comentarios</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($proveedores as $prov)
            <tr>
               	<td>{{$prov->nit}}</td>
                <td style="width: 250pt">{{$prov->razonsocial}}<br><strong>{{$prov->responsable}}</strong> </td>
                <td style="width: 250pt">{{$prov->direccion}}</td>
                <td>{{$prov->telefono}}</td>
                <td>{{$prov->fax}}</td>
                <td>{{$prov->comentario}}</td>
                <td>
                  @if($prov->condicion == 1)
                    <span class="badge bg-warning"><i class="far fa-bell"></i> ACTIVO</span>
                  @else
                    <span class="badge bg-danger"><i class="far fa-bell"></i> INACTIVO</span>
                  @endif
                </td>
                <td style="width: 120px">
                  @can('proveedor.edit')
                  <a href="{{route('proveedor.edit',$prov->id)}}" title="Editar Proveedor" class="btn btn-info"><i class="fas fa-edit"></i></a>
                  @endcan

                  @can('proveedor.destroy')
                  <a data-target="#modal-delete-{{$prov->id}}" data-toggle="modal" title="Inhabilitar/Habilitar" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                  @endcan
                </td>
            </tr>
            @include('proveedor.modal')
            @empty
            <p style="text-align: center;">No hay registros para mostrar.</p>
            @endforelse
        </tbody>
    </table>
</div>