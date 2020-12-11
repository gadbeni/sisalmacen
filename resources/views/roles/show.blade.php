@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-info">
                <div class="card-header">Rol</div>

                <div class="card-body">
                    <p><strong>Nombre: </strong>{{ $role->name }}</p>
                    <p><strong>Slug: </strong>{{ $role->slug }}</p>
                    <p><strong>Descripción: </strong>{{ $role->description }}</p>

                    <button type="button" name="Back" onclick="history.back()" class="btn btn-outline-info"><i class="fas fa-history"></i> Volver a la Lista</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection