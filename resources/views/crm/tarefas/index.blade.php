<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Minhas Tarefas</h2>
            <p class="text-muted mt-1">Gestão de tarefas e atividades</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.tarefas.kanban') }}" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="4" width="6" height="16" rx="1"/><rect x="14" y="4" width="6" height="10" rx="1"/>
                </svg>
                Kanban
            </a>
            <a href="{{ route('crm.tarefas.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Nova Tarefa
            </a>
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
        <div class="card-body py-2">
            <form method="GET" action="{{ route('crm.tarefas.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3 col-6">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control form-control-sm" placeholder="Buscar registros">
                </div>
                <div class="col-md-2 col-6">
                    <select name="tipo" class="form-select form-select-sm">
                        <option value="">Tipo</option>
                        <option value="ligacao"   {{ request('tipo') === 'ligacao'   ? 'selected' : '' }}>Ligação</option>
                        <option value="email"     {{ request('tipo') === 'email'     ? 'selected' : '' }}>E-mail</option>
                        <option value="reuniao"   {{ request('tipo') === 'reuniao'   ? 'selected' : '' }}>Reunião</option>
                        <option value="follow_up" {{ request('tipo') === 'follow_up' ? 'selected' : '' }}>Follow-up</option>
                        <option value="outro"     {{ request('tipo') === 'outro'     ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select name="prioridade" class="form-select form-select-sm">
                        <option value="">Prioridade</option>
                        <option value="baixa"   {{ request('prioridade') === 'baixa'   ? 'selected' : '' }}>Baixa</option>
                        <option value="media"   {{ request('prioridade') === 'media'   ? 'selected' : '' }}>Média</option>
                        <option value="alta"    {{ request('prioridade') === 'alta'    ? 'selected' : '' }}>Alta</option>
                        <option value="urgente" {{ request('prioridade') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Status</option>
                        <option value="pendente"     {{ request('status') === 'pendente'     ? 'selected' : '' }}>Pendente</option>
                        <option value="em_andamento" {{ request('status') === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="concluida"    {{ request('status') === 'concluida'    ? 'selected' : '' }}>Concluída</option>
                        <option value="cancelada"    {{ request('status') === 'cancelada'    ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">Responsável</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-secondary">Filtrar</button>
                    @if(request()->hasAny(['search','tipo','prioridade','status','user_id']))
                    <a href="{{ route('crm.tarefas.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body border-bottom py-2">
            <div class="text-secondary">
                Exibindo <strong>{{ $tasks->count() }}</strong> de <strong>{{ $tasks->total() }}</strong> registros
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Responsável</th>
                        <th>Vencimento</th>
                        <th>Relacionado</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $tarefa)
                    <tr class="{{ $tarefa->is_atrasada ? 'table-danger' : '' }}">
                        <td>
                            <a href="{{ route('crm.tarefas.show', $tarefa) }}" class="fw-semibold text-reset">
                                {{ $tarefa->titulo }}
                            </a>
                            @if($tarefa->is_atrasada)
                            <span class="badge bg-red-lt text-red ms-1">Atrasada</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $tarefa->tipo_label }}</td>
                        <td>
                            <span class="badge bg-{{ $tarefa->prioridade_color }}-lt text-{{ $tarefa->prioridade_color }}">
                                {{ $tarefa->prioridade_label }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $tarefa->status_color }}-lt text-{{ $tarefa->status_color }}">
                                {{ $tarefa->status_label }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $tarefa->user?->name ?? '—' }}</td>
                        <td class="text-muted text-nowrap">
                            {{ $tarefa->data_vencimento?->format('d/m/Y H:i') ?? '—' }}
                        </td>
                        <td class="text-muted">
                            @if($tarefa->taskable)
                                {{ $tarefa->taskable->nome_completo ?? $tarefa->taskable->titulo ?? '—' }}
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('crm.tarefas.show', $tarefa) }}" class="btn btn-sm btn-ghost-secondary" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667-6 7-10 7s-7.333-2.333-10-7c2.667-4.667 6-7 10-7s7.333 2.333 10 7"/>
                                    </svg>
                                </a>
                                <a href="{{ route('crm.tarefas.edit', $tarefa) }}" class="btn btn-sm btn-ghost-secondary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97l-8.415 8.385v3h3l8.385-8.415z"/>
                                    </svg>
                                </a>
                                @if(!in_array($tarefa->status, ['concluida','cancelada']))
                                <form method="POST" action="{{ route('crm.tarefas.concluir', $tarefa) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-ghost-success" title="Concluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                <form method="POST" action="{{ route('crm.tarefas.destroy', $tarefa) }}"
                                      onsubmit="return confirm('Remover esta tarefa?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <line x1="4" y1="7" x2="20" y2="7"/><line x1="10" y1="11" x2="10" y2="17"/>
                                            <line x1="14" y1="11" x2="14" y2="17"/>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/>
                                            <path d="M9 7v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Nenhuma tarefa encontrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tasks->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $tasks->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
