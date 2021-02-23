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
                             <select class="form-control form-control-sm" name="entidad" id="entidad">
                              <option value="" selected disabled>Seleccione</option>
                               <option value="SaldoArticulos">Saldo de Articulos</option>
                                <option value="yearsumary">Resumen Anual</option>
                             </select>
                          </div>
                          <small>Seleccione la entidad..</small>
                        </div>
                      </div>
                      <!-- === -->
                      <div class="col-md-4" id="report_gnral">
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
                      <div class="col-md-4" id="report_years">
                          <div class="form-group">
                              <div class="form-line">
                                 <select class="form-control form-control-sm" name="year" id="year">
                                   <option value="" selected disabled>Seleccione</option>
                                   <option value="range_date">Por Fechas</option>
                                   <option value="2017">2017</option>
                                   <option value="2018">2018</option>
                                   <option value="2019">2019</option>
                                   <option value="2020">2020</option>
                                   <option value="2021">2021</option>
                                   <option value="2022">2022</option>
                                   <option value="2022">2023</option>
                                 </select>
                              </div>
                              <small>Seleccione la gestion.</small>
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
    var select_report_year = document.getElementById('year');
    var select_entity = document.getElementById('entidad');
    var el = document.getElementById('rango_fechas');
    var el1 = document.getElementById('rango_fechas1');
    var elyear = document.getElementById('report_years');
    var elreportyear = document.getElementById('report_gnral');

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
    select_report_year.addEventListener('change',
    function(){
      var selectedYear = this.options[select_report_year.selectedIndex];
      if (selectedYear.value == 'range_date') {
            el.style.display = 'block';
            el1.style.display = 'block';
      }else {
        el.style.display = 'none';
        el1.style.display = 'none';
      }
    });
    select_entity.addEventListener('change',
    function(){
      var selectedOptions = this.options[select_entity.selectedIndex];
      if (selectedOptions.value == 'yearsumary') {
         elreportyear.style.display = 'none';
         elyear.style.display = 'block';
         el.style.display = 'none';
        el1.style.display = 'none';
      }else {
        $("#year").val("");
        elreportyear.style.display = 'block';
        elyear.style.display = 'none';
        el.style.display = 'none';
        el1.style.display = 'none';
      }
    });
  window.onload = function(){/*hace que se cargue la función lo que predetermina que div estará oculto hasta llamar a la función nuevamente*/
  elreportyear.style.display = 'none';
  el.style.display = 'none';
  el1.style.display = 'none';
  elyear.style.display = 'none';
  }
</script>
@stop

