<x-app-layout>

    <div class="row mb-3">
        <div class="col">
            <h2 class="page-title">Universidade Corporativa</h2>
            <p class="text-muted">Cursos e desenvolvimento profissional contínuo.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Curso
            </button>
        </div>
    </div>

    {{-- STATS --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Total de Cursos</div>
                    <div class="h1 mb-0">{{ count($cursos) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Total de Alunos</div>
                    <div class="h1 mb-0">{{ array_sum(array_column($cursos, 'alunos')) }}</div>
                    <div class="text-muted small">matriculados</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Módulos Disponíveis</div>
                    <div class="h1 mb-0">{{ array_sum(array_column($cursos, 'modulos')) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Avaliação Média</div>
                    <div class="h1 mb-0">{{ round(array_sum(array_column($cursos, 'avaliacoes')) / count($cursos), 1) }}</div>
                    <div class="text-muted small">⭐ estrelas</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach($cursos as $curso)
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-fill">
                            @php
                                $statusColor = match($curso['status']) {
                                    'Ativo' => 'success',
                                    'Em Breve' => 'info',
                                    default => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }}-lt mb-2">{{ $curso['status'] }}</span>
                            
                            <h3 class="card-title mb-1">{{ $curso['titulo'] }}</h3>
                            <div class="text-muted small mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="7" r="4"/>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                </svg>
                                {{ $curso['instrutor'] }}
                            </div>
                        </div>
                        
                        <div class="ms-auto">
                            <div class="text-end">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($curso['avaliacoes']))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-warning" width="24" height="24"
                                             viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm text-muted" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <div class="small text-muted">{{ number_format($curso['avaliacoes'], 1) }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <div class="text-muted small">Duração</div>
                            <div class="fw-semibold small">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="12" r="9"/>
                                    <polyline points="12 7 12 12 15 15"/>
                                </svg>
                                {{ $curso['duracao'] }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Módulos</div>
                            <div class="fw-semibold small">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                                    <path d="M12 12l8 -4.5"/>
                                    <path d="M12 12l0 9"/>
                                    <path d="M12 12l-8 -4.5"/>
                                </svg>
                                {{ $curso['modulos'] }}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small">Alunos</div>
                            <div class="fw-semibold small">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                                </svg>
                                {{ $curso['alunos'] }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="text-muted small">Progresso Médio</span>
                            <span class="text-muted small">{{ $curso['progresso'] }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: {{ $curso['progresso'] }}%"></div>
                        </div>
                    </div>
                    
                    <div class="mt-auto">
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-primary flex-fill">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M10 12l0 .01"/>
                                    <path d="M14 12l0 .01"/>
                                    <path d="M10 16a3.5 3.5 0 0 0 4 0"/>
                                </svg>
                                Acessar Curso
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
                            <button class="btn btn-sm btn-ghost-secondary" title="Relatório">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"/>
                                    <path d="M12 7v5l3 3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</x-app-layout>
