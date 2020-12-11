@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-olive shadow">
                <div class="card-header">Sistemas de Almacenes Materiales y Suministros - GAD-BENI.</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Bienvenidos!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
