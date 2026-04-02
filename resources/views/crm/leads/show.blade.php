<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $lead->nome_completo }}</h2>
            <p class="text-muted mt-1">
                <span class="badge bg-{{ $lead->status_color }}-lt text-{{ $lead->status_color }}">{{ $lead->status_label }}</span>
                <span class="ms-1">· {{ $lead->origem_label }}</span>
                @if($lead->convertido_em)
                <span class="ms-1 badge bg-green-lt text-green">Convertido em {{ $lead->convertido_em->format('d/m/Y') }}</span>
                @endif
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            @if(! $lead->crm_client_id && $lead->status !== 'convertido')
            <form method="POST" action="{{ route('crm.leads.converter', $lead) }}">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('Converter este lead em cliente?')">
                    Converter em Cliente
                </button>
            </form>
            @elseif($lead->crmClient)
            <a href="{{ route('crm.clientes.show', $lead->crmClient) }}" class="btn btn-outline-success">
                Ver Cliente
            </a>
            @endif
            <a href="{{ route('crm.leads.edit', $lead) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('crm.leads.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/>
                    <path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
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

    {{-- Contadores resumo --}}
    <div class="row g-2 mb-3">
        <div class="col-auto">
            <span class="badge bg-blue-lt text-blue fs-6 px-3 py-2">
                {{ $lead->tasks_count ?? $lead->tasks->count() }} Tarefas
            </span>
        </div>
        <div class="col-auto">
            <span class="badge bg-purple-lt text-purple fs-6 px-3 py-2">
                {{ $lead->opportunities->count() }} Oportunidades
            </span>
        </div>
        <div class="col text-end text-muted small align-self-center">
            Lead criado {{ $lead->created_at->diffForHumans() }}
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Informações do Lead</h3></div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-5 text-muted">E-mail</dt>
                        <dd class="col-7">{{ $lead->email ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Telefone</dt>
                        <dd class="col-7">{{ $lead->telefone_formatado ?: '—' }}</dd>
                        <dt class="col-5 text-muted">Empresa</dt>
                        <dd class="col-7">{{ $lead->empresa ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Cargo</dt>
                        <dd class="col-7">{{ $lead->cargo ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Status</dt>
                        <dd class="col-7">
                            <span class="badge bg-{{ $lead->status_color }}-lt text-{{ $lead->status_color }}">{{ $lead->status_label }}</span>
                        </dd>
                        <dt class="col-5 text-muted">Origem</dt>
                        <dd class="col-7">{{ $lead->origem_label }}</dd>
                        <dt class="col-5 text-muted">Valor Estimado</dt>
                        <dd class="col-7">{{ $lead->valor_estimado ? 'R$ ' . number_format($lead->valor_estimado, 2, ',', '.') : '—' }}</dd>
                        <dt class="col-5 text-muted">Responsável</dt>
                        <dd class="col-7">{{ $lead->user->name ?? 'Não atribuído' }}</dd>
                        <dt class="col-5 text-muted">Unidade</dt>
                        <dd class="col-7">{{ $lead->clinic->name ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Data de Contato</dt>
                        <dd class="col-7">{{ $lead->data_contato?->format('d/m/Y') ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Cadastrado em</dt>
                        <dd class="col-7">{{ $lead->created_at->format('d/m/Y H:i') }}</dd>
                        <dt class="col-5 text-muted">Atualizado em</dt>
                        <dd class="col-7">{{ $lead->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                    @if($lead->observacoes)
                    <hr>
                    <div class="text-muted mb-1 fw-semibold small">Observações</div>
                    <p class="mb-0">{{ $lead->observacoes }}</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 class="card-title">Ações Rápidas</h3></div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('crm.oportunidades.create') }}?lead_id={{ $lead->id }}"
                       class="list-group-item list-group-item-action">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-2" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                        </svg>
                        Nova Oportunidade
                    </a>
                    <a href="{{ route('crm.tarefas.create') }}?taskable_type={{ urlencode(\App\Models\Lead::class) }}&taskable_id={{ $lead->id }}"
                       class="list-group-item list-group-item-action">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-2" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                        </svg>
                        Nova Tarefa
                    </a>
                    <a href="{{ route('crm.leads.edit', $lead) }}"
                       class="list-group-item list-group-item-action">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-2" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                            <path d="M16 5l3 3"/>
                        </svg>
                        Editar Lead
                    </a>
                    @if(! $lead->crm_client_id && $lead->status !== 'convertido')
                    <form method="POST" action="{{ route('crm.leads.converter', $lead) }}">
                        @csrf
                        <button type="submit"
                                class="list-group-item list-group-item-action text-success"
                                onclick="return confirm('Converter este lead em cliente?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-2" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l5 5l10 -10"/>
                            </svg>
                            Converter em Cliente
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Oportunidades</h3>
                    <div class="card-options">
                        <a href="{{ route('crm.oportunidades.create') }}?lead_id={{ $lead->id }}" class="btn btn-sm btn-primary">+ Nova</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead><tr><th>Título</th><th>Estágio</th><th>Probabilidade</th><th>Valor</th></tr></thead>
                        <tbody>
                            @forelse($lead->opportunities as $opp)
                            <tr>
                                <td><a href="{{ route('crm.oportunidades.show', $opp) }}">{{ $opp->titulo }}</a></td>
                                <td><span class="badge bg-{{ $opp->estagio_color }}-lt text-{{ $opp->estagio_color }}">{{ $opp->estagio_label }}</span></td>
                                <td class="text-muted">{{ $opp->probabilidade !== null ? $opp->probabilidade . '%' : '—' }}</td>
                                <td class="text-muted">{{ $opp->valor ? 'R$ ' . number_format($opp->valor, 2, ',', '.') : '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Nenhuma oportunidade.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tarefas</h3>
                    <div class="card-options">
                        <a href="{{ route('crm.tarefas.create') }}?taskable_type={{ urlencode(\App\Models\Lead::class) }}&taskable_id={{ $lead->id }}" class="btn btn-sm btn-primary">+ Nova</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead><tr><th>Título</th><th>Tipo</th><th>Status</th><th>Vencimento</th></tr></thead>
                        <tbody>
                            @forelse($lead->tasks as $task)
                            <tr class="{{ $task->is_atrasada ? 'table-danger' : '' }}">
                                <td><a href="{{ route('crm.tarefas.show', $task) }}">{{ $task->titulo }}</a></td>
                                <td class="text-muted">{{ $task->tipo_label }}</td>
                                <td><span class="badge bg-{{ $task->status_color }}-lt text-{{ $task->status_color }}">{{ $task->status_label }}</span></td>
                                <td class="text-muted">{{ $task->data_vencimento?->format('d/m/Y H:i') ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Nenhuma tarefa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
