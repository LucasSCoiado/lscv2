<div class="container">
    <div class="border p-5 shadow-sm">
        <form action="{{ route('user.update-password', ['id' => auth()->user()->id]) }}" method="post">
            @csrf
            <h3>Alterar senha</h3>
            <div class="mb-3">
                <label for="antiga" class="form-label">Senha antiga</label>
                <input type="password" name="antiga" id="antiga" class="form-control">
                @error('antiga')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Nova senha</label>
                <input type="password" name="senha" id="senha" class="form-control">
                @error('senha')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="confirmar_senha" class="form-label">Confirmação da senha</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" class="form-control">
                @error('confirmar_senha')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="{{ route('user.index') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>

        @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        
        @elseif (session('success'))
            <div class="alert alert-success mt-3">
                Senha alterada com sucesso
            </div>
        @endif
    </div>
</div>