<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Prontuário — {{ $prontuario->record_date->format('d/m/Y') }}</h2>
            <div class="text-muted">
                Paciente: <strong>{{ $paciente->name }}</strong> |
                Profissional: {{ $prontuario->professional?->name ?? '—' }}
            </div>
        </div>
        <div class="col-auto d-flex gap-2">
            <form method="POST" action="{{ route('operacional.pacientes.prontuarios.destroy', [$paciente, $prontuario]) }}" onsubmit="return confirm('Excluir este prontuário?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">Excluir</button>
            </form>
            <a href="{{ route('operacional.pacientes.show', $paciente) }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Dados do Atendimento --}}
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Dados do Atendimento</h3></div>
        <div class="card-body p-0">
            <table class="table table-sm table-borderless mb-0">
                <tbody>
                    <tr><td class="text-muted ps-3" style="width:30%">Data</td><td>{{ $prontuario->record_date->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted ps-3">Horário</td><td>{{ $prontuario->start_time }} @if($prontuario->end_time)— {{ $prontuario->end_time }}@endif</td></tr>
                    <tr><td class="text-muted ps-3">Profissional</td><td>{{ $prontuario->professional?->name ?? '—' }}</td></tr>
                    @if($prontuario->procedure)<tr><td class="text-muted ps-3">Procedimento</td><td>{{ $prontuario->procedure->name }}</td></tr>@endif
                    @if($prontuario->tooth_region)<tr><td class="text-muted ps-3">Dente / Região</td><td>{{ $prontuario->tooth_region }}</td></tr>@endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Evolução Clínica --}}
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Evolução Clínica</h3></div>
        <div class="card-body">
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Evolução / Descrição</strong>
                <div style="white-space:pre-line">{{ $prontuario->evolution }}</div>
            </div>
            @if($prontuario->diagnosis)
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Diagnóstico</strong>
                <div style="white-space:pre-line">{{ $prontuario->diagnosis }}</div>
            </div>
            @endif
            @if($prontuario->treatment)
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Tratamento Realizado</strong>
                <div style="white-space:pre-line">{{ $prontuario->treatment }}</div>
            </div>
            @endif
            @if($prontuario->materials)
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Materiais Utilizados</strong>
                <div style="white-space:pre-line">{{ $prontuario->materials }}</div>
            </div>
            @endif
            @if($prontuario->prescription)
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Prescrição</strong>
                <div style="white-space:pre-line">{{ $prontuario->prescription }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Orientações e Planejamento --}}
    @if($prontuario->guidelines || $prontuario->treatment_plan || $prontuario->next_session || $prontuario->observations)
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Orientações e Planejamento</h3></div>
        <div class="card-body">
            @if($prontuario->guidelines)
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Orientações ao Paciente</strong>
                <div style="white-space:pre-line">{{ $prontuario->guidelines }}</div>
            </div>
            @endif
            @if($prontuario->treatment_plan)
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Plano de Tratamento</strong>
                <div style="white-space:pre-line">{{ $prontuario->treatment_plan }}</div>
            </div>
            @endif
            @if($prontuario->next_session)
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Próxima Sessão</strong>
                {{ $prontuario->next_session->format('d/m/Y') }}
            </div>
            @endif
            @if($prontuario->observations)
            <div class="mb-3">
                <strong class="text-muted d-block mb-1">Observações</strong>
                <div style="white-space:pre-line">{{ $prontuario->observations }}</div>
            </div>
            @endif
        </div>
    </div>
    @endif

</x-app-layout>
