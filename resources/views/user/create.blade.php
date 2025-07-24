@extends('layout.main_layout')
@section('content')

    <div class="container">
        @include('top_bar')
        <p class="display-6 mb-0">Criar conta</p>
        <div class="d-flex justify-content-center align-items-center" >
            <div class="col-12 col-md-6 col-lg-5">
                @include('user.form')
            </div>
        </div>
    </div>
@endsection