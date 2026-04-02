<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Nova Ficha de Anamnese</h2>
            <div class="text-muted">
                Paciente: <strong>{{ $paciente->name }}</strong>
                @if($paciente->birth_date)
                    | Nascimento: {{ $paciente->birth_date->format('d/m/Y') }} ({{ $paciente->birth_date->age }} anos)
                @endif
            </div>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.pacientes.show', $paciente) }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('operacional.pacientes.anamneses.store', $paciente) }}">
        @csrf

        {{-- 1. Dados da Consulta --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11h16"/></svg>
                Dados da Consulta
            </h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label required">Data da Anamnese</label>
                        <input type="date" name="anamnesis_date" class="form-control" value="{{ old('anamnesis_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Queixa Principal</label>
                        <textarea name="chief_complaint" class="form-control" rows="3" placeholder="Qual o motivo da consulta?">{{ old('chief_complaint') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">História Atual</label>
                        <textarea name="current_history" class="form-control" rows="3" placeholder="Descreva a história clínica atual...">{{ old('current_history') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Objetivo do Tratamento</label>
                        <textarea name="treatment_objective" class="form-control" rows="2" placeholder="O que o paciente espera do tratamento?">{{ old('treatment_objective') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Histórico Odontológico --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5.5c-1.5 -1.5 -3 -2 -4.5 -1.5c-2 .5 -3.5 3 -2 6.5c1 2.5 2.5 4.5 3.5 6.5c.5 1 1 2 1.5 3c.5 -1 1 -2 1.5 -3c1 -2 2.5 -4 3.5 -6.5c1.5 -3.5 0 -6 -2 -6.5c-1.5 -.5 -3 0 -4.5 1.5"/></svg>
                Histórico Odontológico
            </h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Última Visita ao Dentista</label>
                        <input type="text" name="last_dental_visit" class="form-control" placeholder="Ex: Há 6 meses" value="{{ old('last_dental_visit') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Frequência de Escovação</label>
                        <select name="brushing_frequency" class="form-select" data-no-select2>
                            <option value="">Selecione...</option>
                            <option value="1x ao dia" {{ old('brushing_frequency') == '1x ao dia' ? 'selected' : '' }}>1x ao dia</option>
                            <option value="2x ao dia" {{ old('brushing_frequency') == '2x ao dia' ? 'selected' : '' }}>2x ao dia</option>
                            <option value="3x ao dia" {{ old('brushing_frequency') == '3x ao dia' ? 'selected' : '' }}>3x ao dia</option>
                            <option value="Após refeições" {{ old('brushing_frequency') == 'Após refeições' ? 'selected' : '' }}>Após cada refeição</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Usa Fio Dental?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="uses_dental_floss" value="1" {{ old('uses_dental_floss') == '1' ? 'checked' : '' }}>
                                <span class="form-check-label">Sim</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="uses_dental_floss" value="0" {{ old('uses_dental_floss') == '0' ? 'checked' : '' }}>
                                <span class="form-check-label">Não</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sangramento Gengival?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="gum_bleeding" value="1" {{ old('gum_bleeding') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="gum_bleeding" value="0" {{ old('gum_bleeding') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sensibilidade Dentária?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="tooth_sensitivity" value="1" {{ old('tooth_sensitivity') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="tooth_sensitivity" value="0" {{ old('tooth_sensitivity') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bruxismo / Apertamento?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="bruxism" value="1" {{ old('bruxism') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="bruxism" value="0" {{ old('bruxism') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Dor na ATM?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="tmj_pain" value="1" {{ old('tmj_pain') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="tmj_pain" value="0" {{ old('tmj_pain') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tratamentos Odontológicos Anteriores</label>
                        <textarea name="dental_treatments_history" class="form-control" rows="2" placeholder="Implantes, ortodontia, próteses, clareamento, etc...">{{ old('dental_treatments_history') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Antecedentes Médicos --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2z"/><path d="M9 12h6"/><path d="M12 9v6"/></svg>
                Antecedentes Médicos
            </h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Condições Médicas</label>
                        <div class="row g-2">
                            @foreach([
                                'has_diabetes' => 'Diabetes',
                                'has_hypertension' => 'Hipertensão',
                                'has_heart_disease' => 'Cardiopatia',
                                'has_blood_disorders' => 'Distúrbios de Coagulação',
                                'has_hepatitis' => 'Hepatite',
                                'has_hiv' => 'HIV/AIDS',
                            ] as $field => $label)
                            <div class="col-md-4 col-lg-2">
                                <label class="form-check">
                                    <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1" {{ old($field) ? 'checked' : '' }}>
                                    <span class="form-check-label">{{ $label }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Outras Doenças / Condições</label>
                        <textarea name="chronic_diseases" class="form-control" rows="2" placeholder="Outras condições médicas relevantes...">{{ old('chronic_diseases') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Antecedentes Pessoais</label>
                        <textarea name="personal_history" class="form-control" rows="2" placeholder="Doenças prévias, internações...">{{ old('personal_history') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Antecedentes Familiares</label>
                        <textarea name="family_history" class="form-control" rows="2" placeholder="Histórico familiar de doenças...">{{ old('family_history') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cirurgias Prévias</label>
                        <textarea name="previous_surgeries" class="form-control" rows="2" placeholder="Cirurgias realizadas anteriormente...">{{ old('previous_surgeries') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Medicamentos em Uso</label>
                        <textarea name="current_medications" class="form-control" rows="2" placeholder="Lista de medicamentos atuais...">{{ old('current_medications') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alergias</label>
                        <textarea name="allergies" class="form-control" rows="2" placeholder="Alergias conhecidas a medicamentos, alimentos, materiais...">{{ old('allergies') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alergias Específicas Odontológicas</label>
                        <div class="d-flex gap-4">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="anesthetic_allergy" value="1" {{ old('anesthetic_allergy') ? 'checked' : '' }}>
                                <span class="form-check-label">Alergia a Anestésicos</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="latex_allergy" value="1" {{ old('latex_allergy') ? 'checked' : '' }}>
                                <span class="form-check-label">Alergia a Látex</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="penicillin_allergy" value="1" {{ old('penicillin_allergy') ? 'checked' : '' }}>
                                <span class="form-check-label">Alergia a Penicilina</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Hábitos de Vida --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 21a9 9 0 1 1 0 -18a9 9 0 0 1 0 18z"/><path d="M12 7v5l3 3"/></svg>
                Hábitos de Vida
            </h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Fuma?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="smoker" value="1" {{ old('smoker') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="smoker" value="0" {{ old('smoker') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Detalhes (quantidade/dia)</label>
                        <input type="text" name="smoker_details" class="form-control" value="{{ old('smoker_details') }}" placeholder="Ex: 10 cigarros/dia">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Consome Álcool?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="alcohol" value="1" {{ old('alcohol') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="alcohol" value="0" {{ old('alcohol') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Frequência</label>
                        <input type="text" name="alcohol_details" class="form-control" value="{{ old('alcohol_details') }}" placeholder="Ex: Socialmente, fins de semana">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Pratica Exercícios?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="exercises" value="1" {{ old('exercises') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="exercises" value="0" {{ old('exercises') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Frequência</label>
                        <input type="text" name="exercise_details" class="form-control" value="{{ old('exercise_details') }}" placeholder="Ex: 3x/semana, caminhada">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Qualidade do Sono</label>
                        <select name="sleep_quality" class="form-select" data-no-select2>
                            <option value="">Selecione...</option>
                            @foreach(['Boa', 'Regular', 'Ruim', 'Insônia'] as $opt)
                            <option value="{{ $opt }}" {{ old('sleep_quality') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alimentação</label>
                        <select name="diet" class="form-select" data-no-select2>
                            <option value="">Selecione...</option>
                            @foreach(['Equilibrada', 'Rica em açúcar', 'Rica em ácidos', 'Vegetariana', 'Vegana'] as $opt)
                            <option value="{{ $opt }}" {{ old('diet') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Ingestão de Água (litros/dia)</label>
                        <input type="text" name="water_intake" class="form-control" value="{{ old('water_intake') }}" placeholder="Ex: 2 litros">
                    </div>
                </div>
            </div>
        </div>

        {{-- 5. Informações Ginecológicas --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9"/><path d="M12 17v-6"/><path d="M12 8h.01"/></svg>
                Informações Ginecológicas (se aplicável)
            </h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Ciclo Menstrual</label>
                        <input type="text" name="menstrual_cycle" class="form-control" value="{{ old('menstrual_cycle') }}" placeholder="Ex: Regular, 28 dias">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Gestações</label>
                        <input type="text" name="pregnancies" class="form-control" value="{{ old('pregnancies') }}" placeholder="Quantidade e informações">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Gestante?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="pregnant" value="1" {{ old('pregnant') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="pregnant" value="0" {{ old('pregnant') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Amamentando?</label>
                        <div class="d-flex gap-3 mt-2">
                            <label class="form-check"><input class="form-check-input" type="radio" name="breastfeeding" value="1" {{ old('breastfeeding') == '1' ? 'checked' : '' }}><span class="form-check-label">Sim</span></label>
                            <label class="form-check"><input class="form-check-input" type="radio" name="breastfeeding" value="0" {{ old('breastfeeding') == '0' ? 'checked' : '' }}><span class="form-check-label">Não</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 6. Avaliação Bucal --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/><path d="M9 14l2 2l4 -4"/></svg>
                Avaliação Bucal (preenchida pelo profissional)
            </h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Higiene Bucal</label>
                        <select name="oral_hygiene_level" class="form-select" data-no-select2>
                            <option value="">Selecione...</option>
                            @foreach(['Boa', 'Regular', 'Deficiente'] as $opt)
                            <option value="{{ $opt }}" {{ old('oral_hygiene_level') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Estado Periodontal</label>
                        <select name="periodontal_status" class="form-select" data-no-select2>
                            <option value="">Selecione...</option>
                            @foreach(['Saudável', 'Gengivite', 'Periodontite Leve', 'Periodontite Moderada', 'Periodontite Severa'] as $opt)
                            <option value="{{ $opt }}" {{ old('periodontal_status') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Oclusão</label>
                        <textarea name="occlusion" class="form-control" rows="1" placeholder="Classe I, II, III, mordida aberta, cruzada...">{{ old('occlusion') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Exame de Tecidos Moles</label>
                        <textarea name="soft_tissue_exam" class="form-control" rows="2" placeholder="Mucosa, língua, palato, assoalho, gengiva...">{{ old('soft_tissue_exam') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Exame de Tecidos Duros</label>
                        <textarea name="hard_tissue_exam" class="form-control" rows="2" placeholder="Cáries, restaurações, próteses, ausências...">{{ old('hard_tissue_exam') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- 7. Observações --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Observações Gerais</h3></div>
            <div class="card-body">
                <textarea name="observations" class="form-control" rows="3" placeholder="Observações adicionais, informações relevantes...">{{ old('observations') }}</textarea>
            </div>
        </div>

        {{-- 8. Assinatura --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Assinatura do Paciente (Opcional)</h3></div>
            <div class="card-body">
                <p class="text-muted">Solicite ao paciente que assine no campo abaixo. Ou deixe em branco para gerar um link de assinatura digital depois.</p>
                <div class="border rounded" style="max-width:500px">
                    <canvas id="signature-pad" width="500" height="200" style="width:100%;height:200px;touch-action:none;"></canvas>
                </div>
                <input type="hidden" name="signature_data" id="signature-data">
                <div class="mt-2">
                    <button type="button" class="btn btn-sm btn-ghost-secondary" id="clear-signature">Limpar assinatura</button>
                </div>
                <div class="alert alert-info mt-3 mb-0">
                    <strong>Dica:</strong> Você pode preencher a anamnese agora e coletar a assinatura depois através de um link enviado ao paciente.
                </div>
            </div>
        </div>

        {{-- Ações --}}
        <div class="d-flex gap-2 justify-content-end mb-3">
            <button type="submit" name="save_draft" value="1" class="btn btn-secondary">
                Salvar como Rascunho
            </button>
            <button type="submit" class="btn btn-primary">
                Salvar Anamnese
            </button>
        </div>
    </form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var canvas = document.getElementById('signature-pad');
    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)'
    });

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        signaturePad.clear();
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    document.getElementById('clear-signature').addEventListener('click', function () {
        signaturePad.clear();
        document.getElementById('signature-data').value = '';
    });

    canvas.closest('form').addEventListener('submit', function () {
        if (!signaturePad.isEmpty()) {
            document.getElementById('signature-data').value = signaturePad.toDataURL();
        }
    });
});
</script>
@endpush
</x-app-layout>
