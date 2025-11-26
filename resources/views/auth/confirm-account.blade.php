@extends('layout.main_layout')
@section('content')
<div class="container mt-5">
    {{-- <h3>Confirmar conta</h3>
    <form action="{{ route('confirm-account-submit') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $user->token }}">
        <p>Email: {{ $user->email }}</p>
        <button type="submit" class="btn btn-primary">Confirmar conta</button>
    </form> --}}
    <div class="container mt-5">
        <div class="row">
            <div class="col text-center">
                <div class="card p-5 text-center">
                    <p class="display-6">A sua conta de usuário foi confirmada com sucesso.</p>
                    <p class="display-6"><strong>Bem-vindo!<strong></p>
                    <div class="mt-5">
                        <a href="{{ route('home') }}" class="btn btn-secondary px-5">OK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
