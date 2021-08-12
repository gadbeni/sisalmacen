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
              <div class="body table-responsive">
                <div class="card-header">
                    Facturas y Detalles de compra
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 50px;">
                          @can('solicitudcompra.create')
                          <a href="{{ route('solicitudcompra.create') }}"><button type="button" class="btn btn-default float-right" title="Crear Solicitudes de Compra"><i class="fas fa-plus"></i></button></a>
                          @endcan
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="padding:10px">
                  <table id="dataTable" class="table table-hover" style="font-size: 10pt">
                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
@include('factura.modal')
@endsection

@push ('script')
  <script src="{{ url('js/main.js') }}"></script>
  <script>
    $(document).ready(function() {
        let columns = [
            { data: 'id', title: 'ID' },
            { data: 'entity_nro_purchase', title: 'Entidad + N Compra' },
            { data: 'provider', title: 'Proveedor' },
            { data: 'numerofactura', title: 'Número factura' },
            { data: 'fecha_ingreso', title: 'Fecha registro' },
            { data: 'date_invoice', title: 'Fecha factura' },
            { data: 'action', title: 'Acciones', orderable: false, searchable: false },
        ]
        customDataTable("{{ url('factura/buscador') }}/", columns);
    });

    function deleteItem(url){
        $('#delete_form').attr('action', url);
    }
  </script>
@endpush