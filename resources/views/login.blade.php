@extends('layout.main_layout')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8">
                <!-- logo -->
                <div class="text-center p-3">
                    <img class="logo" src="img/emblema_médico.png" alt="Logo LSC" width="200px">
                </div>
            <div class="card p-5">
                <!-- form -->
                <div class="row justify-content-center">
                    <h2 class="text-center">Login</h2>
                    <form action="/loginSubmit" method="POST" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="txt_email" class="form-label">Email</label>
                            <input value="{{ old('txt_email') }}" type="email" class="form-control text-info" name="txt_email">
                            {{-- show errors --}}
                            @error('txt_email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="txt_password" class="form-label">Senha</label>
                            <input type="password" class="form-control txt-info" name="txt_password">
                            {{-- show errors --}}
                            @error('txt_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-secondary w-100">LOGIN</button>
                        </div>
                    </form>
                        {{-- ivalid login --}}
                        @if (session('loginError'))
                            <div class="alert alert-danger text-center">
                                {{ session('loginError') }}
                            </div>
                        @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection