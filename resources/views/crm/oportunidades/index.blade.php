<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Oportunidades</h2>
            <p class="text-muted mt-1">Gestão do pipeline de vendas.</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.oportunidades.kanban') }}" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="4" width="6" height="16" rx="1"/><rect x="14" y="4" width="6" height="10" rx="1"/>
                </svg>
                Kanban
            </a>
            <a href="{{ route('crm.oportunidades.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Nova Oportunidade
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
            <form method="GET" action="{{ route('crm.oportunidades.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <select name="estagio" class="form-select form-select-sm">
                        <option value="">Todos os estágios</option>
                        @foreach(['prospeccao','qualificacao','proposta','negociacao','fechamento','ganho','perdido'] as $e)
                        <option value="{{ $e }}" {{ request('estagio') === $e ? 'selected' : '' }}>
                            {{ ['prospeccao'=>'Prospecção','qualificacao'=>'Qualificação','proposta'=>'Proposta','negociacao'=>'Negociação','fechamento'=>'Fechamento','ganho'=>'Ganho','perdido'=>'Perdido'][$e] ?? $e }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">Todos os responsáveis</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control form-control-sm" placeholder="Buscar título…">
                </div>
                <div class="col-auto d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-secondary">Filtrar</button>
                    @if(request()->hasAny(['estagio','user_id','search']))
                    <a href="{{ route('crm.oportunidades.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body border-bottom py-2">
            <div class="text-secondary">
                Exibindo <strong>{{ $opportunities->count() }}</strong> de <strong>{{ $opportunities->total() }}</strong> registros
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Contato</th>
                        <th>Estágio</th>
                        <th>Probabilidade</th>
                        <th>Valor</th>
                        <th>Previsão</th>
                        <th>Responsável</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opportunities as $opp)
                    <tr>
                        <td>
                            <a href="{{ route('crm.oportunidades.show', $opp) }}" class="fw-semibold text-reset">
                                {{ $opp->titulo }}
                            </a>
                        </td>
                        <td class="text-muted">{{ $opp->contact_name }}</td>
                        <td>
                            <span class="badge bg-{{ $opp->estagio_color }}-lt text-{{ $opp->estagio_color }}">
                                {{ $opp->estagio_label }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px;">
                                    <div class="progress-bar bg-{{ $opp->estagio_color }}" style="width:{{ $opp->probabilidade }}%"></div>
                                </div>
                                <span class="text-muted small">{{ $opp->probabilidade }}%</span>
                            </div>
                        </td>
                        <td class="text-muted text-nowrap">
                            {{ $opp->valor ? 'R$ ' . number_format($opp->valor, 2, ',', '.') : '—' }}
                        </td>
                        <td class="text-muted">
                            {{ $opp->data_fechamento_previsto?->format('d/m/Y') ?? '—' }}
                        </td>
                        <td class="text-muted">{{ $opp->user->name ?? '—' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('crm.oportunidades.show', $opp) }}" class="btn btn-sm btn-ghost-secondary" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/></svg>
                                </a>
                                <a href="{{ route('crm.oportunidades.edit', $opp) }}" class="btn btn-sm btn-ghost-secondary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                                </a>
                                <form method="POST" action="{{ route('crm.oportunidades.destroy', $opp) }}"
                                      onsubmit="return confirm('Remover oportunidade?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Nenhuma oportunidade encontrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($opportunities->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $opportunities->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
