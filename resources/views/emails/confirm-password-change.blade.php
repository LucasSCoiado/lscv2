@extends('layout.layout-guest')
@section('content')
    <div class="container">
        <h2>Confirmação de Troca de Senha</h2>
    
        <p>Olá {{ $userName }},</p>
        <p>Sua senha foi alterada com sucesso!</p>
        <p>Se você não fez esta alteração, entre em contato com nosso suporte imediatamente.</p>
        <p>Se tiver dúvidas, estamos aqui para ajudar.</p>
    
        <p>Este é um email automático. Por favor, não responda diretamente.</p>
    </div>
@endsection
