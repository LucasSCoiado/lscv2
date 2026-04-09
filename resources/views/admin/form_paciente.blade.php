<div class="container mt-5">
    <div class="row justify-content-center">

        <form action="{{ route('admin.store_paciente') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite seu nome" required>
                @error('nome')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="imagem">Foto de perfil</label>
                <input type="file" id="imagem" name="imagem" class="form-control-file">
                @error('imagem')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nome_usuario">Nome de usuário</label>
                <input type="text" id="nome_usuario" name="nome_usuario" class="form-control" placeholder="Digite seu nome" required>
                @error('nome_usuario')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="idade">Idade</label>
                <input type="number" id="idade" name="idade" class="form-control" placeholder="Digite sua idade" required>
                @error('idade')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Gênero sexual</label>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="genero" id="genero_m" value="masculino">
                    <label class="form-check-label" for="genero_m">
                        Masculino
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="genero" id="genero_f" value="feminino">
                    <label class="form-check-label" for="genero_f">
                        Feminino
                    </label>
                </div>
                @error('genero')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu email" required>
                @error('email')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="telefone">telefone</label>
                <input type="number" id="telefone" name="telefone" class="form-control" placeholder="Digite seu telefone" required>
                @error('telefone')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="row mt-3">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Criar conta</button>
                    <a href="{{ route('admin.pacientes') }}" class="btn btn-danger"><i class="fa-solid fa-x"></i> Cancelar</a>
                </div>
            </div>
        </form>

    </div>
</div>
