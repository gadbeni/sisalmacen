@extends('layouts.app')
@section('title','Egresos de Articulos')

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
                    Egresos de Articulos/Productos
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 50px;">
                          @can('egreso.create')
                          <a href="{{ route('egreso.create') }}"><button type="button" class="btn btn-default float-right" title="Crear Solicitudes de Compra"><i class="fas fa-plus"></i></button></a>
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
@include('egreso.modal')
@endsection

@push ('script')
  <script src="{{ url('js/main.js') }}"></script>
  <script>
    $(document).ready(function() {
        let columns = [
            { data: 'id', title: 'ID' },
            { data: 'codigopedido', title: 'N° Pedido' },
            { data: 'fechasolicitud', title: 'Fecha Solicitud' },
            { data: 'date_output', title: 'Fecha Salida' },
            { data: 'oficina', title: 'Oficina' },
            { data: 'codigo', title: 'Cuenta' },
            { data: 'action', title: 'Acciones', orderable: false, searchable: false },
        ]
        customDataTable("{{ url('egreso/buscador') }}/", columns);
    });

    function deleteItem(url){
        $('#delete_form').attr('action', url);
    }
  </script>
@endpush