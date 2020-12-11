@extends('layouts.app')
@section('title','Resumen Solicitud de Compras')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{route('solicitudesresumen_r')}}" method="POST">
              @csrf
                <div class="card card-info">
                  <div class="card-header">
                      Reporte de Solicitudes de Compras (Resumen de Montos)
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <!-- === -->
                      <div class="col-sm-6">
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
                      <div class="col-sm-6">
                        <div class="form-group">
                            <div class="form-line">
                              <select name="entidad_id" class="form-control form-control-sm select2bs4">
                                   {{--  <option selected value="todo">Seleccionar Entidad Solicitante</option> --}}
                                    @foreach ($entidades as $entidad)
                                    <option value="{{$entidad->id}}">{{$entidad->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small>Seleccionar Entidad Solicitante.</small>
                        </div>
                      </div>
                      <!-- === -->
                      <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" required class="form-control" value="{{old('fechainicio')}}" name="fechainicio">
                                </div>
                                <small>Fecha Inicio.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
                            </div>
                        </div>
                      <!-- === -->
                      <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" required class="form-control" value="{{old('fechafin')}}" name="fechafin">
                                </div>
                                <small>Fecha Final.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
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
  <link rel="stylesheet" href="{{asset('theme/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush

@push ('script')
  <!-- Select2 -->
  <script src="{{asset('theme/plugins/select2/js/select2.full.min.js')}}"></script>

  <script>
    //==================================================
    $(function ()
    {
      //Inicializa Select2 Elements
      $('.select2bs4').select2({
        })
      })
  </script>
@endpush
