@extends('layouts.app')
@section('title','Proveedores')

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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                      Proveesdores de la institución
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 300px;">
                          @include('proveedor.search')

                          @can('proveedor.create')
                          <a href="{{ route('proveedor.create') }}"><button type="button" class="btn btn-default" title="Crear proveedor"><i class="fas fa-plus"></i></button></a>
                          @endcan
                        </div>
                    </div>
                </div>

                <div id="resultados" style="background-color: #F6F5A9"></div>

                @include('proveedor.lista_proveedores')

                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $proveedores->links() }}
                  </ul>
                  @if(count($proveedores) > 0)
                    <p>Mostrando {{ $proveedores->firstItem() }} al {{ $proveedores->lastItem() }} de {{ $proveedores->total() }} Registros</p>
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
          fetch(`/sisalmacen/proveedor/buscador?search=${document.getElementById("search").value}`,{method:'get'})
          .then(response => response.text())
          .then(html =>{document.getElementById("resultados").innerHTML = html})
        else
          document.getElementById("resultados").innerHTML = ""
      })
    })
  </script>
@endpush