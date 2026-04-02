<x-app-layout>

    <div class="row mb-3">
        <div class="col">
            <h2 class="page-title">Treinamentos</h2>
            <p class="text-muted">Capacitação e desenvolvimento da equipe.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Treinamento
            </button>
        </div>
    </div>

    {{-- STATS --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Total Treinamentos</div>
                    <div class="h1 mb-0">{{ count($treinamentos) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Em Andamento</div>
                    <div class="h1 mb-0">{{ count(array_filter($treinamentos, fn($t) => $t['status'] === 'Em Andamento')) }}</div>
                    <div class="text-muted small">ativos</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Total Inscritos</div>
                    <div class="h1 mb-0">{{ array_sum(array_column($treinamentos, 'inscritos')) }}</div>
                    <div class="text-muted small">colaboradores</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Taxa de Conclusão</div>
                    <div class="h1 mb-0">
                        {{ round((array_sum(array_column($treinamentos, 'concluidos')) / array_sum(array_column($treinamentos, 'inscritos'))) * 100) }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach($treinamentos as $treinamento)
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-fill">
                            @php
                                $catColor = match($treinamento['categoria']) {
                                    'Técnico' => 'blue',
                                    'Atendimento' => 'cyan',
                                    'Segurança' => 'orange',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $catColor }}-lt mb-2">{{ $treinamento['categoria'] }}</span>
                            
                            @if($treinamento['obrigatorio'])
                            <span class="badge bg-danger-lt mb-2">Obrigatório</span>
                            @endif
                            
                            <h3 class="card-title">{{ $treinamento['titulo'] }}</h3>
                        </div>
                        
                        <div>
                            @php
                                $statusColor = match($treinamento['status']) {
                                    'Em Andamento' => 'success',
                                    'Agendado' => 'info',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }}-lt">{{ $treinamento['status'] }}</span>
                        </div>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="text-muted small">Duração</div>
                            <div class="fw-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="12" r="9"/>
                                    <polyline points="12 7 12 12 15 15"/>
                                </svg>
                                {{ $treinamento['duracao'] }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small">Inscritos</div>
                            <div class="fw-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                                </svg>
                                {{ $treinamento['inscritos'] }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Progresso</span>
                            <span class="text-muted small">
                                {{ $treinamento['concluidos'] }} de {{ $treinamento['inscritos'] }} concluíram
                            </span>
                        </div>
                        <div class="progress">
                            @php
                                $progress = round(($treinamento['concluidos'] / $treinamento['inscritos']) * 100);
                            @endphp
                            <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-primary flex-fill">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="12" r="2"/>
                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                            </svg>
                            Ver Detalhes
                        </button>
                        <button class="btn btn-sm btn-ghost-secondary" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                            </svg>
                        </button>
                        <button class="btn btn-sm btn-ghost-danger" title="Excluir">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="4" y1="7" x2="20" y2="7"/>
                                <line x1="10" y1="11" x2="10" y2="17"/>
                                <line x1="14" y1="11" x2="14" y2="17"/>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</x-app-layout>
