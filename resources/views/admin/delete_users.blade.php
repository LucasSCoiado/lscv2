@extends('layout.main_layout')
@section('content')
    <div class="w-100 p-4">

        <h3>
            Apagar {{ $user->role === 'medico' ? 'Médico' : 'Paciente' }}
        </h3>

        <div class="card p-4 mt-3">

            <p>
                Tem certeza que deseja apagar
                {{ $user->role === 'medico' ? 'o médico' : 'o paciente' }}
                <strong>
                    {{ $user->role === 'medico' ? $medico->nome : $paciente->nome }}
                </strong>?
            </p>

            <form method="POST"
                action="{{ $user->role === 'medico'
                    ? route('admin.destroy_medico', $medico->id)
                    : route('admin.destroy_paciente', $paciente->id) }}">

                @csrf

                <button type="submit" class="btn btn-danger">
                    Confirmar exclusão
                </button>

                <a href="{{ $user->role === 'medico'
                        ? route('admin.medicos')
                        : route('admin.pacientes') }}"
                   class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>
@endsection