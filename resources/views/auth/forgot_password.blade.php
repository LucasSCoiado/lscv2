@extends('layout.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="card p-5">
                <p class="display-6 text-center">RECUPERAR SENHA</p>
                <form action="{{ route('send_restart_password_link') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <lable class="form-label">Indique seu e-mail</lable>
                        <input type="email" name="email" class="form-control">
                        @error('email')
                            <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="row mt-4">
                        <div class="col">
                            <div class="mb-3">
                                <a href="{{ route('login') }}" class="btn btn-success">Já sei a minha senha</a>
                            </div>
                        </div>
                        <div class="col text-end align-self-center">
                            <button type="submit" class="btn btn-secondary px-5">RECUPERAR</button>
                        </div>
                    </div>
                </form>

                @if (session('server_message'))
                    <div class="alert alert-primary mt-4 text-center">
                        {{ session('server_message') }}
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="btn btn-primary px-5">VOLTAR</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection