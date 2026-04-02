<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Agenda</h2>
            <p class="text-muted mt-1">Gerencie todos os agendamentos</p>
        </div>
        <div class="col-auto d-flex gap-2">
            {{-- Alternancia lista / calendario --}}
            <div class="btn-group" id="view-toggle">
                <button type="button" class="btn btn-outline-secondary active" id="btn-list-view" title="Lista">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M9 6l11 0"/><path d="M9 12l11 0"/><path d="M9 18l11 0"/>
                        <path d="M5 6l0 .01"/><path d="M5 12l0 .01"/><path d="M5 18l0 .01"/>
                    </svg>
                    Lista
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btn-calendar-view" title="Calendario">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"/>
                        <path d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11l16 0"/>
                        <path d="M11 15h1"/><path d="M12 15v3"/>
                    </svg>
                    Calendario
                </button>
            </div>
            <a href="{{ route('operacional.agenda.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Agendamento
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- VISAO LISTA --}}
    <div id="view-list">

        {{-- Filtros --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('operacional.agenda.index') }}" id="form-filters">
                    <div class="row g-2 align-items-end">
                        <div class="col-sm-6 col-md-2">
                            <label class="form-label mb-1 small text-muted">Tipo</label>
                            <select name="tipo" class="form-select form-select-sm" data-no-select2
                                    onchange="this.form.submit()">
                                <option value="">Todos</option>
                                @foreach(['Agendamento de Paciente','Agendamento Interno','Bloqueio de Agenda'] as $t)
                                <option value="{{ $t }}" {{ request('tipo') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <label class="form-label mb-1 small text-muted">Status</label>
                            <select name="status" class="form-select form-select-sm" data-no-select2
                                    onchange="this.form.submit()">
                                <option value="">Todos</option>
                                @foreach(['Agendado','Confirmado','Realizado','Cancelado','Falta'] as $s)
                                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <label class="form-label mb-1 small text-muted">Procedimento</label>
                            <select name="procedimento_id" class="form-select form-select-sm" data-no-select2
                                    onchange="this.form.submit()">
                                <option value="">Todos</option>
                                @foreach($procedures as $proc)
                                <option value="{{ $proc->id }}" {{ request('procedimento_id') == $proc->id ? 'selected' : '' }}>
                                    {{ $proc->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-2">
                            <label class="form-label mb-1 small text-muted">Profissional</label>
                            <select name="profissional_id" class="form-select form-select-sm" data-no-select2
                                    onchange="this.form.submit()">
                                <option value="">Todos</option>
                                @foreach($professionals as $pro)
                                <option value="{{ $pro->id }}" {{ request('profissional_id') == $pro->id ? 'selected' : '' }}>
                                    {{ $pro->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-6 col-md-2">
                            <label class="form-label mb-1 small text-muted">Data</label>
                            <div class="d-flex gap-1">
                                <input type="text" name="data" value="{{ request('data') }}"
                                       class="form-control form-control-sm"
                                       placeholder="dd/mm/aaaa" id="filter-date">
                                @if(request()->hasAny(['tipo','status','procedimento_id','profissional_id','data']))
                                <a href="{{ route('operacional.agenda.index') }}" class="btn btn-sm btn-ghost-secondary" title="Limpar">&times;</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabela --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Data/Hora</th>
                            <th>Tipo</th>
                            <th>Titulo</th>
                            <th>Cliente</th>
                            <th>Procedimento</th>
                            <th>Profissional</th>
                            <th>Unidade</th>
                            <th>Status</th>
                            <th class="w-1">Acoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appt)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $appt->starts_at->format('d/m/Y') }}</div>
                                <div class="text-muted small">
                                    {{ $appt->starts_at->format('H:i') }} &ndash; {{ $appt->ends_at->format('H:i') }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $appt->type_color }}-lt text-{{ $appt->type_color }} text-nowrap">
                                    @if($appt->type === 'Agendamento de Paciente') Paciente
                                    @elseif($appt->type === 'Agendamento Interno') Interno
                                    @else Bloqueio
                                    @endif
                                </span>
                            </td>
                            <td class="fw-semibold">{{ $appt->title }}</td>
                            <td>
                                @if($appt->patient)
                                    {{ $appt->patient->name }}
                                @else
                                    <span class="text-muted">&mdash;</span>
                                @endif
                            </td>
                            <td>
                                @if($appt->procedures->isNotEmpty())
                                    {{ $appt->procedures->pluck('name')->join(', ') }}
                                @else
                                    <span class="text-muted">&mdash;</span>
                                @endif
                            </td>
                            <td>{{ $appt->professional?->name ?? '&mdash;' }}</td>
                            <td class="text-muted small">{{ $appt->clinic?->name ?? '&mdash;' }}</td>
                            <td>
                                <span class="badge bg-{{ $appt->status_color }}-lt text-{{ $appt->status_color }}">
                                    {{ $appt->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('operacional.agenda.show', $appt) }}"
                                       class="btn btn-sm btn-ghost-secondary" title="Ver detalhes">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <circle cx="12" cy="12" r="2"/>
                                            <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('operacional.agenda.edit', $appt) }}"
                                       class="btn btn-sm btn-ghost-secondary" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('operacional.agenda.destroy', $appt) }}"
                                          onsubmit="return confirm('Remover este agendamento?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost-danger" title="Remover">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
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
                            <td colspan="9" class="text-center text-muted py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 d-block mx-auto" width="32" height="32"
                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"/>
                                    <path d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11l16 0"/>
                                    <path d="M11 15h1"/><path d="M12 15v3"/>
                                </svg>
                                Nenhum agendamento encontrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($appointments->hasPages())
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-secondary">
                    Exibindo <strong>{{ $appointments->firstItem() }}&ndash;{{ $appointments->lastItem() }}</strong>
                    de <strong>{{ $appointments->total() }}</strong> registros
                </p>
                <div class="ms-auto">{{ $appointments->links('pagination::bootstrap-5') }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- VISAO CALENDARIO --}}
    <div id="view-calendar" class="d-none">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Calendario de Agendamentos</h3>
            </div>
            <div class="card-body">
                <div id="full-calendar"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales-all.global.min.js"></script>
    <script>
    (function () {
        var inp = document.getElementById('filter-date');
        if (!inp) return;
        inp.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') document.getElementById('form-filters').submit();
        });
    })();

    var calendarInstance = null;
    document.getElementById('btn-list-view').addEventListener('click', function () {
        document.getElementById('view-list').classList.remove('d-none');
        document.getElementById('view-calendar').classList.add('d-none');
        this.classList.add('active');
        document.getElementById('btn-calendar-view').classList.remove('active');
    });
    document.getElementById('btn-calendar-view').addEventListener('click', function () {
        document.getElementById('view-list').classList.add('d-none');
        document.getElementById('view-calendar').classList.remove('d-none');
        this.classList.add('active');
        document.getElementById('btn-list-view').classList.remove('active');
        if (!calendarInstance) {
            calendarInstance = new FullCalendar.Calendar(document.getElementById('full-calendar'), {
                locale: 'pt-br',
                initialView: 'dayGridMonth',
                height: 650,
                headerToolbar: {
                    left:   'prev,next today',
                    center: 'title',
                    right:  'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                },
                events: '{{ route("operacional.agenda.calendar") }}',
                eventClick: function (info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) { window.location.href = info.event.url; }
                },
            });
            calendarInstance.render();
        }
    });
    </script>
    @endpush

</x-app-layout>