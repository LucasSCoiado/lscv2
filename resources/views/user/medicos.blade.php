@extends('layout.main_layout')
@section('content')

    <div class="w-100 p-4">
        <h3>Médicos</h3>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.create_medico') }}" class="btn btn-secondary btn-sm p-2"><i class="fa-solid fa-plus"></i> Cadastrar médico</a>
        </div>
        @if ($medicos->count() == 0)
            <div class="text-center my-5">
                <p>Sem médicos cadastrados</p>
                <a href="{{ route('admin.create_medico') }}" class="btn btn-secondary btn-sm p-2"><i class="fa-solid fa-plus"></i> Cadastrar médico</a>
            </div>
        @else
            <table class="table table-striped align-middle" id="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Especialidade</th>
                        <th scope="col">CRM</th>
                        @can('admin')
                            <th scope="col"></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medicos as $medico)
                        <tr>
                            <td class="d-none d-md-table-cell"><a class="text-decoration-none text-dark link-hover" href="{{ route('dados.medico',  ['id' => $medico->id]) }}">{{ $medico->nome }}</a></td>
                            <td class="d-none d-md-table-cell">{{ $medico->especialidade }}</td>
                            <td class="d-none d-md-table-cell">{{ $medico->crm }}</td>
                           @can('admin')
                            <td class="d-none d-md-table-cell">
                                <a href="{{ route('admin.edit_medico',  ['id' => $medico->id]) }}" class="btn btn-primary btn-sm p-2"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                                <a href="{{ route('admin.deletar_medico', ['id' => $medico->id]) }}" class="btn btn-danger btn-sm p-2"><i class="fa-solid fa-trash-can"></i> Excluir</a>
                            </td>
                           @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@endsection