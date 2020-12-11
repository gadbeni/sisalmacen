@extends('layouts.app')
@section('title','Egresos de Artículos por Oficinas')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="loader">

            </div>
            <form action="{{route('r_egresoarticulo_oficina')}}" method="POST">
              @csrf
                <div class="card card-info">
                  <div class="card-header">
                      Reporte de Artículos Egresados por Oficinas
                  </div>
                  <div class="card-body">
                    @if(count($errors)>0)
                    <div class="alert alert-danger">
                      <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                      </ul>
                    </div>
                    @endif
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
                      <div class="col-sm-12">
                        <div class="form-group">
                          <div class="form-line">
                            <select required id="direccionadministrativa_id" name="direccionadministrativa_id" class="form-control form-control-sm select2bs4">
                                <option selected value="">Seleccionar Dirección Administrativa</option>
                                @foreach ($direccionadministrativas as $direccionadministrativa)
                                  <option value="{{$direccionadministrativa->id}}">{{$direccionadministrativa->nombre}}</option>
                                @endforeach
                            </select>
                          </div>
                            <small>Seleccionar Dirección Administrativa.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
                        </div>
                      </div>
                      <!-- === -->
                      <div class="col-sm-12">
                        <div class="form-group">
                          <div class="form-line">
                            <select required id="unidadadministrativa_id" name="unidadadministrativa_id" class="form-control form-control-sm select2bs4">
                              <option value="">{{__("Seleccionar Dirección Administrativa")}}</option>
                            </select>
                          </div>
                          <small>Seleccionar Unidad Administrativa.</small>
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

    //==================================================
    //Inicializa combo heredado
      $('#direccionadministrativa_id').on('change',function(e){
      var dep_id  = e.target.value;

      $.get('/sisalmacen/public/unidadadministrativa?dep_id=' + dep_id, function(data){

        $('#unidadadministrativa_id').empty();
        $('#unidadadministrativa_id').append('<option value="0" disabled="true" selected="true">Seleccione Unidad</option>');

        $.each(data, function(index, dependenciasObj){
          $('#unidadadministrativa_id').append('<option value="'+ dependenciasObj.id +'">'+ dependenciasObj.nombre +'</option>');
        })
      });
    });

    //Captura id del combo heredado
    $('#unidadadministrativa_id').on('change',function(e){
      let dep_id  = e.target.value;
      console.log(dep_id);
    });

  </script>
@endpush
