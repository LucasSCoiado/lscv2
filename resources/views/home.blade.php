@extends('layout.main_layout')
@section('content')

    <div class="col">
        <div class="row mt-5">
            <div class="col text-center">
                <p class="display-6 mb-5 text-secondary opacity-50">Sem eplepsias informadas ao sistema!</p>
                <a href="{{ route('new') }}" class="btn btn-secondary btn-lg p-3 px-5">
                    <i class="fa-regular fa-pen-to-square me-3"></i>Cadastrar eplepsia
                </a>
            </div>
        </div>
    </div>

@endsection