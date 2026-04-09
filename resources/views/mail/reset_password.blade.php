@extends('layout.layout-guest')
@section('content')
    <div style="font-family: Arial, Helvetica, sans-serif; padding: 20px;">
        <h2>{{ config('app.name') }} - Recuperação de senha</h2>
        <p>Caro <strong>{{ $email }}</strong>, para recuperar a senha do usuário, clique no link abaixo.</p>
        <p><a href="{{ $token_link }}">Recuperar senha</a></p>
        <hr>
        <p style="font-size:12px;color:#666;">Se você não solicitou este e-mail, ignore-o.</p>
        <p>Atenciosamente, <br>Equipe de suporte</p>
    </div>

@endsection