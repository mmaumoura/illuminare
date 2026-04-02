<x-app-layout>

    @php
        $statusColor = $appointment->status_color;
        $typeColor   = $appointment->type_color;
    @endphp

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $appointment->title }}</h2>
            <p class="mt-1 mb-0 d-flex flex-wrap align-items-center gap-2">
                <span class="badge bg-{{ $typeColor }}-lt text-{{ $typeColor }}">{{ $appointment->type }}</span>
                <span class="badge bg-{{ $statusColor }}-lt text-{{ $statusColor }}">{{ $appointment->status }}</span>
                <span class="text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/>
                    </svg>
                    {{ $appointment->starts_at->format('d/m/Y H:i') }}
                </span>
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('operacional.agenda.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
            <a href="{{ route('operacional.agenda.edit', $appointment) }}" class="btn btn-primary">
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

        {{-- Coluna principal --}}
        <div class="col-lg-8">

            {{-- Detalhes do Agendamento --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Detalhes do Agendamento</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted">Tipo</dt>
                        <dd class="col-7">
                            <span class="badge bg-{{ $typeColor }}-lt text-{{ $typeColor }}">{{ $appointment->type }}</span>
                        </dd>

                        <dt class="col-5 text-muted">Status</dt>
                        <dd class="col-7">
                            <span class="badge bg-{{ $statusColor }}-lt text-{{ $statusColor }}">{{ $appointment->status }}</span>
                        </dd>

                        <dt class="col-5 text-muted">Procedimento(s)</dt>
                        <dd class="col-7">
                            @if($appointment->procedures->isNotEmpty())
                                {{ $appointment->procedures->pluck('name')->join(', ') }}
                            @else
                                <span class="text-muted">Nenhum procedimento vinculado</span>
                            @endif
                        </dd>

                        <dt class="col-5 text-muted">Data/Hora Início</dt>
                        <dd class="col-7">{{ $appointment->starts_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-5 text-muted">Data/Hora Fim</dt>
                        <dd class="col-7">{{ $appointment->ends_at->format('d/m/Y H:i') }}</dd>

                        <dt class="col-5 text-muted">Duração</dt>
                        <dd class="col-7">{{ $appointment->duration_label }}</dd>

                    </dl>

                    @if($appointment->description)
                    <div class="mt-3 pt-3 border-top">
                        <span class="text-muted small d-block mb-1">Descrição</span>
                        <p class="mb-0" style="white-space:pre-line">{{ $appointment->description }}</p>
                    </div>
                    @endif

                    @if($appointment->observations)
                    <div class="mt-3 pt-3 border-top">
                        <span class="text-muted small d-block mb-1">Observações</span>
                        <p class="mb-0" style="white-space:pre-line">{{ $appointment->observations }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Paciente --}}
            @if($appointment->patient)
            <div class="card mb-3">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-blue" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                    </svg>
                    <h3 class="card-title">Paciente</h3>
                    <a href="{{ route('operacional.pacientes.show', $appointment->patient) }}" class="ms-auto btn btn-sm btn-ghost-secondary">
                        Ver ficha
                    </a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <span class="avatar avatar-md rounded bg-blue-lt text-blue">
                            {{ strtoupper(substr($appointment->patient->name, 0, 1)) }}
                        </span>
                        <div>
                            <div class="fw-semibold fs-4">{{ $appointment->patient->name }}</div>
                            @if($appointment->patient->email)
                            <div class="text-muted small d-flex align-items-center gap-1 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"/>
                                    <path d="M3 7l9 6l9 -6"/>
                                </svg>
                                {{ $appointment->patient->email }}
                            </div>
                            @endif
                            @if($appointment->patient->phone)
                            <div class="text-muted small d-flex align-items-center gap-1 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"/>
                                </svg>
                                {{ $appointment->patient->phone }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Profissional --}}
            @if($appointment->professional)
            <div class="card mb-3">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-green" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="12" cy="7" r="4"/>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                    </svg>
                    <h3 class="card-title">Profissional</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <span class="avatar avatar-sm rounded bg-green-lt text-green">
                            {{ strtoupper(substr($appointment->professional->name, 0, 1)) }}
                        </span>
                        <div>
                            <div class="fw-semibold">{{ $appointment->professional->name }}</div>
                            @if($appointment->professional->email)
                            <div class="text-muted small">{{ $appointment->professional->email }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Unidade --}}
            @if($appointment->clinic)
            <div class="card mb-3">
                <div class="card-header">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-azure" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 21l18 0"/><path d="M5 21v-14l8 -4v18"/>
                        <path d="M19 21v-10l-6 -4"/><path d="M9 9l0 .01"/><path d="M9 12l0 .01"/><path d="M9 15l0 .01"/><path d="M9 18l0 .01"/>
                    </svg>
                    <h3 class="card-title">Unidade</h3>
                </div>
                <div class="card-body">
                    <div class="fw-semibold">{{ $appointment->clinic->name }}</div>
                    @if($appointment->clinic->city)
                    <div class="text-muted small">{{ $appointment->clinic->city }}{{ $appointment->clinic->state ? '/'.$appointment->clinic->state : '' }}</div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Acoes Rapidas --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ações Rápidas</h3>
                </div>
                <div class="card-body d-flex flex-column gap-2">
                    <a href="{{ route('operacional.agenda.edit', $appointment) }}" class="btn btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                        </svg>
                        Editar Agendamento
                    </a>
                    <form method="POST" action="{{ route('operacional.agenda.destroy', $appointment) }}"
                          onsubmit="return confirm('Remover este agendamento?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Remover Agendamento
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
