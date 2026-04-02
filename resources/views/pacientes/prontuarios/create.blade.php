<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Novo Prontuário</h2>
            <div class="text-muted">Paciente: <strong>{{ $paciente->name }}</strong></div>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.pacientes.show', $paciente) }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('operacional.pacientes.prontuarios.store', $paciente) }}">
        @csrf

        {{-- Dados do Atendimento --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Dados do Atendimento</h3></div>
            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label class="form-label required">Data</label>
                    <input type="date" name="record_date" class="form-control" value="{{ old('record_date', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label required">Hora Início</label>
                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time', date('H:i')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Hora Fim</label>
                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Procedimento</label>
                    <select name="procedure_id" class="form-select">
                        <option value="">Selecione (opcional)</option>
                        @foreach($procedures as $proc)
                        <option value="{{ $proc->id }}" @selected(old('procedure_id')==$proc->id)>{{ $proc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Dente / Região</label>
                    <select name="tooth_region" class="form-select">
                        <option value="">Selecione (opcional)</option>
                        <optgroup label="Dentes Superiores Direitos">
                            @foreach([18,17,16,15,14,13,12,11] as $d)
                            <option value="{{ $d }}" @selected(old('tooth_region')==$d)>{{ $d }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Dentes Superiores Esquerdos">
                            @foreach([21,22,23,24,25,26,27,28] as $d)
                            <option value="{{ $d }}" @selected(old('tooth_region')==$d)>{{ $d }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Dentes Inferiores Esquerdos">
                            @foreach([31,32,33,34,35,36,37,38] as $d)
                            <option value="{{ $d }}" @selected(old('tooth_region')==$d)>{{ $d }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Dentes Inferiores Direitos">
                            @foreach([48,47,46,45,44,43,42,41] as $d)
                            <option value="{{ $d }}" @selected(old('tooth_region')==$d)>{{ $d }}</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Regiões">
                            @foreach(['Arcada Superior','Arcada Inferior','Arcada Completa','Anterior Superior','Anterior Inferior','Posterior Superior Direito','Posterior Superior Esquerdo','Posterior Inferior Direito','Posterior Inferior Esquerdo','ATM','Face','Mucosa'] as $r)
                            <option value="{{ $r }}" @selected(old('tooth_region')===$r)>{{ $r }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>

        {{-- Evolução Clínica --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Evolução Clínica</h3></div>
            <div class="card-body row g-3">
                <div class="col-12">
                    <label class="form-label required">Evolução / Descrição do Atendimento</label>
                    <textarea name="evolution" class="form-control" rows="4" required>{{ old('evolution') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Diagnóstico</label>
                    <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tratamento Realizado</label>
                    <textarea name="treatment" class="form-control" rows="2">{{ old('treatment') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Materiais Utilizados</label>
                    <textarea name="materials" class="form-control" rows="2" placeholder="Ex: Resina Z350, Ácido fosfórico 37%...">{{ old('materials') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Prescrição</label>
                    <textarea name="prescription" class="form-control" rows="2" placeholder="Medicamentos prescritos...">{{ old('prescription') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Orientações e Planejamento --}}
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Orientações e Planejamento</h3></div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label class="form-label">Orientações ao Paciente</label>
                    <textarea name="guidelines" class="form-control" rows="3">{{ old('guidelines') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Plano de Tratamento</label>
                    <textarea name="treatment_plan" class="form-control" rows="3">{{ old('treatment_plan') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Próxima Sessão</label>
                    <input type="date" name="next_session" class="form-control" value="{{ old('next_session') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Observações</label>
                    <textarea name="observations" class="form-control" rows="2">{{ old('observations') }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('operacional.pacientes.show', $paciente) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2"/><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M14 4l0 4l-6 0l0 -4"/></svg>
                Salvar Prontuário
            </button>
        </div>
    </form>

</x-app-layout>
