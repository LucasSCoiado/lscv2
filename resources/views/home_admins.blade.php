<div class="w-100 p-4">
    <h3>Home</h3>
    <hr>
    <h5>Resumo de dados</h5>
    <div class="col-2">
        <div class="d-flex rounded mb-3">
            <x-info_paciente itemTitle="Pacientes" :itemValue="$pacientes"/>
        </div>
        <div class="d-flex rounded mb-3">
            <x-info_medicos itemTitle="Médicos" :itemValue="$medicos"/>
        </div>
    </div>
</div>