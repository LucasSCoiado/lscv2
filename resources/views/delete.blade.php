@extends('layout.main_layout')
@section('content')
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
                <div class="col card p-5 text-center">
                    <span class="display-3 mb-5"><i class="fa-solid fa-triangle-exclamation text-warning opacity-50"></i></span>
                    <h4 class="text-info mb-3">{{$crises->tipo}}</h4>
                    <p class="text-secondary">Tem certeza?</p>
                    <div class="mt-3">
                        <a href="{{ url()->previous()}}" class="btn btn-primary px-5 m-2"><i class="fa-solid fa-xmark me-2"></i>Cancelar</a>
                        <a href="{{ route('destroy', ['id' => Crypt::encrypt($crises->id)]) }}" class="btn btn-danger px-5 m-2"><i class="fa-solid fa-trash me-2"></i>Apagar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection