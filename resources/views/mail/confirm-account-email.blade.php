@extends('layout.layout-guest')
@section('content')
    <div style="font-family: Arial, Helvetica, sans-serif; padding: 20px;">
        <h2>{{ config('app.name') }} - Confirme sua conta</h2>
        <p>Olá,</p>
        <p>Para confirmar sua conta, clique no link abaixo:</p>
        <p><a href="{{ $url }}">Confirmar minha conta</a></p>
        <hr>
        <p style="font-size:12px;color:#666;">Se você não solicitou este e-mail, ignore-o.</p>
    </div>
@endsection
