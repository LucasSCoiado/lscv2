@extends('layout.main_layout')
@section('content')
    <div class="container my-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Dados do paciente</h2>

            <a class="btn btn-primary" href="{{ url()->previous() }}">
                <i class="fa-solid fa-door-closed"></i> Voltar
            </a>
        </div>

        <h3>Paciente: {{ $paciente->nome }}</h3>

        <div class="row align-items-center">

            <div class="col-md-8">
                <ul>
                    <li><strong>Nome:</strong> {{ $paciente->nome }}</li>
                    <li><strong>Idade:</strong> {{ $paciente->idade }}</li>
                    <li><strong>Sexo:</strong> {{ $paciente->genero }}</li>
                    <li><strong>Telefone:</strong> {{ $paciente->telefone }}</li>
                    <li><strong>Gmail:</strong> {{ $paciente->user->email }}</li>

                    @can('admin-or-mAdmin')
                        @if ($medico_paciente)
                            <li><strong>Médico responsável:</strong> {{ $medico_paciente->nome }}</li>
                        @else
                            <li><strong>Médico responsável:</strong> Não definido</li>
                        @endif

                    @endcan
                </ul>
            </div>

            <div class="col-md-4 text-center">
                <img class="rounded-circle img-fluid" src="{{ $paciente->user->foto
        ? asset('storage/' . $paciente->user->foto)
        : asset('assets/images/perfil.png') }}" alt="Foto de perfil" style="max-width: 150px;">
            </div>

        </div>
        <hr>
        @php
            use Carbon\Carbon;

            $meses = [
                1 => 'Jan',
                2 => 'Fev',
                3 => 'Mar',
                4 => 'Abr',
                5 => 'Mai',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Ago',
                9 => 'Set',
                10 => 'Out',
                11 => 'Nov',
                12 => 'Dez'
            ];
        @endphp

        <h3 class="mt-4">Crises por mês – {{ $ano }}</h3>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        @foreach ($meses as $numMes => $mes)
                            <th>
                                <button class="btn btn-sm btn-outline-primary w-100" onclick="mostrarCalendario({{ $numMes }})">
                                    {{ $mes }}
                                </button>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($meses as $numMes => $mes)
                            <td>
                                <span class="badge bg-danger">
                                    {{ $crisesPorMes[$numMes] ?? 0 }}
                                </span>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="calendarioMensal" class="mt-4 mx-auto text-center" style="display:none; max-width: 720px;"></div>

        <!-- Modal de detalhes da(s) crise(s) -->
        <div class="modal fade" id="criseModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="criseModalLabel">Detalhes das crises</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body" id="criseModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    </div>
    <script>
        const crisesPorDia = @json($crisesPorDia);
        const ano = {{ $ano }};

        function abrirDia(mes, dia) {
            const entrada = crisesPorDia[mes]?.find(c => c.dia == dia);
            const modalBody = document.getElementById('criseModalBody');
            let html = `<p><strong>Data:</strong> ${String(dia).padStart(2, '0')}/${String(mes).padStart(2, '0')}/${ano}</p>`;
            const total = entrada?.total ?? 0;
            html += `<p><strong>Total:</strong> ${total}</p>`;

            const detalhes = entrada?.crises || entrada?.items || entrada?.detalhes || entrada?.lista;
            if (Array.isArray(detalhes) && detalhes.length) {
                html += '<ul class="list-group">';
                detalhes.forEach(d => {
                    html += `<li class="list-group-item">${d}</li>`;
                });
                html += '</ul>';
            } else if (detalhes) {
                html += `<p>${detalhes}</p>`;
            } else {
                html += '<p class="text-muted">Sem detalhes disponíveis.</p>';
            }

            modalBody.innerHTML = html;
            if (typeof bootstrap !== 'undefined') {
                const modalEl = document.getElementById('criseModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            } else {
                document.getElementById('criseModal').style.display = 'block';
            }
        }

        function mostrarCalendario(mes) {
            const container = document.getElementById('calendarioMensal');
            container.style.display = 'block';

            const data = new Date(ano, mes - 1, 1);
            const diasNoMes = new Date(ano, mes, 0).getDate();
            // Ajuste para começar a semana na segunda-feira (0 = segunda)
            const primeiroDiaSemana = (data.getDay() + 6) % 7;

            let html = `
                <h4 class="mb-3">Crises de ${data.toLocaleString('pt-BR', { month: 'long' })}</h4>

                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Seg</th>
                            <th>Ter</th>
                            <th>Qua</th>
                            <th>Qui</th>
                            <th>Sex</th>
                            <th>Sáb</th>
                            <th>Dom</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
            `;

            for (let i = 0; i < primeiroDiaSemana; i++) {
                html += `<td></td>`;
            }

            for (let dia = 1; dia <= diasNoMes; dia++) {
                const total = crisesPorDia[mes]?.find(c => c.dia == dia)?.total ?? 0;

                html += `
                    <td>
                        <button class="btn btn-sm btn-link p-0" onclick="abrirDia(${mes}, ${dia})"><strong>${dia}</strong></button><br>
                        ${total > 0 ? `<span class="badge bg-danger">${total}</span>` : `<span class="text-muted">0</span>`}
                    </td>
                `;

                if ((dia + primeiroDiaSemana) % 7 === 0) {
                    html += `</tr><tr>`;
                }
            }

            // Preencher células vazias no final da última semana
            const resto = (7 - ((diasNoMes + primeiroDiaSemana) % 7)) % 7;
            for (let i = 0; i < resto; i++) {
                html += `<td></td>`;
            }

            html += `
                        </tr>
                    </tbody>
                </table>
            `;

            html += `
                <button class="btn btn-secondary" onclick="document.getElementById('calendarioMensal').style.display='none'">Fechar</button>
            `;
            container.innerHTML = html;
            container.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
@endsection