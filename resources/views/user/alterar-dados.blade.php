@extends('layout.main_layout')
@section('content')
    <div class="container">
        <h2>Alterar dados</h2>
        <hr>
        <div class="container">
            <div class="border p-5 shadow-sm">
                    <form action="{{ route('user.update-user', ['id'=>$user->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h3>Usuário: {{$user->nome}}</h3>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome de usuário</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="{{ $user->nome }}">
                        @error('nome')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}">
                        @error('email')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @can('admin')
                        <div class="mb-3">
                            <label for="role" class="form-label">Função</label>
                            <input type="text" name="role" id="role" class="form-control" value="{{ $user->role }}">
                            @error('role')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endcan
                    @can('medico')
                        <div class="mb-3">
                            <label for="crm" class="form-label">CRM</label>
                            <input type="text" name="crm" id="crm" class="form-control" value="{{ $user->medico->crm ?? '' }}">
                            @error('crm')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endcan
                    @can('medico')
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" value="{{ $user->medico->telefone ?? '' }}">
                            @error('telefone')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endcan
                    @can('paciente')
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" value="{{ $user->paciente->telefone ?? '' }}">
                            @error('telefone')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endcan
                    @can('medico')
                        <div class="mb-3">
                            <label for="especialidade" class="form-label">Especialidade</label>
                            <input type="text" name="especialidade" id="especialidade" class="form-control" value="{{ $user->medico->especialidade ?? '' }}">
                            @error('especialidade')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endcan

                    @can('admin')
                        <div class="mb-3">
                            <label for="permisions" class="form-label">Permissões</label>
                            <input type="text" name="permisions" id="permisions" class="form-control" value="{{ $user->permissions }}">
                            @error('permisions')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endcan
                    <div class="form-group">
                        <label for="imagem">Foto de perfil</label>
                        <input type="file" id="imagem" name="imagem" class="form-control-file" value="{{ $user->foto }}">
                        @error('imagem')
                            <div class="text-danger">{{$message}}</div>
                        @enderror
                        @if ($user->foto)
                            <div class="mt-2">
                                <p class="text-muted small">Imagem atual:</p>
                                <img id="imagemAtual" src="{{ asset('storage/' . $user->foto) }}" alt="Foto de perfil" style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                            </div>
                        @endif
                        <div id="imagemPreview" class="mt-2" style="display: none;">
                            <p class="text-muted small">Pré-visualização:</p>
                            <img id="imagemSelecionada" style="max-width: 100px; max-height: 100px; border-radius: 5px;">
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a href="{{ route('user.index') }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>

                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        Mensagem de erro
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('imagem').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('imagemPreview').style.display = 'block';
                    document.getElementById('imagemSelecionada').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection