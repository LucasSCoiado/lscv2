@extends('layout.main_layout')
@section('content')
    <div class="w-100 p-4">
        <h3>Pacientes</h3>
        <hr>
        @if($user->role === 'admin')
            <div class="d-flex justify-content-end mb-3">
                @if ($pacientes->count() > 0)
                    <a href="{{ route('admin.cadastrar_paciente') }}" class="btn btn-secondary btn-sm p-2">
                        <i class="fa-solid fa-plus"></i> Novo paciente
                    </a>
                @endif
            </div>
        @endif
        @if ($pacientes->count() == 0)
            @if($user->role === 'admin')
                <div class="text-center my-5">
                    <p>Sem pacientes cadastrados</p>
                    <a href="{{ route('admin.cadastrar_paciente') }}" class="btn btn-primary"><i class="fa-solid fa-plus"></i>
                        Novo paciente
                    </a>
                </div>
            @endif
        @else
            <div class="table-responsive">
                <table class="table table-striped align-middle" id="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>

                            <th class="d-none d-md-table-cell">Idade</th>
                            <th class="d-none d-md-table-cell">Telefone</th>
                            <th class="d-none d-md-table-cell">Crises</th>
                            <th class="d-none d-md-table-cell"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($user->role === 'admin')
                            @foreach($pacientes as $paciente)
                                <tr>
                                    <td>
                                        <a href="{{ route('dados.paciente', ['id' => $paciente->id]) }}"
                                            class="text-decoration-none text-dark link-hover">
                                            {{ $paciente->nome }}
                                        </a>
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        {{ $paciente->idade }}
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        {{ $paciente->telefone }}
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        @php $count = $crises[$paciente->id] ?? 0; @endphp
                                        @if ($count > 0)
                                            {{ $count }}
                                        @else
                                            Sem crises
                                        @endif
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        <a href="{{ route('admin.edit_paciente', $paciente->id) }}" class="btn btn-sm btn-primary"><i
                                                class="fa-solid fa-pen-to-square"></i> Editar</a>
                                        <a href="{{ route('admin.deletar_paciente', $paciente->id) }}" class="btn btn-sm btn-danger"><i
                                                class="fa-solid fa-trash-can"></i> Apagar</a>
                                    </td>
                                </tr>

                            @endforeach
                        @endif
                        @if($user->role === 'medico')
                            @foreach($meusPacientes as $paciente)
                                <tr>
                                    <td>
                                        <a href="{{ route('dados.paciente', ['id' => $paciente->id]) }}"
                                            class="text-decoration-none text-dark link-hover">
                                            {{ $paciente->nome }}
                                        </a>
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        {{ $paciente->idade }}
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        {{ $paciente->telefone }}
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        @php $count = $crises[$paciente->id] ?? 0; @endphp
                                        @if ($count > 0)
                                            {{ $count }}
                                        @else
                                            Sem crises
                                        @endif
                                    </td>

                                    <td class="d-none d-md-table-cell">
                                        <a href="{{ route('dados.paciente', ['id' => $paciente->id]) }}"
                                            class="btn btn-sm btn-primary"><i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>

                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection