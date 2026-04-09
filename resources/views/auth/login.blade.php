@extends('layout.layout-guest')
@section('content')

<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8">
                <!-- logo -->
                <div class="text-center p-3">
                    <img class="logo" src="img/emblema_médico.png" alt="Logo LSC" width="100px">
                </div>
            <div class="card p-3">
                <!-- form -->
                <div class="row justify-content-center">
                    <h2 class="text-center">Login</h2>
                    <form action="{{route('login')}}" method="post" >
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" autocomplete="username" required>
                            {{-- show errors --}}
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input id="password" type="password" class="form-control txt-info" name="password">
                            {{-- show errors --}}
                            @error('password')
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
                    <div class="d-flex justify-content-end align-items-center ml-3">
                        {{-- <a href="{{ route('user.create') }}" class="btn btn-outline-secondary px-3 mx-1">Registrar</a> --}}
                        <a href="{{ route('forgot-password') }}" class="btn btn-outline-secondary px-3 mx-1">Esqueci minha senha</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection