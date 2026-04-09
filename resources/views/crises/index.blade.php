@extends('layout.main_layout')
@section('content')

    <div class="w-100 p-4">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Crises</h3>
            <a href="{{ route('create') }}" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Nova crise
            </a>
        </div>
        <hr>
        <div class="col-md-8 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Crises do mês: </h3>
                <p>Total de crises: {{ $totalMes }}</p>
            </div>
            {{-- Tabela com as crises do mês --}}
            <div class="d-flex flex-wrap gap-2">
                @foreach ($listaDias as $dia => $total)
                    <div class="rounded p-2 text-center {{ $total > 0 ? 'bg-danger text-white' : 'bg-light' }}"
                        style="width: 70px;">
                        <div><strong>{{ str_pad($dia, 2, '0', STR_PAD_LEFT) }}</strong></div>
                        <div>{{ $total }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="mb-4">
            <h3>Calendário Anual {{ $ano }}</h3>

            <div class="d-flex flex-wrap gap-2">
                @php
                    \Carbon\Carbon::setLocale('pt_PT');
                @endphp
                @for ($mes = 1; $mes <= 12; $mes++)
                    <button class="btn btn-outline-primary btn-sm" onclick="mostrarCalendario({{ $mes }})">
                        {{  \Carbon\Carbon::create()->month($mes)->translatedFormat('M') }}
                    </button>
                @endfor
            </div>
        </div>

        <div id="calendarioMensal" style="display:none;"></div>

    </div>
    <script>
        const crisesPorDia = @json($crisesPorDiaAno);
        const ano = {{ $ano }};

        function abrirDia(mes, dia) {
            console.log('abrirDia chamado:', { mes, dia });
            console.log('crisesPorDia:', crisesPorDia);

            const entrada = crisesPorDia[mes]?.find(c => c.dia == dia);
            console.log('entrada encontrada:', entrada);

            if (!entrada) {
                alert("Nenhuma crise nesse dia");
                return;
            }

            const id = entrada.ids[0]; // pega o primeiro id
            console.log('ID selecionado:', id);

            const url = '{{ url("/dados-crise") }}/' + id;
            console.log('URL gerada:', url);

            window.location.href = url;
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