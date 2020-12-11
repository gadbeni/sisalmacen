@extends('layouts.app')
@section('title','Resumen Solicitud de Compras')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{route('kardex_articulo_r')}}" method="POST">
              @csrf
                <div class="card card-info">
                  <div class="card-header">
                      Reporte de Kardex de Articulos
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <!-- === -->
                      <div class="col-sm-5">
                        <div class="form-group">
                          <div class="form-line">
                            <select required name="sucursal_id" class="form-control form-control-sm select2bs4">
                                @foreach ($sucursales as $sucursal)
                                  <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
                                @endforeach
                            </select>
                          </div>
                          <small>Sucursal (Usuario del Sistema).</small>
                        </div>
                      </div>
                      <!-- === -->
                      <div class="col-sm-7">
                        <div class="form-group">
                            <div class="form-line">
                              <select name="entidad_id" class="form-control form-control-sm select2bs4">
                                   {{--  <option selected value="todo">Seleccionar Entidad Solicitante</option> --}}
                                    @foreach ($solicitudescompras as $solicitudescompra)
                                    <option value="{{$solicitudescompra->id}}">{{$solicitudescompra->entidad->nombre}} - {{$solicitudescompra->numerosolicitud}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small>Seleccionar Solicitud de Compra.</small>
                        </div>
                      </div>
                      <!-- === -->
                    </div>
                  </div>
                  <div class="card-footer">
                    @include('vistasreportes_por_parametros.partials.actions')
                  </div>
                </div>
            </form>
        </div>
    </div>
  </div>
@endsection

@push ('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('theme/plugins/select2/css/select2.min.css')}}">
@endpush

@push ('script')
  <!-- Select2 -->
  <script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>

  <script>
    $(function () {
      $('.select2bs4').select2();
    })
  </script>
@endpush
