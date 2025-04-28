@extends('layout.main_layout')
@section('content')

    <div class="col">

        @include('top_bar')
        @if(count($crises) == 0)
            <div class="row mt-5">
                <div class="col text-center">
                    <p class="display-6 mb-5 text-secondary opacity-50">Sem eplepsias informadas ao sistema!</p>
                    <a href="{{ route('new') }}" class="btn btn-secondary btn-lg p-3 px-5">
                        <i class="fa-regular fa-pen-to-square me-3"></i>Cadastrar eplepsia
                    </a>
                </div>
            </div>

        @else

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('create') }}" class="btn btn-secondary px-3">
                    <i class="fa-regular fa-pen-to-square me-2"></i>Cadastrar eplepsia
                </a>
            </div>
            @foreach ($crises as $crise)
                @include('crises')
            @endforeach
        @endif
    </div>

@endsection