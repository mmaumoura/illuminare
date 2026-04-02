<x-app-layout>
    <x-slot name="header">Ficha do Paciente</x-slot>

    {{-- Breadcrumb / toolbar --}}
    <div class="d-flex align-items-center mb-3 gap-2">
        <a href="{{ route('operacional.pacientes.index') }}" class="btn btn-outline-secondary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 6l-6 6l6 6"/>
            </svg>
            Voltar
        </a>
        <a href="{{ route('operacional.pacientes.edit', $patient) }}" class="btn btn-primary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
            </svg>
            Editar
        </a>
    </div>

    <div class="row g-3">

        {{-- ── COLUNA PRINCIPAL ─────────────────────────────────── --}}
        <div class="col-12 col-lg-8">

            {{-- Header card --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        {{-- Avatar com iniciais --}}
                        <span class="avatar avatar-lg rounded-circle text-white fs-3"
                              style="background-color: var(--tblr-primary);">
                            {{ mb_strtoupper(mb_substr($patient->name, 0, 1)) }}
                        </span>
                        <div>
                            <h2 class="mb-0">{{ $patient->name }}</h2>
                            <div class="mt-1 d-flex flex-wrap gap-2 align-items-center text-muted">
                                @if($patient->cpf)
                                    <span>CPF: {{ $patient->cpf }}</span>
                                    <span class="text-muted">·</span>
                                @endif
                                @if($patient->birth_date)
                                    <span>{{ $patient->birth_date->format('d/m/Y') }} ({{ $patient->birth_date->diffInYears(now()) }} anos)</span>
                                    <span class="text-muted">·</span>
                                @endif
                                @if($patient->clinic)
                                    <span class="badge text-white" style="background-color: var(--tblr-primary);">
                                        {{ $patient->clinic->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contadores de documentos --}}
            <div class="row g-2 mb-3">
                @foreach([
                    ['label' => 'Documentos',    'count' => 0, 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 0 1 -2 -2V5a2 2 0 0 1 2 -2h5.586a1 1 0 0 1 .707 .293l5.414 5.414a1 1 0 0 1 .293 .707V19a2 2 0 0 1 -2 2z'],
                    ['label' => 'Anamneses',     'count' => 0, 'icon' => 'M9 5H7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2V7a2 2 0 0 0 -2 -2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2M9 5a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2m-6 9l2 2l4 -4'],
                    ['label' => 'Prontuários',   'count' => 0, 'icon' => 'M19 11H5m14 0a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2H5a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2m14 0V9a2 2 0 0 0 -2 -2M5 11V9a2 2 0 0 1 2 -2m0 0V5a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v2M7 7h10'],
                    ['label' => 'Fotos',         'count' => 0, 'icon' => 'M15 8h.01M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3H6a3 3 0 0 1 -3 -3V6zM3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3'],
                    ['label' => 'Termos',        'count' => 0, 'icon' => 'M12 21l-8 -4.5v-9l8 -4.5l8 4.5v4.5M16 18h6M19 15v6'],
                ] as $item)
                <div class="col-6 col-md-4 col-lg">
                    <div class="card card-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="bg-primary-lt text-primary avatar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path d="{{ $item['icon'] }}"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col">
                                    <div class="font-weight-medium">{{ $item['count'] }}</div>
                                    <div class="text-muted">{{ $item['label'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Dados Pessoais --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-primary" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="7" r="4"/>
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                        </svg>
                        Dados Pessoais
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">Nome completo</label>
                            <div class="fw-medium">{{ $patient->name }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">CPF</label>
                            <div class="fw-medium">{{ $patient->cpf ?? '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">Data de nascimento</label>
                            <div class="fw-medium">
                                @if($patient->birth_date)
                                    {{ $patient->birth_date->format('d/m/Y') }}
                                    <span class="text-muted">({{ $patient->birth_date->diffInYears(now()) }} anos)</span>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">Unidade</label>
                            <div class="fw-medium">
                                @if($patient->clinic)
                                    <span class="badge text-white" style="background-color: var(--tblr-primary);">
                                        {{ $patient->clinic->name }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">Telefone</label>
                            <div class="fw-medium">{{ $patient->phone ?? '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">E-mail</label>
                            <div class="fw-medium">{{ $patient->email ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Endereço --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-primary" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
                            <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"/>
                        </svg>
                        Endereço
                    </h3>
                </div>
                <div class="card-body">
                    @if($patient->street || $patient->cep)
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label text-muted mb-0">CEP</label>
                            <div class="fw-medium">{{ $patient->cep ?? '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">Logradouro</label>
                            <div class="fw-medium">
                                {{ $patient->street ?? '—' }}
                                @if($patient->number), {{ $patient->number }}@endif
                            </div>
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label text-muted mb-0">Complemento</label>
                            <div class="fw-medium">{{ $patient->complement ?? '—' }}</div>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label text-muted mb-0">Bairro</label>
                            <div class="fw-medium">{{ $patient->neighborhood ?? '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">Cidade</label>
                            <div class="fw-medium">{{ $patient->city ?? '—' }}</div>
                        </div>
                        <div class="col-12 col-md-2">
                            <label class="form-label text-muted mb-0">UF</label>
                            <div class="fw-medium">{{ $patient->state ?? '—' }}</div>
                        </div>
                    </div>
                    @else
                        <p class="text-muted mb-0">Endereço não cadastrado.</p>
                    @endif
                </div>
            </div>

            {{-- Informações Médicas --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-primary" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 6v6m0 0v6m0 -6h6m-6 0h-6" opacity=".3"/>
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M10 9v6m4 -6v6m-7 -3h10"/>
                        </svg>
                        Informações Médicas
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-muted mb-1">Histórico médico</label>
                            <p class="mb-0">{{ $patient->medical_history ?: '—' }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-1">Alergias</label>
                            <p class="mb-0">{{ $patient->allergies ?: '—' }}</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-1">Medicamentos em uso</label>
                            <p class="mb-0">{{ $patient->current_medications ?: '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contato de Emergência --}}
            @if($patient->emergency_contact_name || $patient->emergency_contact_phone)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-danger" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2A16 16 0 0 1 3 6a2 2 0 0 1 2 -2"/>
                            <path d="M15 7a2 2 0 0 1 2 2"/><path d="M15 3a6 6 0 0 1 6 6"/>
                        </svg>
                        Contato de Emergência
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">Nome</label>
                            <div class="fw-medium">{{ $patient->emergency_contact_name ?? '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label text-muted mb-0">Telefone</label>
                            <div class="fw-medium">{{ $patient->emergency_contact_phone ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- ── SIDEBAR ──────────────────────────────────────────── --}}
        <div class="col-12 col-lg-4">

            {{-- Informações do registro --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Informações</h3>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col text-muted">Cadastrado em</div>
                            <div class="col-auto">{{ $patient->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col text-muted">Última atualização</div>
                            <div class="col-auto">{{ $patient->updated_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @if($patient->clinic)
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col text-muted">Unidade</div>
                            <div class="col-auto">{{ $patient->clinic->name }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Ações rápidas --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ações</h3>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('operacional.pacientes.edit', $patient) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                        </svg>
                        Editar Paciente
                    </a>
                    <form method="POST"
                          action="{{ route('operacional.pacientes.destroy', $patient) }}"
                          onsubmit="return confirm('Tem certeza que deseja excluir este paciente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12M9 7V4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Excluir
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
