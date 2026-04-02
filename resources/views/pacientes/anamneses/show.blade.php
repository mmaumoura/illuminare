<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Ficha de Anamnese</h2>
            <div class="text-muted">
                Paciente: <strong>{{ $paciente->name }}</strong> |
                Data: {{ $anamnese->anamnesis_date->format('d/m/Y') }} |
                Status: <span class="badge bg-{{ $anamnese->status === 'completa' ? 'success' : ($anamnese->status === 'pendente_assinatura' ? 'warning' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $anamnese->status)) }}</span>
            </div>
        </div>
        <div class="col-auto d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-outline-cyan" onclick="copyLink('{{ route('anamnese.public.fill', $anamnese->token) }}')">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6-6"/><path d="M11 6l.463-.536a5 5 0 017.071 7.072l-.534.463"/><path d="M13 18l-.397.534a5.068 5.068 0 01-7.127 0a4.972 4.972 0 010-7.071l.524-.463"/></svg>
                Link Preenchimento
            </button>
            <button type="button" class="btn btn-outline-orange" onclick="copyLink('{{ route('anamnese.assinatura', $anamnese->signature_token) }}')">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17c3.333 -3.333 5 -6 5 -8c0 -3 -1 -3 -2 -3s-2.032 1.085 -2 3c.034 2.048 1.658 4.877 2.5 6c1.5 2 2.5 2.5 3.5 1l2 -3c.333 2.667 1.333 4 3 4"/></svg>
                Link Assinatura
            </button>
            <a href="{{ route('operacional.pacientes.show', $paciente) }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div id="copy-toast" class="position-fixed top-0 end-0 p-3" style="z-index:9999;display:none">
        <div class="alert alert-success mb-0">Link copiado!</div>
    </div>

    {{-- Dados da Consulta --}}
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Dados da Consulta</h3></div>
        <div class="card-body p-0">
            <table class="table table-sm table-borderless mb-0">
                <tbody>
                    <tr><td class="text-muted ps-3" style="width:30%">Data</td><td>{{ $anamnese->anamnesis_date->format('d/m/Y') }}</td></tr>
                    <tr><td class="text-muted ps-3">Preenchida por</td><td>{{ $anamnese->filled_by === 'paciente' ? 'Paciente' : ($anamnese->professional?->name ?? 'Profissional') }}</td></tr>
                    @if($anamnese->chief_complaint)<tr><td class="text-muted ps-3">Queixa Principal</td><td>{{ $anamnese->chief_complaint }}</td></tr>@endif
                    @if($anamnese->current_history)<tr><td class="text-muted ps-3">História Atual</td><td>{{ $anamnese->current_history }}</td></tr>@endif
                    @if($anamnese->treatment_objective)<tr><td class="text-muted ps-3">Objetivo do Tratamento</td><td>{{ $anamnese->treatment_objective }}</td></tr>@endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Histórico Odontológico --}}
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Histórico Odontológico</h3></div>
        <div class="card-body p-0">
            <table class="table table-sm table-borderless mb-0">
                <tbody>
                    @if($anamnese->last_dental_visit)<tr><td class="text-muted ps-3" style="width:30%">Última Visita</td><td>{{ $anamnese->last_dental_visit }}</td></tr>@endif
                    @if($anamnese->brushing_frequency)<tr><td class="text-muted ps-3">Frequência de Escovação</td><td>{{ $anamnese->brushing_frequency }}</td></tr>@endif
                    <tr><td class="text-muted ps-3">Fio Dental</td><td>{!! $anamnese->uses_dental_floss ? '<span class="badge bg-green">Sim</span>' : '<span class="badge bg-red">Não</span>' !!}</td></tr>
                    <tr><td class="text-muted ps-3">Sangramento Gengival</td><td>{!! $anamnese->gum_bleeding ? '<span class="badge bg-red">Sim</span>' : '<span class="badge bg-green">Não</span>' !!}</td></tr>
                    <tr><td class="text-muted ps-3">Sensibilidade</td><td>{!! $anamnese->tooth_sensitivity ? '<span class="badge bg-orange">Sim</span>' : '<span class="badge bg-green">Não</span>' !!}</td></tr>
                    <tr><td class="text-muted ps-3">Bruxismo</td><td>{!! $anamnese->bruxism ? '<span class="badge bg-orange">Sim</span>' : '<span class="badge bg-green">Não</span>' !!}</td></tr>
                    <tr><td class="text-muted ps-3">Dor na ATM</td><td>{!! $anamnese->tmj_pain ? '<span class="badge bg-red">Sim</span>' : '<span class="badge bg-green">Não</span>' !!}</td></tr>
                    @if($anamnese->dental_treatments_history)<tr><td class="text-muted ps-3">Tratamentos Anteriores</td><td>{{ $anamnese->dental_treatments_history }}</td></tr>@endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Antecedentes Médicos --}}
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Antecedentes Médicos</h3></div>
        <div class="card-body">
            @php
                $conditions = collect([
                    'has_diabetes' => 'Diabetes', 'has_hypertension' => 'Hipertensão',
                    'has_heart_disease' => 'Cardiopatia', 'has_blood_disorders' => 'Distúrbios de Coagulação',
                    'has_hepatitis' => 'Hepatite', 'has_hiv' => 'HIV/AIDS',
                ])->filter(fn($label, $field) => $anamnese->$field);
                $dentalAllergies = collect([
                    'anesthetic_allergy' => 'Anestésicos', 'latex_allergy' => 'Látex', 'penicillin_allergy' => 'Penicilina',
                ])->filter(fn($label, $field) => $anamnese->$field);
            @endphp
            @if($conditions->count())
            <div class="mb-3">
                <strong class="text-muted">Condições Médicas:</strong>
                @foreach($conditions as $label)
                    <span class="badge bg-red-lt me-1">{{ $label }}</span>
                @endforeach
            </div>
            @endif
            @if($dentalAllergies->count())
            <div class="mb-3">
                <strong class="text-muted">Alergias Odontológicas:</strong>
                @foreach($dentalAllergies as $label)
                    <span class="badge bg-orange-lt me-1">{{ $label }}</span>
                @endforeach
            </div>
            @endif
            <table class="table table-sm table-borderless mb-0">
                <tbody>
                    @if($anamnese->chronic_diseases)<tr><td class="text-muted" style="width:30%">Outras Condições</td><td>{{ $anamnese->chronic_diseases }}</td></tr>@endif
                    @if($anamnese->personal_history)<tr><td class="text-muted">Antecedentes Pessoais</td><td>{{ $anamnese->personal_history }}</td></tr>@endif
                    @if($anamnese->family_history)<tr><td class="text-muted">Antecedentes Familiares</td><td>{{ $anamnese->family_history }}</td></tr>@endif
                    @if($anamnese->previous_surgeries)<tr><td class="text-muted">Cirurgias Prévias</td><td>{{ $anamnese->previous_surgeries }}</td></tr>@endif
                    @if($anamnese->current_medications)<tr><td class="text-muted">Medicamentos em Uso</td><td>{{ $anamnese->current_medications }}</td></tr>@endif
                    @if($anamnese->allergies)<tr><td class="text-muted">Alergias</td><td>{{ $anamnese->allergies }}</td></tr>@endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Hábitos --}}
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Hábitos de Vida</h3></div>
        <div class="card-body p-0">
            <table class="table table-sm table-borderless mb-0">
                <tbody>
                    <tr><td class="text-muted ps-3" style="width:30%">Tabagismo</td><td>{{ $anamnese->smoker ? 'Sim' . ($anamnese->smoker_details ? " — {$anamnese->smoker_details}" : '') : 'Não' }}</td></tr>
                    <tr><td class="text-muted ps-3">Álcool</td><td>{{ $anamnese->alcohol ? 'Sim' . ($anamnese->alcohol_details ? " — {$anamnese->alcohol_details}" : '') : 'Não' }}</td></tr>
                    <tr><td class="text-muted ps-3">Exercícios</td><td>{{ $anamnese->exercises ? 'Sim' . ($anamnese->exercise_details ? " — {$anamnese->exercise_details}" : '') : 'Não' }}</td></tr>
                    @if($anamnese->sleep_quality)<tr><td class="text-muted ps-3">Sono</td><td>{{ $anamnese->sleep_quality }}</td></tr>@endif
                    @if($anamnese->diet)<tr><td class="text-muted ps-3">Alimentação</td><td>{{ $anamnese->diet }}</td></tr>@endif
                    @if($anamnese->water_intake)<tr><td class="text-muted ps-3">Água</td><td>{{ $anamnese->water_intake }}</td></tr>@endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Avaliação Bucal --}}
    @if($anamnese->oral_hygiene_level || $anamnese->periodontal_status || $anamnese->soft_tissue_exam || $anamnese->hard_tissue_exam || $anamnese->occlusion)
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Avaliação Bucal</h3></div>
        <div class="card-body p-0">
            <table class="table table-sm table-borderless mb-0">
                <tbody>
                    @if($anamnese->oral_hygiene_level)<tr><td class="text-muted ps-3" style="width:30%">Higiene Bucal</td><td>{{ $anamnese->oral_hygiene_level }}</td></tr>@endif
                    @if($anamnese->periodontal_status)<tr><td class="text-muted ps-3">Estado Periodontal</td><td>{{ $anamnese->periodontal_status }}</td></tr>@endif
                    @if($anamnese->soft_tissue_exam)<tr><td class="text-muted ps-3">Tecidos Moles</td><td>{{ $anamnese->soft_tissue_exam }}</td></tr>@endif
                    @if($anamnese->hard_tissue_exam)<tr><td class="text-muted ps-3">Tecidos Duros</td><td>{{ $anamnese->hard_tissue_exam }}</td></tr>@endif
                    @if($anamnese->occlusion)<tr><td class="text-muted ps-3">Oclusão</td><td>{{ $anamnese->occlusion }}</td></tr>@endif
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Observações --}}
    @if($anamnese->observations)
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Observações</h3></div>
        <div class="card-body">{{ $anamnese->observations }}</div>
    </div>
    @endif

    {{-- Assinatura --}}
    <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Assinatura</h3></div>
        <div class="card-body">
            @if($anamnese->signature_data)
                <img src="{{ $anamnese->signature_data }}" alt="Assinatura" style="max-width:400px;border:1px solid #e6e7e9;border-radius:4px">
                <div class="text-muted mt-1 small">Assinado em: {{ $anamnese->signed_at?->format('d/m/Y H:i') }}</div>
            @else
                <div class="text-muted">Assinatura pendente.
                    <a href="{{ route('anamnese.assinatura', $anamnese->signature_token) }}" target="_blank">Enviar link de assinatura</a>
                </div>
            @endif
        </div>
    </div>

@push('scripts')
<script>
function copyLink(url) {
    navigator.clipboard.writeText(url).then(function () {
        var t = document.getElementById('copy-toast');
        t.style.display = 'block';
        setTimeout(function () { t.style.display = 'none'; }, 2000);
    });
}
</script>
@endpush
</x-app-layout>
