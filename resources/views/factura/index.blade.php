@extends('layouts.app')
@section('title','Facturas y Detalles')

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
                    Facturas y Detalles de compra
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 300px;">
                          @include('factura.search')
                        </div>
                    </div>
                </div>

                <div id="resultados" style="background-color: #F6F5A9"></div>

                @include('factura.lista_facturadetalles')

                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    {{ $facturas->links() }}
                  </ul>
                  @if(count($facturas) > 0)
                    <p>Mostrando {{ $facturas->firstItem() }} al {{ $facturas->lastItem() }} de {{ $facturas->total() }} Registros</p>
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
          fetch(`/sisalmacen/factura/buscador?search=${document.getElementById("search").value}`,{method:'get'})
          .then(response => response.text())
          .then(html =>{document.getElementById("resultados").innerHTML = html})
        else
          document.getElementById("resultados").innerHTML = ""
      })
    })
  </script>
@endpush