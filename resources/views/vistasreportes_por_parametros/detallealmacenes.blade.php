@extends('layouts.app')
@section('title','Artículo/Producto Egresado')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="loader">

            </div>
            <form action="{{route('r_detallealmacenes')}}" method="POST">
              @csrf
                <div class="card card-info">
                  <div class="card-header">
                    Detalle de almacenes
                  </div>
                  <div class="card-body">
                    <div class="row">
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
                            <select required name="gestion" class="form-control form-control-sm select2bs4">
                                <option value="">Seleccione una Gestion</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>

                            </select>
                          </div>
                          <small>Gestion.</small>
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