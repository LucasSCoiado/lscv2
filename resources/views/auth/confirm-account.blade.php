@extends('layout.layout-guest')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card p-4">
                    <h4 class="mb-3">Confirmar conta</h4>
                    <p>Confirme a sua conta para ativar o acesso ao sistema.</p>
                    <form method="POST" action="{{ route('confirm.account.submit') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $user->token ?? '' }}">
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Confirmar minha conta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
