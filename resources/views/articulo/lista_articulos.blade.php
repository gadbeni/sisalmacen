<div class="body table-responsive">
  <table class="table table-hover" style="font-size: 10pt">
    <thead>
      <tr>
          <th>ID</th>
          <th>Categoría</th>
          <th>Id Categoría</th>
          <th>Nombre artículo</th>
          <th>Presentación artículo</th>
          <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
        @forelse($articulos as $art)
        <tr>
         	<td>{{$art->id}}</td>
          <td style="width: 250pt">{{$art->categoria->nombre}}</td>
          <td style="width: 250pt">{{$art->categoria->id}}</td>
          <td style="width: 200pt">{{$art->nombre}}</td>
          <td>{{$art->presentacion}}</td>
          <td>
            @can('producto.edit')
            <a href="{{route('articulo.edit',$art->id)}}" title="Editar Artículo" class="btn btn-info"><i class="fas fa-edit"></i></a>
            @endcan

            @can('producto.destroy')
            <a href="" data-target="#modal-delete-{{$art->id}}" data-toggle="modal" title="Eliminar Artículo" class="btn btn-danger"><i class="fas fa-trash"></i></a>
            @endcan
          </td>
        </tr>
        @include('articulo.modal')
        @empty
        <p style="text-align: center;">No hay registros para mostrar.</p>
        @endforelse
    </tbody>
  </table>
</div>