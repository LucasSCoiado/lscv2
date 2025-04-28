@extends('layout.main_layout')
@section('content')

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col">

            @include('top_bar')
            <!-- label and cancel -->
            <div class="row">
                <div class="col">
                    <p class="display-6 mb-0">Cadastro de crises</p>
                </div>
                <div class="col text-end">
                    <a href="{{ route('home') }}" class="btn btn-outline-danger">
                        <i class="fa-solid fa-xmark"></i>
                    </a>            
                </div>
            </div>

            <!-- form -->
            <form action="{{ route('store') }}" method="post" class="text-center">
                @csrf
                <div class="row mt-2">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Tipo de crise</label>
                            <input type="text" value="{{ old('txt_tipo') }}" class="form-control bg-primary text-white mx-auto w-50" name="txt_tipo">
                        </div>
                        @error('txt_tipo')
                            <div class="txt-danger">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                            <label class="form-label">Data da crise</label>
                            <input type="date" value="{{ old('txt_data') }}" class="form-control bg-primary text-white mx-auto w-50" name="txt_data">
                        </div>
                        @error('txt_data')
                            <div class="txt-danger">{{ $message }}</div>
                        @enderror
                        <div class="mb-3">
                            <label class="form-label">Tempo de duração</label>
                            <input type="text" value="{{ old('txt_tempo') }}" class="form-control bg-primary text-white mx-auto w-50" name="txt_tempo">
                        </div>
                        @error('txt_tempo')
                            <div class="txt-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-end">
                        <a href="{{ route('home') }}" class="btn btn-secondary px-5"><i class="fa-solid fa-ban me-2"></i>Cancel</a>
                        <button type="submit" class="btn btn-primary px-5"><i class="fa-regular fa-circle-check me-2"></i>Save</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>

@endsection