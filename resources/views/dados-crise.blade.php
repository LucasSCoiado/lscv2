@extends('layout.main_layout')
@section('content')
    <div class="p-4">
        <h3>Dados da crise</h3>
        <hr>

        <p><strong>Crise:</strong> {{ $crises->tipo }}</p>
        <p><strong>Data:</strong> {{ Carbon\Carbon::parse($crises->data)->translatedFormat('d/m/Y') }}</p>
        <p><strong>Tempo de duração:</strong> {{ $crises->tempo }}</p>

        <div class="row">
            <div class="d-flex justify-content-end gap-2">
                <a href=" {{ route('edit', ['id'=> Crypt::encrypt($crises['id'])]) }}" class="btn btn-primary sm-btn">Editar</a>
                <a href="{{ route('delete', ['id'=> Crypt::encrypt($crises['id'])]) }}" class="btn btn-danger sm-btn">Apagar</a>
            </div>
        </div>
        <hr>
        <a href="{{ route('paciente.crises') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
@endsection