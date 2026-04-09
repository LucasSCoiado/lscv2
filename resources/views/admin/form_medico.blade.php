<div class="container mt-5">
    <div class="row justify-content-center">
        <form action="{{ route('admin.store_medico') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome do médico" required>
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
                <label for="crm">CRM</label>
                <input type="text" id="crm" name="crm" class="form-control" placeholder="Digite o crm do médico" required>
                @error('crm')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="especialidade">Especialidade</label>
                <input type="text" id="especialidade" name="especialidade" class="form-control" placeholder="Digite a especialidade do médico" required>
                @error('especialidade')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control" placeholder="Digite o telefone do médico" required>
                @error('telefone')
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
                <label for="nome_usuario">Nome de usuário</label>
                <input type="text" id="nome_usuario" name="nome_usuario" class="form-control" placeholder="Digite seu nome" required>
                @error('nome_usuario')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="permissoes">Permissões</label>
                <input type="text" id="permissoes" name="permissoes" class="form-control" placeholder="É mAdmin ou comum?" required>
                @error('permissoes')
                    <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="row mt-3">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Criar conta</button>
                    <a href="{{ route('admin.medicos') }}" class="btn btn-danger"><i class="fa-solid fa-x"></i> Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>