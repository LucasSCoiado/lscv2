@extends('layout.main_layout')
@section('content')

    <div class="container">
        <p class="display-6 mb-0 justify-content-center">Cadastro de Pacientes</p>
        <div class="d-flex" >
            <div class="col-12 col-md-6 col-lg-5 justify-content-center align-items-center">
                @include('admin.form_paciente')
            </div>
        </div>
    </div>
@endsection