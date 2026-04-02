<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Detalhes da Tarefa</h2>
        </div>
        <div class="col-auto d-flex gap-2">
            @if(!in_array($tarefa->status, ['concluida', 'cancelada']))
            <form method="POST" action="{{ route('crm.tarefas.concluir', $tarefa) }}">
                @csrf
                <button type="submit" class="btn btn-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/>
                    </svg>
                    Concluir
                </button>
            </form>
            @endif
            <a href="{{ route('crm.tarefas.edit', $tarefa) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 7h-1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97l-8.415 8.385v3h3l8.385-8.415z"/>
                </svg>
                Editar
            </a>
            <a href="{{ route('crm.tarefas.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-3">
        <div class="col-md-7">

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">{{ $tarefa->titulo }}</h3>
                </div>
                <div class="card-body">
                    <h4 class="subheader">Informações Básicas</h4>
                    <dl class="row">
                        <dt class="col-5 text-muted">Título:</dt>
                        <dd class="col-7">{{ $tarefa->titulo }}</dd>

                        <dt class="col-5 text-muted">Tipo:</dt>
                        <dd class="col-7">{{ $tarefa->tipo_label }}</dd>

                        <dt class="col-5 text-muted">Status:</dt>
                        <dd class="col-7">
                            <span class="badge bg-{{ $tarefa->status_color }}-lt text-{{ $tarefa->status_color }}">
                                {{ $tarefa->status_label }}
                            </span>
                        </dd>

                        <dt class="col-5 text-muted">Prioridade:</dt>
                        <dd class="col-7">
                            <span class="badge bg-{{ $tarefa->prioridade_color }}-lt text-{{ $tarefa->prioridade_color }}">
                                {{ $tarefa->prioridade_label }}
                            </span>
                        </dd>

                        <dt class="col-5 text-muted">Responsável:</dt>
                        <dd class="col-7">{{ $tarefa->user?->name ?? '—' }}</dd>

                        <dt class="col-5 text-muted">Criado por:</dt>
                        <dd class="col-7">{{ $tarefa->assignedBy?->name ?? '—' }}</dd>

                        <dt class="col-5 text-muted">Data de Vencimento:</dt>
                        <dd class="col-7">
                            @if($tarefa->data_vencimento)
                                <span class="{{ $tarefa->is_atrasada ? 'text-danger fw-semibold' : '' }}">
                                    {{ $tarefa->data_vencimento->format('d/m/Y H:i') }}
                                </span>
                                @if($tarefa->is_atrasada)
                                    <span class="badge bg-red-lt text-red ms-1">Atrasada</span>
                                @endif
                            @else
                                —
                            @endif
                        </dd>

                        <dt class="col-5 text-muted">Data de Criação:</dt>
                        <dd class="col-7">{{ $tarefa->created_at->format('d/m/Y H:i') }}</dd>

                        @if($tarefa->concluida_em)
                        <dt class="col-5 text-muted">Data de Conclusão:</dt>
                        <dd class="col-7">{{ $tarefa->concluida_em->format('d/m/Y H:i') }}</dd>
                        @endif

                        @if($tarefa->taskable)
                        <dt class="col-5 text-muted">Relacionado a:</dt>
                        <dd class="col-7">
                            {{ $tarefa->taskable->nome_completo ?? $tarefa->taskable->titulo ?? '—' }}
                        </dd>
                        @endif
                    </dl>

                    @if($tarefa->descricao)
                    <hr>
                    <h4 class="subheader">Descrição</h4>
                    <p class="mb-0" style="white-space: pre-wrap">{{ $tarefa->descricao }}</p>
                    @endif
                </div>
            </div>

        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Ações Rápidas</h3></div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('crm.tarefas.edit', $tarefa) }}" class="list-group-item list-group-item-action d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97l-8.415 8.385v3h3l8.385-8.415z"/></svg>
                        Editar tarefa
                    </a>
                    @if(!in_array($tarefa->status, ['concluida', 'cancelada']))
                    <form method="POST" action="{{ route('crm.tarefas.concluir', $tarefa) }}">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-0 w-100 text-start text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/></svg>
                            Marcar como concluída
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('crm.tarefas.destroy', $tarefa) }}"
                          onsubmit="return confirm('Excluir esta tarefa?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="list-group-item list-group-item-action d-flex align-items-center gap-2 border-0 w-100 text-start text-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/><path d="M9 7v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/></svg>
                            Excluir tarefa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
