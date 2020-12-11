@extends('layouts.app')
@section('title','Editar Perfil Usuario')

@section('content')
<form id="form" action="{{route('perfilusuario.update',$perfil->id)}}" method="POST">
@csrf @method('PATCH')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    Editar Datos Adicionales del Usuario.
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- === -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control form-control-sm" required name="nombre" value="{{$perfil->nombre}}" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()" autocomplete="off">
                                </div>
                                <small>Nombres.</small>
                            </div>
                        </div>
                        <!-- === -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control form-control-sm" required name="apaterno" value="{{$perfil->apaterno}}" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()" autocomplete="off">
                                </div>
                                <small>Apellido Paterno.</small>
                            </div>
                        </div>
                        <!-- === -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control form-control-sm" required name="amaterno" value="{{$perfil->amaterno}}" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()" autocomplete="off">
                                </div>
                                <small>Apellido Materno.</small>
                            </div>
                        </div>
                        <!-- === -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control form-control-sm" required name="ci" value="{{$perfil->ci}}" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()" autocomplete="off">
                                </div>
                                <small>Carnet Identidad.</small>
                            </div>
                        </div>
                        <!-- === -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" class="form-control form-control-sm" required name="telefono" value="{{$perfil->telefono}}" autocomplete="off">
                                </div>
                                <small>Teléfono.</small>
                            </div>
                        </div>
                        <!-- === -->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" class="form-control form-control-sm" required name="direccion" value="{{$perfil->direccion}}" style="text-transform:uppercase;" onkeyup ="this.value=this.value.toUpperCase()" autocomplete="off">
                                </div>
                                <small>Dirección.</small>
                            </div>
                        </div>
                        <!-- === -->
                    </div>
                </div>
                <div class="card-footer">
                    @include('perfilusuario.partials.actions')
                </div>
            </div>
        </div>
    </div>
</div>

</form>
@endsection