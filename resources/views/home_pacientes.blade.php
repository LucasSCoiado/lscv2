<div class="col">

    @if(count($crises) == 0)
        <div class="row mt-5">
            <div>
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th colspan="12" class="text-start">Ver calendário por mês</th>
                            </tr>
                            <tr>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(1)">Jan</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(2)">Fev</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(3)">Mar</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(4)">Abr</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(5)">Mai</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(6)">Jun</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(7)">Jul</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(8)">Ago</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(9)">Set</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(10)">Out</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(11)">Nov</button></th>
                                <th><button class="btn btn-sm btn-outline-primary w-100"
                                        onclick="mostrarCalendario(12)">Dez</button></th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div id="calendarioMensal" class="mt-4 mx-auto text-center" style="display:none; max-width: 720px;"></div>
            </div>
            <div class="col text-center">
                <p class="display-6 mb-5 text-secondary opacity-50">Sem eplepsias informadas ao sistema!</p>
                <a href="{{ route('create') }}" class="btn btn-secondary btn-lg p-3 px-5">
                    <i class="fa-regular fa-pen-to-square fas fa-plus me-3"></i> Nova crise
                </a>
            </div>
        </div>

    @else

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('create') }}" class="btn btn-secondary px-3">
                <i class=" fas fa-plus me-2"></i> Nova crise
            </a>
        </div>
        <div>
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th colspan="12" class="text-start">Ver calendário por mês</th>
                        </tr>
                        <tr>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(1)">Jan</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(2)">Fev</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(3)">Mar</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(4)">Abr</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(5)">Mai</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(6)">Jun</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(7)">Jul</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(8)">Ago</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(9)">Set</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(10)">Out</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(11)">Nov</button></th>
                            <th><button class="btn btn-sm btn-outline-primary w-100"
                                    onclick="mostrarCalendario(12)">Dez</button></th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="calendarioMensal" class="mt-4 mx-auto text-center" style="display:none; max-width: 720px;"></div>
        </div>
        <div>
            <p class="text-secondary display-6 mb-0">Eplepsias do mês</p>
            <h5>{{ $crisesMes }}</h5>
        </div>
        <h3 class="text-center text-secondary">Crises</h3>
        @foreach ($crises as $crise)
            @include('crises')
        @endforeach
    @endif


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
                    ${total > 0 ? ` <span class="badge bg-danger">${total}</span>` : `<span class="text-muted">0</span>`}
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