<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Metas de Venda</h2>
            <p class="text-muted mt-1">Acompanhamento de metas com monitoramento diário.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('comercial.metas.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Nova Meta
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
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control" placeholder="Buscar por título...">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Todos os status</option>
                        <option value="ativa"     {{ request('status') === 'ativa'     ? 'selected' : '' }}>Ativa</option>
                        <option value="concluida" {{ request('status') === 'concluida' ? 'selected' : '' }}>Concluída</option>
                        <option value="cancelada" {{ request('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>
                <div class="col-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    @if(request('search') || request('status'))
                    <a href="{{ route('comercial.metas.index') }}" class="btn btn-outline-secondary">Limpar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @forelse($goals as $goal)
    @php
        $goal->loadMissing('entries');
    @endphp
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-start">
                <div class="col">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <h4 class="mb-0">
                            <a href="{{ route('comercial.metas.show', $goal) }}" class="text-reset">
                                {{ $goal->titulo }}
                            </a>
                        </h4>
                        <span class="badge bg-{{ $goal->status_color }}-lt text-{{ $goal->status_color }}">
                            {{ $goal->status_label }}
                        </span>
                        <span class="badge bg-blue-lt text-blue">{{ $goal->tipo_label }}</span>
                    </div>
                    <div class="text-muted small mb-3">
                        {{ $goal->periodo_inicio->format('d/m/Y') }} → {{ $goal->periodo_fim->format('d/m/Y') }}
                        @if($goal->clinic) · {{ $goal->clinic->name }} @endif
                        @if($goal->responsavel) · {{ $goal->responsavel->name }} @endif
                    </div>

                    <div class="row g-3">
                        @if($goal->meta_valor)
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Faturamento</span>
                                <span>
                                    R$ {{ number_format($goal->valor_realizado, 2, ',', '.') }}
                                    / R$ {{ number_format($goal->meta_valor, 2, ',', '.') }}
                                </span>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-{{ $goal->progresso_valor >= 100 ? 'success' : ($goal->progresso_valor >= 50 ? 'warning' : 'primary') }}"
                                     style="width:{{ $goal->progresso_valor }}%"></div>
                            </div>
                            <div class="text-end small text-muted mt-1">{{ $goal->progresso_valor }}%</div>
                        </div>
                        @endif

                        @if($goal->meta_procedimentos)
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Procedimentos</span>
                                <span>{{ $goal->procedimentos_realizados }} / {{ $goal->meta_procedimentos }}</span>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-{{ $goal->progresso_procedimentos >= 100 ? 'success' : ($goal->progresso_procedimentos >= 50 ? 'warning' : 'primary') }}"
                                     style="width:{{ $goal->progresso_procedimentos }}%"></div>
                            </div>
                            <div class="text-end small text-muted mt-1">{{ $goal->progresso_procedimentos }}%</div>
                        </div>
                        @endif

                        @if($goal->meta_pacientes_novos)
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Pacientes Novos</span>
                                <span>{{ $goal->pacientes_novos_realizados }} / {{ $goal->meta_pacientes_novos }}</span>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-{{ $goal->progresso_pacientes >= 100 ? 'success' : ($goal->progresso_pacientes >= 50 ? 'warning' : 'primary') }}"
                                     style="width:{{ $goal->progresso_pacientes }}%"></div>
                            </div>
                            <div class="text-end small text-muted mt-1">{{ $goal->progresso_pacientes }}%</div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-auto d-flex gap-1">
                    <a href="{{ route('comercial.metas.show', $goal) }}"
                       class="btn btn-sm btn-ghost-secondary" title="Ver detalhes">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2"/>
                            <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('comercial.metas.edit', $goal) }}"
                       class="btn btn-sm btn-ghost-secondary" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                            <path d="M16 5l3 3"/>
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('comercial.metas.destroy', $goal) }}"
                          onsubmit="return confirm('Excluir esta meta?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-ghost-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/>
                                <path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <h3>Nenhuma meta cadastrada</h3>
            <a href="{{ route('comercial.metas.create') }}" class="btn btn-primary mt-2">Cadastrar Primeira Meta</a>
        </div>
    </div>
    @endforelse

    {{ $goals->links() }}

</x-app-layout>
