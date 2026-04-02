<x-app-layout>

    @php
        $roleColor = match($usuario->role?->slug) {
            'administrador' => 'red',
            'gestor'        => 'blue',
            'franqueado'    => 'orange',
            'colaborador'   => 'green',
            default         => 'secondary',
        };
    @endphp

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">
                {{ $usuario->name }}
                @if($usuario->role)
                <span class="badge bg-{{ $roleColor }}-lt text-{{ $roleColor }} ms-2">{{ $usuario->role->name }}</span>
                @endif
            </h2>
            <div class="text-muted">{{ $usuario->email }}</div>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
            <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                </svg>
                Editar
            </a>
            @if($usuario->id !== auth()->id())
            <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}"
                  onsubmit="return confirm('Excluir este usuário? Esta ação não pode ser desfeita.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                    </svg>
                    Excluir
                </button>
            </form>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row row-cards">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informações</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="avatar avatar-lg rounded"
                              style="background-color:var(--tblr-primary);color:#fff;font-weight:700;font-size:1.5rem;">
                            {{ strtoupper(substr($usuario->name, 0, 2)) }}
                        </span>
                        <div>
                            <div class="fw-bold fs-4">{{ $usuario->name }}</div>
                            <div class="text-muted">{{ $usuario->email }}</div>
                        </div>
                    </div>
                    <dl class="row">
                        <dt class="col-5 text-muted">Perfil</dt>
                        <dd class="col-7">
                            @if($usuario->role)
                            <span class="badge bg-{{ $roleColor }}-lt text-{{ $roleColor }}">{{ $usuario->role->name }}</span>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </dd>

                        <dt class="col-5 text-muted">Cadastrado em</dt>
                        <dd class="col-7">{{ $usuario->created_at->format('d/m/Y \à\s H:i') }}</dd>

                        <dt class="col-5 text-muted">Atualizado</dt>
                        <dd class="col-7">{{ $usuario->updated_at->diffForHumans() }}</dd>

                        <dt class="col-5 text-muted">E-mail verificado</dt>
                        <dd class="col-7">
                            @if($usuario->email_verified_at)
                            <span class="text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/>
                                </svg>
                                {{ $usuario->email_verified_at->format('d/m/Y') }}
                            </span>
                            @else
                            <span class="text-muted">Não verificado</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        @if($usuario->role)
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sobre o perfil: {{ $usuario->role->name }}</h3>
                </div>
                <div class="card-body">
                    @foreach(\App\Enums\RoleEnum::cases() as $roleEnum)
                        @if($roleEnum->value === $usuario->role->slug)
                        <p class="text-muted">{{ $roleEnum->description() }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
