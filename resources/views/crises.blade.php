<div class="row mb-2">
    <div class="col">
        <div class="card p-4 border shadow-sm">
            <div class="row">
                <div class="col">
                    <h4 class="text-info">{{ $crise['tipo'] }}</h4>
                    <small class="text-secondary"><span class="opacity-75 me-2">Data:</span><strong>{{date('d/m/Y', strtotime($crise['data']))}}</strong></small>
                    <small class="text-secondary"><span class="opacity-75 me-2">Tempo de duração:</span><strong>{{$crise['tempo']}}</strong></small>
                </div>
                <div class="col text-end">
                    <a href=" {{ route('edit', ['id'=> Crypt::encrypt($crise['id'])]) }}" class="btn btn-outline-secondary btn-sm mx-1"><i class="fa-regular fa-pen-to-square"></i></a>
                    <a href=" {{ route('delete', ['id'=> Crypt::encrypt($crise['id'])]) }}" class="btn btn-outline-danger btn-sm mx-1"><i class="fa-regular fa-trash-can"></i></a>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>