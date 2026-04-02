<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Gerenciar Usuários</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Usuário
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body border-bottom py-3">
            <form method="GET" action="{{ route('admin.usuarios.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
                <div class="text-secondary me-auto">
                    Total: <strong>{{ $users->total() }}</strong> usuários
                </div>
                <select name="role_id" class="form-select form-select-sm w-auto" data-no-select2 onchange="this.form.submit()">
                    <option value="">Todos os perfis</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                    @endforeach
                </select>
                <div class="input-group input-group-sm w-auto">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control" placeholder="Buscar por nome ou e-mail...">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                </div>
                @if(request('search') || request('role_id'))
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-sm btn-ghost-secondary">Limpar</a>
                @endif
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Cadastrado em</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="avatar avatar-sm rounded"
                                      style="background-color:var(--tblr-primary);color:#fff;font-weight:700;">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                    <span class="badge bg-blue-lt text-blue" style="font-size:.65rem">Você</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $user->email }}</td>
                        <td>
                            @if($user->role)
                            @php
                                $roleColor = match($user->role->slug) {
                                    'administrador' => 'red',
                                    'gestor'        => 'blue',
                                    'franqueado'    => 'orange',
                                    'colaborador'   => 'green',
                                    default         => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $roleColor }}-lt text-{{ $roleColor }}">{{ $user->role->name }}</span>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('admin.usuarios.show', $user) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Visualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="2"/>
                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.usuarios.edit', $user) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                    </svg>
                                </a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.usuarios.destroy', $user) }}"
                                      onsubmit="return confirm('Excluir o usuário {{ addslashes($user->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Nenhum usuário encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
