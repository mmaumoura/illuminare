<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">
                Editar Usuário:
                <span class="text-muted fw-normal">{{ $usuario->name }}</span>
            </h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.usuarios.show', $usuario) }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
        @csrf @method('PUT')

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Dados do Usuário</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Nome completo</label>
                        <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">E-mail</label>
                        <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Perfil de acesso</label>
                        <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">
                            <option value="">Selecione o perfil</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role_id', $usuario->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Alterar Senha</h3>
                <div class="card-subtitle text-muted">Deixe em branco para manter a senha atual</div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nova senha</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Mínimo 8 caracteres" autocomplete="new-password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirmar nova senha</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" placeholder="Repita a nova senha" autocomplete="new-password">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.usuarios.show', $usuario) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
</x-app-layout>
