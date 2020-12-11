@extends('layouts.app')
@section('title','Ingreso de Artículo a Stock (Solicitud de Compra)')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form action="{{route('displayreportoinventory')}}" method="POST">
              @csrf
                <div class="card card-info">
                  <div class="card-header">
                      Reporte de Inventarios
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
                      <!-- === -->
                      <div class="col-sm-4">
                        <div class="form-group">
                          <div class="form-line">
                             <select class="form-control form-control-sm" name="entidad">
                              <option value="" selected disabled>Seleccione</option>
                               <option value="SaldoArticulos">Saldo de Articulos</option>
                                <option value="yearsumary">Resumen Anual</option>
                             </select>
                          </div>
                          <small>Seleccione la entidad..</small>
                        </div>
                      </div>
                      <!-- === -->
                      <div class="col-md-4">
                          <div class="form-group">
                              <div class="form-line">
                                 <select class="form-control form-control-sm" name="tipo_reporte" id="tipo_reporte">
                                   <option value="" selected disabled>Seleccione</option>
                                   <option value="today">Hoy Dia</option>
                                   <option value="currentyear">Gestion Actual</option>
                                   <option value="range_date">Por rango de fecha</option>
                                 </select>
                              </div>
                              <small>Seleccione el tipo de reporte.</small>
                          </div>
                      </div>

                         <!-- === -->
                          <div class="col-sm-6" id="rango_fechas">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" class="form-control" value="{{old('fechainicio')}}" name="inicio">
                                    </div>
                                    <small>Fecha Inicio.</small> <i class="fa fa-exclamation-circle" aria-hidden="true" style="color: red;" title="Campo requerido"></i>
                                </div>
                            </div>
                          <!-- === -->
                          <div class="col-sm-6" id="rango_fechas1">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="date" class="form-control" value="{{old('fechafin')}}" name="fin">
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
@section('script')
<script type="text/javascript">
var select = document.getElementById('tipo_reporte');
    var el = document.getElementById('rango_fechas');
     var el1 = document.getElementById('rango_fechas1');

  select.addEventListener('change',
    function(){
      var selectedOption = this.options[select.selectedIndex];
      if (selectedOption.value == 'range_date') {
            el.style.display = 'block';
            el1.style.display = 'block';
      }else {
        el.style.display = 'none';
        el1.style.display = 'none';
      }
    });

  window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/

  el.style.display = 'none';
  el1.style.display = 'none';
  }
</script>
@stop

