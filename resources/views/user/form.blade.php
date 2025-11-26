<div class="container mt-5">
    <div class="row justify-content-center">

        <form action="{{ route('user.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
                @error('email')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Senha</label>
                <input type="password" name="password" class="form-control" placeholder="Digite sua senha" required>
                @error('password')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Confirme a senha</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirme sua senha" required>
                @error('password_confirmation')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="row mt-3">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">Criar conta</button>
                    <a href="{{ route('login') }}" class="btn btn-danger">Cancelar</a>
                </div>
            </div>
        </form>

    </div>
</div>
