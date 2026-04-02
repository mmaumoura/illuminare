<x-app-layout>

    <div class="row mb-3">
        <div class="col">
            <h2 class="page-title">Banco de Imagens</h2>
            <p class="text-muted">Organize e gerencie imagens de procedimentos.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1"/>
                    <polyline points="9 15 12 12 15 15"/>
                    <line x1="12" y1="12" x2="12" y2="21"/>
                </svg>
                Upload Imagem
            </button>
        </div>
    </div>

    {{-- STATS --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Total de Imagens</div>
                    <div class="h1 mb-0">{{ count($imagens) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Antes e Depois</div>
                    <div class="h1 mb-0">{{ count(array_filter($imagens, fn($i) => $i['categoria'] === 'Antes e Depois')) }}</div>
                    <div class="text-muted small">imagens</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Este Mês</div>
                    <div class="h1 mb-0">2</div>
                    <div class="text-muted small">adicionadas</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Categorias</div>
                    <div class="h1 mb-0">3</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach($imagens as $imagem)
        <div class="col-md-4">
            <div class="card">
                <div class="img-responsive img-responsive-16x9 card-img-top" 
                     style="background-image: url(https://via.placeholder.com/400x300/667eea/ffffff?text={{ urlencode($imagem['titulo']) }})"></div>
                <div class="card-body">
                    @php
                        $catColor = match($imagem['categoria']) {
                            'Antes e Depois' => 'purple',
                            'Procedimento' => 'blue',
                            'Resultado' => 'success',
                            default => 'secondary',
                        };
                    @endphp
                    <span class="badge bg-{{ $catColor }}-lt mb-2">{{ $imagem['categoria'] }}</span>
                    
                    <h3 class="card-title mb-2">{{ $imagem['titulo'] }}</h3>
                    
                    <div class="small text-muted mb-2">
                        <div class="mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="7" r="4"/>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                            </svg>
                            <strong>Paciente:</strong> {{ $imagem['paciente'] }}
                        </div>
                        <div class="mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 12h1m8 -9v1m8 8h1m-15.4 -6.4l.7 .7m12.1 -.7l-.7 .7"/>
                                <path d="M9 16a5 5 0 1 1 6 0a3.5 3.5 0 0 0 -1 3a2 2 0 0 1 -4 0a3.5 3.5 0 0 0 -1 -3"/>
                            </svg>
                            <strong>Proc:</strong> {{ $imagem['procedimento'] }}
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <rect x="4" y="5" width="16" height="16" rx="2"/>
                                <path d="M16 3l0 4"/><path d="M8 3l0 4"/><path d="M4 11l16 0"/>
                            </svg>
                            {{ $imagem['data'] }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        @foreach(explode(',', $imagem['tags']) as $tag)
                        <span class="badge bg-secondary-lt">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-ghost-secondary flex-fill" title="Visualizar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="12" cy="12" r="2"/>
                                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                            </svg>
                        </button>
                        <button class="btn btn-sm btn-ghost-secondary flex-fill" title="Download">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                                <polyline points="7 11 12 16 17 11"/>
                                <line x1="12" y1="4" x2="12" y2="16"/>
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
