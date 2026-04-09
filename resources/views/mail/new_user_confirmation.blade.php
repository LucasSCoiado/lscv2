@extends('layout.layout-guest')
@section('content')
    <div style="font-family: Arial, Helvetica, sans-serif; padding: 20px;">
        <h2>{{ config('app.name') }} - Confirmação de cadastro</h2>
        <p>Olá,</p>
        <p>Sua conta foi criada. Abaixo estão os dados de acesso temporários:</p>
        <ul>
            <li><strong>E-mail:</strong> {{ $email }}</li>
            <li><strong>Senha temporária:</strong> {{ $password }}</li>
        </ul>
        <p>Para confirmar sua conta, clique no link abaixo:</p>
        <p><a href="{{ $confirmation_link }}">Confirmar minha conta</a></p>
        <p>Após confirmar, você poderá alterar a senha ao acessar o sistema.</p>
        <hr>
        <p style="font-size:12px;color:#666;">Se você não solicitou este e-mail, ignore-o.</p>
    </div>
@endsection
