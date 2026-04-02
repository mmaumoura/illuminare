<x-app-layout>

    @php
        $statusColor = $procedure->status === 'Ativo' ? 'success' : 'secondary';
    @endphp

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $procedure->name }}</h2>
            <p class="mt-1 mb-0 d-flex flex-wrap align-items-center gap-2">
                <span class="badge bg-blue-lt text-blue">{{ $procedure->category }}</span>
                <span class="badge bg-{{ $statusColor }}-lt text-{{ $statusColor }}">{{ $procedure->status }}</span>
                <span class="text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/>
                    </svg>
                    {{ $procedure->duration_label }}
                </span>
                <span class="text-muted">•</span>
                <span class="text-muted fw-semibold">R$ {{ number_format($procedure->price, 2, ',', '.') }}</span>
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('gestao.procedimentos.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
            <a href="{{ route('gestao.procedimentos.edit', $procedure) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                </svg>
                Editar
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

        {{-- COLUNA PRINCIPAL --}}
        <div class="col-lg-8">

            {{-- Dados Básicos --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Dados Básicos</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted">Nome</dt>
                        <dd class="col-7">{{ $procedure->name }}</dd>

                        <dt class="col-5 text-muted">Categoria</dt>
                        <dd class="col-7">{{ $procedure->category }}</dd>

                        <dt class="col-5 text-muted">Preço</dt>
                        <dd class="col-7">R$ {{ number_format($procedure->price, 2, ',', '.') }}</dd>

                        @if($procedure->commission !== null)
                        <dt class="col-5 text-muted">Comissão</dt>
                        <dd class="col-7">{{ number_format($procedure->commission, 2, ',', '.') }}%</dd>
                        @endif

                        <dt class="col-5 text-muted">Duração</dt>
                        <dd class="col-7">{{ $procedure->duration_label }}</dd>

                        @if($procedure->sessions_recommended)
                        <dt class="col-5 text-muted">Sessões Recomendadas</dt>
                        <dd class="col-7">{{ $procedure->sessions_recommended }}</dd>
                        @endif

                        @if($procedure->sessions_interval_days !== null)
                        <dt class="col-5 text-muted">Intervalo entre Sessões</dt>
                        <dd class="col-7">{{ $procedure->sessions_interval_days }} dias</dd>
                        @endif

                        <dt class="col-5 text-muted">Status</dt>
                        <dd class="col-7">
                            <span class="badge bg-{{ $statusColor }}-lt text-{{ $statusColor }}">{{ $procedure->status }}</span>
                        </dd>

                        <dt class="col-5 text-muted">Unidade(s)</dt>
                        <dd class="col-7">
                            @if($procedure->clinics->isEmpty())
                                <span class="text-muted">—</span>
                            @else
                                {{ $procedure->clinics->pluck('name')->join(', ') }}
                            @endif
                        </dd>
                    </dl>
                    @if($procedure->description)
                    <div class="mt-3 pt-3 border-top">
                        <span class="text-muted small d-block mb-1">Descrição</span>
                        <p class="mb-0" style="white-space:pre-line">{{ $procedure->description }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Informações Técnicas --}}
            @if($procedure->indications || $procedure->contraindications || $procedure->products_used || $procedure->equipment_needed)
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Informações Técnicas</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @if($procedure->indications)
                        <div class="col-md-6">
                            <div class="card bg-green-lt border-0">
                                <div class="card-body py-3">
                                    <h5 class="text-green mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/>
                                        </svg>
                                        Indicações
                                    </h5>
                                    <p class="mb-0 text-body" style="white-space:pre-line">{{ $procedure->indications }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($procedure->contraindications)
                        <div class="col-md-6">
                            <div class="card bg-red-lt border-0">
                                <div class="card-body py-3">
                                    <h5 class="text-danger mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12"/><path d="M6 6l12 12"/>
                                        </svg>
                                        Contraindicações
                                    </h5>
                                    <p class="mb-0 text-body" style="white-space:pre-line">{{ $procedure->contraindications }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($procedure->products_used)
                        <div class="col-md-6">
                            <h5 class="text-muted">Produtos Utilizados</h5>
                            <p class="mb-0" style="white-space:pre-line">{{ $procedure->products_used }}</p>
                        </div>
                        @endif
                        @if($procedure->equipment_needed)
                        <div class="col-md-6">
                            <h5 class="text-muted">Equipamentos Necessários</h5>
                            <p class="mb-0" style="white-space:pre-line">{{ $procedure->equipment_needed }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Cuidados --}}
            @if($procedure->pre_care || $procedure->post_care)
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Cuidados</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @if($procedure->pre_care)
                        <div class="col-md-6">
                            <h5 class="text-muted">Pré-Procedimento</h5>
                            <p class="mb-0" style="white-space:pre-line">{{ $procedure->pre_care }}</p>
                        </div>
                        @endif
                        @if($procedure->post_care)
                        <div class="col-md-6">
                            <h5 class="text-muted">Pós-Procedimento</h5>
                            <p class="mb-0" style="white-space:pre-line">{{ $procedure->post_care }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Custos do Procedimento --}}
            @if($procedure->costs->isNotEmpty())
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Custos do Procedimento</h3>
                    @php $totalCost = $procedure->costs->sum('value'); @endphp
                    <span class="ms-auto text-muted small">Total: <strong>R$ {{ number_format($totalCost, 2, ',', '.') }}</strong></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm card-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th class="text-end">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procedure->costs as $cost)
                            <tr>
                                <td>{{ $cost->name }}</td>
                                <td class="text-end">R$ {{ number_format($cost->value, 2, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th>Total</th>
                                <th class="text-end">R$ {{ number_format($totalCost, 2, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">

            {{-- Informações Adicionais --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Informações Adicionais</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-6 text-muted">Cadastrado em</dt>
                        <dd class="col-6">{{ $procedure->created_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-6 text-muted">Última atualização</dt>
                        <dd class="col-6">{{ $procedure->updated_at->format('d/m/Y H:i') }}</dd>
                    </dl>
                </div>
            </div>

            {{-- Unidades --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Unidades</h3>
                    <span class="badge bg-blue ms-auto">{{ $procedure->clinics->count() }}</span>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($procedure->clinics as $clinic)
                    <div class="list-group-item">
                        <div class="d-flex align-items-center gap-2">
                            <span class="avatar avatar-xs rounded bg-blue-lt text-blue">
                                {{ strtoupper(substr($clinic->name, 0, 1)) }}
                            </span>
                            <div>
                                <div class="fw-semibold">{{ $clinic->name }}</div>
                                @if($clinic->city)
                                <div class="text-muted small">{{ $clinic->city }}{{ $clinic->state ? '/'.$clinic->state : '' }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-muted text-center small py-3">
                        Nenhuma unidade vinculada.
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Ações Rápidas --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ações Rápidas</h3>
                </div>
                <div class="card-body d-flex flex-column gap-2">
                    <a href="{{ route('gestao.procedimentos.edit', $procedure) }}" class="btn btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                        </svg>
                        Editar Procedimento
                    </a>
                    <form method="POST" action="{{ route('gestao.procedimentos.destroy', $procedure) }}"
                          onsubmit="return confirm('Tem certeza que deseja excluir este procedimento?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Excluir Procedimento
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>