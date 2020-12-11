@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-info">
                <div class="card-header">Usuario</div>
                <div class="card-body">
                    <p><strong>Nombre: </strong>{{ $user->name }}</p>
                    <p><strong>Email: </strong>{{ $user->email }}</p>

                    <button type="button" name="Back" onclick="history.back()" class="btn btn-outline-info"><i class="fas fa-history"></i> Volver a la Lista</button>
                </div>
            </div>
    </div>
</div>
@endsection