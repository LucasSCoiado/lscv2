<div class="row">
    <div class="col">
        <div class="card p-4">
            <div class="row">
                <div class="col">
                    <h4 class="text-info">{{ $crise['tipo'] }}</h4>
                    <small class="text-secondary"><span class="opacity-75 me-2">Data:</span><strong>{{$crise['data']}}</strong></small>
                    <small class="text-secondary"><span class="opacity-75 me-2">Tempo de duração:</span><strong>{{$crise['tempo']}}</strong></small>
                </div>
                <div class="col text-end">
                    <a href="#" class="btn btn-outline-secondary btn-sm mx-1"><i class="fa-regular fa-pen-to-square"></i></a>
                    <a href="#" class="btn btn-outline-danger btn-sm mx-1"><i class="fa-regular fa-trash-can"></i></a>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>