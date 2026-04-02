<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Avisos</h2>
        </div>
        <div class="col-auto">
            @if(auth()->user()->isAdministrador() || auth()->user()->isGestor())
            <a href="{{ route('operacional.avisos.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Aviso
            </a>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Filtros --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('operacional.avisos.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Prioridade</label>
                    <select name="priority" class="form-select">
                        <option value="">Todas</option>
                        <option value="baixa"   @selected(request('priority') === 'baixa')>Baixa</option>
                        <option value="normal"  @selected(request('priority') === 'normal')>Normal</option>
                        <option value="alta"    @selected(request('priority') === 'alta')>Alta</option>
                        <option value="urgente" @selected(request('priority') === 'urgente')>Urgente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <input type="text" name="type" class="form-control" placeholder="Ex: Comunicado" value="{{ request('type') }}">
                </div>
                @if(!auth()->user()->isAdministrador())
                <div class="col-md-3">
                    <label class="form-label">Status de Leitura</label>
                    <select name="read_status" class="form-select">
                        <option value="">Todos</option>
                        <option value="nao_lido" @selected(request('read_status') === 'nao_lido')>Não lido</option>
                        <option value="lido"     @selected(request('read_status') === 'lido')>Lido</option>
                    </select>
                </div>
                @endif
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    <a href="{{ route('operacional.avisos.index') }}" class="btn btn-ghost-secondary ms-1">Limpar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Prioridade</th>
                            <th>Autor</th>
                            <th>Data</th>
                            <th>Status</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($avisos as $aviso)
                    @php
                        $isRead = $aviso->isReadBy(auth()->user());
                    @endphp
                    <tr>
                        <td>
                            @if($aviso->is_pinned)
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-warning me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4v6l-2 4v2h10v-2l-2-4v-6"/><path d="M12 16l0 5"/><path d="M8 4l8 0"/></svg>
                            @endif
                            <a href="{{ route('operacional.avisos.show', $aviso) }}" class="text-reset{{ $isRead ? '' : ' fw-bold' }}">
                                {{ $aviso->title }}
                            </a>
                        </td>
                        <td><span class="text-muted">{{ $aviso->type ?: '-' }}</span></td>
                        <td>
                            <span class="badge bg-{{ $aviso->priorityColor() }}-lt">{{ $aviso->priorityLabel() }}</span>
                        </td>
                        <td>{{ $aviso->author?->name }}</td>
                        <td class="text-muted">{{ $aviso->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($isRead)
                            <span class="text-success d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/></svg>
                                Lido
                            </span>
                            @else
                            <span class="text-muted d-flex align-items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9"/><path d="M12 8l0 4"/><path d="M12 16l.01 0"/></svg>
                                Não lido
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('operacional.avisos.show', $aviso) }}" class="btn btn-sm btn-ghost-secondary" title="Visualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7"/></svg>
                                </a>
                                @if(auth()->user()->isAdministrador() || auth()->user()->isGestor())
                                <form method="POST" action="{{ route('operacional.avisos.destroy', $aviso) }}"
                                      onsubmit="return confirm('Excluir este aviso?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/><path d="M9 7v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Nenhum aviso encontrado.</td>
                    </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($avisos->hasPages())
        <div class="card-footer d-flex justify-content-end">
            {{ $avisos->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
