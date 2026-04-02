<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Novo Usuário</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
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

    <form method="POST" action="{{ route('admin.usuarios.store') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Dados do Usuário</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Nome completo</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Nome do usuário">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@illuminare.com.br">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Perfil de acesso</label>
                        <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">
                            <option value="">Selecione o perfil</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Senha</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Mínimo 8 caracteres" autocomplete="new-password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Confirmar senha</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" placeholder="Repita a senha" autocomplete="new-password">
                    </div>
                </div>
            </div>
        </div>

        {{-- Descrição dos perfis --}}
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Perfis disponíveis</h3>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @foreach(\App\Enums\RoleEnum::cases() as $roleEnum)
                    @php
                        $color = match($roleEnum->value) {
                            'administrador' => 'red',
                            'gestor'        => 'blue',
                            'franqueado'    => 'orange',
                            'colaborador'   => 'green',
                            default         => 'secondary',
                        };
                    @endphp
                    <div class="col-md-6">
                        <div class="card card-sm border">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-{{ $color }}-lt text-{{ $color }}">{{ $roleEnum->label() }}</span>
                                </div>
                                <small class="text-muted">{{ $roleEnum->description() }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Criar Usuário</button>
        </div>
    </form>
</x-app-layout>
