@extends('layouts.app')
@section('title','Egreso de Artículos/Productos')

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
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    Egresos de Artículos/productos
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 300px;">
                          @include('egreso.search')

                          @can('egreso.create')
                          <a href="{{ route('egreso.create') }}"><button type="button" class="btn btn-default" title="Crear egreso de artículo/producto"><i class="fas fa-plus"></i></button></a>
                          @endcan
                        </div>
                    </div>
                </div>

                <div id="resultados" style="background-color: #F6F5A9"></div>

                @include('egreso.lista_egresos')

                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $egresos->links() }}
                  </ul>
                  @if(count($egresos) > 0)
                    <p>Mostrando {{ $egresos->firstItem() }} al {{ $egresos->lastItem() }} de {{ $egresos->total() }} Registros</p>
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
          fetch(`/egreso/buscador?search=${document.getElementById("search").value}`,{method:'get'})
          .then(response => response.text())
          .then(html =>{document.getElementById("resultados").innerHTML = html})
        else
          document.getElementById("resultados").innerHTML = ""
      })
    })
  </script>
@endpush