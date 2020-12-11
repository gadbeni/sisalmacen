@extends('layouts.app')
@section('title','Artículos/Productos')

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
                    Artículos/Productos
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 300px;">
                          @include('articulo.search')

                          @can('producto.create')
                          <a href="{{ route('articulo.create') }}"><button type="button" class="btn btn-default" title="Crear articulo"><i class="fas fa-plus"></i></button></a>
                          @endcan
                        </div>
                    </div>
                </div>

                <div id="resultados" style="background-color: #F6F5A9"></div>

                @include('articulo.lista_articulos')

                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $articulos->links() }}
                  </ul>
                  @if(count($articulos) > 0)
                    <p>Mostrando {{ $articulos->firstItem() }} al {{ $articulos->lastItem() }} de {{ $articulos->total() }} Registros</p>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push ('script')
  <script>
    window.addEventListener("load",function(){
      document.getElementById("search").addEventListener("keyup",function(){
        if((document.getElementById("search").value.length)>=2)
          fetch(`/sisalmacen/public/articulo/buscador?search=${document.getElementById("search").value}`,{method:'get'})
          .then(response => response.text())
          .then(html =>{document.getElementById("resultados").innerHTML = html})
        else
          document.getElementById("resultados").innerHTML = ""
      })
    })
  </script>
@endpush