<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Leads</h2>
            <p class="text-muted mt-1">Gestão de leads comerciais.</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.leads.kanban') }}" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="4" width="6" height="16" rx="1"/><rect x="14" y="4" width="6" height="10" rx="1"/>
                </svg>
                Kanban
            </a>
            <a href="{{ route('crm.leads.funnel') }}" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-9l-4.414 -4.414a2 2 0 0 1 -.586 -1.414v-2.172z"/>
                </svg>
                Funil
            </a>
            <a href="{{ route('crm.leads.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Lead
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
            <form method="GET" action="{{ route('crm.leads.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3 col-6">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Todos os status</option>
                        <option value="novo"        {{ request('status') === 'novo'        ? 'selected' : '' }}>Novo</option>
                        <option value="contatado"   {{ request('status') === 'contatado'   ? 'selected' : '' }}>Contatado</option>
                        <option value="qualificado" {{ request('status') === 'qualificado' ? 'selected' : '' }}>Qualificado</option>
                        <option value="convertido"  {{ request('status') === 'convertido'  ? 'selected' : '' }}>Convertido</option>
                        <option value="perdido"     {{ request('status') === 'perdido'     ? 'selected' : '' }}>Perdido</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select name="origem" class="form-select form-select-sm">
                        <option value="">Todas as origens</option>
                        <option value="site"          {{ request('origem') === 'site'          ? 'selected' : '' }}>Site</option>
                        <option value="indicacao"     {{ request('origem') === 'indicacao'     ? 'selected' : '' }}>Indicação</option>
                        <option value="redes_sociais" {{ request('origem') === 'redes_sociais' ? 'selected' : '' }}>Redes Sociais</option>
                        <option value="evento"        {{ request('origem') === 'evento'        ? 'selected' : '' }}>Evento</option>
                        <option value="ligacao"       {{ request('origem') === 'ligacao'       ? 'selected' : '' }}>Ligação</option>
                        <option value="email"         {{ request('origem') === 'email'         ? 'selected' : '' }}>E-mail</option>
                        <option value="outro"         {{ request('origem') === 'outro'         ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">Todos os responsáveis</option>
                        @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control form-control-sm" placeholder="Buscar nome, e-mail ou empresa…">
                </div>
                <div class="col-auto d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-secondary">Filtrar</button>
                    @if(request()->hasAny(['status','origem','user_id','search']))
                    <a href="{{ route('crm.leads.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body border-bottom py-2">
            <div class="text-secondary">
                Exibindo <strong>{{ $leads->count() }}</strong> de <strong>{{ $leads->total() }}</strong> registros
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Empresa / Cargo</th>
                        <th>Status</th>
                        <th>Origem</th>
                        <th>Responsável</th>
                        <th>Valor Estimado</th>
                        <th>Tarefas</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td>
                            <a href="{{ route('crm.leads.show', $lead) }}" class="fw-semibold text-reset">
                                {{ $lead->nome_completo }}
                            </a>
                            @if($lead->email)
                            <div class="text-muted small">{{ $lead->email }}</div>
                            @endif
                        </td>
                        <td class="text-muted">
                            {{ $lead->empresa ?? '—' }}
                            @if($lead->cargo)
                            <div class="small text-muted">{{ $lead->cargo }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $lead->status_color }}-lt text-{{ $lead->status_color }}">
                                {{ $lead->status_label }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $lead->origem_label }}</td>
                        <td class="text-muted">{{ $lead->user->name ?? '—' }}</td>
                        <td class="text-muted text-nowrap">
                            {{ $lead->valor_estimado ? 'R$ ' . number_format($lead->valor_estimado, 2, ',', '.') : '—' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-blue-lt text-blue">{{ $lead->tasks_count }}</span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('crm.leads.show', $lead) }}" class="btn btn-sm btn-ghost-secondary" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                    </svg>
                                </a>
                                <a href="{{ route('crm.leads.edit', $lead) }}" class="btn btn-sm btn-ghost-secondary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                        <path d="M16 5l3 3"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('crm.leads.destroy', $lead) }}"
                                      onsubmit="return confirm('Remover este lead?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <line x1="4" y1="7" x2="20" y2="7"/><line x1="10" y1="11" x2="10" y2="17"/>
                                            <line x1="14" y1="11" x2="14" y2="17"/>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Nenhum lead encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($leads->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $leads->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
