<x-public-layout>

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="text-center mb-4">
                <h2>Ficha de Anamnese</h2>
                <p class="text-muted">Paciente: <strong>{{ $anamnese->patient->name }}</strong></p>
            </div>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <form method="POST" action="{{ route('anamnese.public.submit', $anamnese->token) }}">
                @csrf

                {{-- 1 — Dados da Consulta --}}
                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Dados da Consulta</h3></div>
                    <div class="card-body row g-3">
                        <div class="col-12">
                            <label class="form-label">Queixa Principal</label>
                            <textarea name="chief_complaint" class="form-control" rows="3">{{ old('chief_complaint', $anamnese->chief_complaint) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">História Atual</label>
                            <textarea name="current_history" class="form-control" rows="2">{{ old('current_history', $anamnese->current_history) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Objetivo do Tratamento</label>
                            <textarea name="treatment_objective" class="form-control" rows="2">{{ old('treatment_objective', $anamnese->treatment_objective) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- 2 — Histórico Odontológico --}}
                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Histórico Odontológico</h3></div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Última Visita ao Dentista</label>
                            <input type="text" name="last_dental_visit" class="form-control" value="{{ old('last_dental_visit', $anamnese->last_dental_visit) }}" placeholder="Ex: Há 6 meses">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Frequência de Escovação</label>
                            <select name="brushing_frequency" class="form-select" data-no-select2>
                                <option value="">Selecione</option>
                                @foreach(['1x ao dia','2x ao dia','3x ao dia','Mais de 3x ao dia'] as $f)
                                <option value="{{ $f }}" @selected(old('brushing_frequency', $anamnese->brushing_frequency)===$f)>{{ $f }}</option>
                                @endforeach
                            </select>
                        </div>
                        @php
                        $booleanFields = [
                            'uses_dental_floss' => 'Usa fio dental?',
                            'gum_bleeding' => 'Sangramento gengival?',
                            'tooth_sensitivity' => 'Sensibilidade dentária?',
                            'bruxism' => 'Bruxismo / Apertamento?',
                            'tmj_pain' => 'Dor na ATM?',
                        ];
                        @endphp
                        @foreach($booleanFields as $field => $label)
                        <div class="col-md-4 col-6">
                            <label class="form-label">{{ $label }}</label>
                            <div class="d-flex gap-3">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="{{ $field }}" value="1" @checked(old($field, $anamnese->$field)==='1' || old($field, $anamnese->$field)===1 || old($field, $anamnese->$field)===true)>
                                    <span class="form-check-label">Sim</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="{{ $field }}" value="0" @checked(old($field, $anamnese->$field)==='0' || old($field, $anamnese->$field)===0 || old($field, $anamnese->$field)===false)>
                                    <span class="form-check-label">Não</span>
                                </label>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-12">
                            <label class="form-label">Tratamentos Odontológicos Anteriores</label>
                            <textarea name="dental_treatments_history" class="form-control" rows="2">{{ old('dental_treatments_history', $anamnese->dental_treatments_history) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- 3 — Antecedentes Médicos --}}
                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Antecedentes Médicos</h3></div>
                    <div class="card-body row g-3">
                        <div class="col-12">
                            <label class="form-label d-block">Possui alguma das condições abaixo?</label>
                            @php
                            $conditions = [
                                'has_diabetes' => 'Diabetes', 'has_hypertension' => 'Hipertensão',
                                'has_heart_disease' => 'Cardiopatia', 'has_blood_disorders' => 'Distúrbios de Coagulação',
                                'has_hepatitis' => 'Hepatite', 'has_hiv' => 'HIV/AIDS',
                            ];
                            @endphp
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($conditions as $field => $label)
                                <label class="form-check">
                                    <input type="hidden" name="{{ $field }}" value="0">
                                    <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1" @checked(old($field, $anamnese->$field))>
                                    <span class="form-check-label">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Outras Doenças Crônicas</label>
                            <textarea name="chronic_diseases" class="form-control" rows="2">{{ old('chronic_diseases', $anamnese->chronic_diseases) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Antecedentes Pessoais</label>
                            <textarea name="personal_history" class="form-control" rows="2">{{ old('personal_history', $anamnese->personal_history) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Antecedentes Familiares</label>
                            <textarea name="family_history" class="form-control" rows="2">{{ old('family_history', $anamnese->family_history) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cirurgias Prévias</label>
                            <textarea name="previous_surgeries" class="form-control" rows="2">{{ old('previous_surgeries', $anamnese->previous_surgeries) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Medicamentos em Uso</label>
                            <textarea name="current_medications" class="form-control" rows="2">{{ old('current_medications', $anamnese->current_medications) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Alergias</label>
                            <textarea name="allergies" class="form-control" rows="2">{{ old('allergies', $anamnese->allergies) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label d-block">Alergias Específicas Odontológicas</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach(['anesthetic_allergy' => 'Anestésicos', 'latex_allergy' => 'Látex', 'penicillin_allergy' => 'Penicilina'] as $field => $label)
                                <label class="form-check">
                                    <input type="hidden" name="{{ $field }}" value="0">
                                    <input class="form-check-input" type="checkbox" name="{{ $field }}" value="1" @checked(old($field, $anamnese->$field))>
                                    <span class="form-check-label">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4 — Hábitos --}}
                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Hábitos de Vida</h3></div>
                    <div class="card-body row g-3">
                        @foreach(['smoker' => ['Fumante?','smoker_details','Detalhes (tempo, frequência)'], 'alcohol' => ['Bebidas Alcoólicas?','alcohol_details','Detalhes (frequência)'], 'exercises' => ['Pratica Exercícios?','exercise_details','Detalhes (tipo, frequência)']] as $field => [$label, $detailField, $placeholder])
                        <div class="col-md-4 col-6">
                            <label class="form-label">{{ $label }}</label>
                            <div class="d-flex gap-3">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="{{ $field }}" value="1" @checked(old($field, $anamnese->$field))>
                                    <span class="form-check-label">Sim</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="{{ $field }}" value="0" @checked(old($field, $anamnese->$field)===false || old($field, $anamnese->$field)==='0' || old($field, $anamnese->$field)===0)>
                                    <span class="form-check-label">Não</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8 col-6">
                            <label class="form-label">{{ $placeholder }}</label>
                            <input type="text" name="{{ $detailField }}" class="form-control" value="{{ old($detailField, $anamnese->$detailField) }}">
                        </div>
                        @endforeach
                        <div class="col-md-4">
                            <label class="form-label">Qualidade do Sono</label>
                            <select name="sleep_quality" class="form-select" data-no-select2>
                                <option value="">Selecione</option>
                                @foreach(['Boa','Regular','Ruim','Insônia'] as $v)
                                <option value="{{ $v }}" @selected(old('sleep_quality', $anamnese->sleep_quality)===$v)>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Alimentação</label>
                            <select name="diet" class="form-select" data-no-select2>
                                <option value="">Selecione</option>
                                @foreach(['Equilibrada','Rica em açúcar','Rica em carboidratos','Vegetariana','Vegana','Outra'] as $v)
                                <option value="{{ $v }}" @selected(old('diet', $anamnese->diet)===$v)>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Ingestão de Água</label>
                            <input type="text" name="water_intake" class="form-control" value="{{ old('water_intake', $anamnese->water_intake) }}" placeholder="Ex: 2 litros/dia">
                        </div>
                    </div>
                </div>

                {{-- 5 — Informações Ginecológicas --}}
                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Informações Ginecológicas</h3></div>
                    <div class="card-body row g-3">
                        <div class="col-12 text-muted small mb-1">Preencha somente se aplicável.</div>
                        <div class="col-md-6">
                            <label class="form-label">Ciclo Menstrual</label>
                            <input type="text" name="menstrual_cycle" class="form-control" value="{{ old('menstrual_cycle', $anamnese->menstrual_cycle) }}" placeholder="Regular / Irregular / Menopausa">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gestações</label>
                            <input type="text" name="pregnancies" class="form-control" value="{{ old('pregnancies', $anamnese->pregnancies) }}" placeholder="Nenhuma / Quantidade">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gestante?</label>
                            <div class="d-flex gap-3">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pregnant" value="1" @checked(old('pregnant', $anamnese->pregnant))>
                                    <span class="form-check-label">Sim</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pregnant" value="0" @checked(old('pregnant', $anamnese->pregnant)===false || old('pregnant', $anamnese->pregnant)==='0')>
                                    <span class="form-check-label">Não</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lactante?</label>
                            <div class="d-flex gap-3">
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="breastfeeding" value="1" @checked(old('breastfeeding', $anamnese->breastfeeding))>
                                    <span class="form-check-label">Sim</span>
                                </label>
                                <label class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="breastfeeding" value="0" @checked(old('breastfeeding', $anamnese->breastfeeding)===false || old('breastfeeding', $anamnese->breastfeeding)==='0')>
                                    <span class="form-check-label">Não</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 6 — Observações --}}
                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Observações</h3></div>
                    <div class="card-body">
                        <textarea name="observations" class="form-control" rows="3">{{ old('observations', $anamnese->observations) }}</textarea>
                    </div>
                </div>

                {{-- 7 — Assinatura --}}
                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Assinatura do Paciente</h3></div>
                    <div class="card-body">
                        <p class="text-muted small mb-2">Assine abaixo usando o dedo ou mouse. Se preferir, você pode assinar depois pelo link de assinatura.</p>
                        <div style="border:1px solid #e6e7e9;border-radius:4px;max-width:500px">
                            <canvas id="signaturePad" width="500" height="200"></canvas>
                        </div>
                        <button type="button" class="btn btn-ghost-secondary btn-sm mt-2" id="clearSignature">Limpar Assinatura</button>
                        <input type="hidden" name="signature_data" id="signatureData">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-lg">Enviar Anamnese</button>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var canvas = document.getElementById('signaturePad');
    var pad = new SignaturePad(canvas, { backgroundColor: 'rgb(255,255,255)' });

    document.getElementById('clearSignature').addEventListener('click', function () {
        pad.clear();
    });

    canvas.closest('form').addEventListener('submit', function () {
        if (!pad.isEmpty()) {
            document.getElementById('signatureData').value = pad.toDataURL();
        }
    });

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        var wrapper = canvas.parentElement;
        var data = pad.toData();
        canvas.width = wrapper.offsetWidth * ratio;
        canvas.height = 200 * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        canvas.style.width = wrapper.offsetWidth + 'px';
        canvas.style.height = '200px';
        pad.clear();
        pad.fromData(data);
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
});
</script>
@endpush
</x-public-layout>
