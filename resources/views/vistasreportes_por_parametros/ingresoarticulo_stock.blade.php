@extends('layouts.app')
@section('title','Ingreso de Artículo a Stock (Solicitud de Compra)')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{route('r_ingresoarticulo_stock')}}" method="POST">
              @csrf
                <div class="card card-info">
                  <div class="card-header">
                      Reporte de Ingreso de Artículo a Stock (Solicitud de Compra)
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <!-- === -->
                      <div class="col-sm-4">
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
                      <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="date" required class="form-control" value="{{old('fechainicio')}}" name="fechainicio">
                                </div>
                                <small>Fecha Inicio.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
                            </div>
                        </div>
                      <!-- === -->
                      <div class="col-sm-4">
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

