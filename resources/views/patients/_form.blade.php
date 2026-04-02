@php
    $isEdit   = isset($patient);
    $action   = $isEdit
        ? route('operacional.pacientes.update', $patient)
        : route('operacional.pacientes.store');
    $title    = $isEdit ? 'Editar Paciente' : 'Cadastrar Novo Paciente';
    $p        = $patient ?? null;

    $states = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG',
               'PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
@endphp
<x-app-layout>
    <x-slot name="header">{{ $title }}</x-slot>

    {{-- Step nav (visual only) --}}
    <div class="card mb-3">
        <div class="card-body py-2">
            <ul class="nav nav-tabs card-header-tabs" id="patientTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-pessoal" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="7" r="4"/><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                        </svg>
                        Dados Pessoais
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-endereco" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
                            <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"/>
                        </svg>
                        Endereço
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-medico" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 14c1.49 -1.46 3 -3.21 3 -5.5a5.5 5.5 0 0 0 -11 0c0 2.29 1.51 4.04 3 5.5"/>
                            <path d="M8 21v-2a4 4 0 0 1 4-4h4"/><path d="M12 21v-6"/>
                        </svg>
                        Informações Médicas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tab-emergencia" role="tab">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 5a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-5 -3l-2 3l-2 -3l-5 3v-16z"/>
                        </svg>
                        Contato de Emergência
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <form method="POST" action="{{ $action }}" id="patientForm">
        @csrf
        @if($isEdit) @method('PATCH') @endif

        @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="tab-content">

            {{-- ── ABA 1: DADOS PESSOAIS ─────────────────────────── --}}
            <div class="tab-pane active" id="tab-pessoal">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dados Pessoais</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-8">
                                <label class="form-label required">Nome Completo</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $p?->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">CPF</label>
                                <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                                       value="{{ old('cpf', $p?->cpf) }}" placeholder="000.000.000-00"
                                       maxlength="14" id="cpf">
                                @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Data de Nascimento</label>
                                <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror"
                                       value="{{ old('birth_date', $p?->birth_date?->format('Y-m-d')) }}">
                                @error('birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label required">Telefone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $p?->phone) }}" placeholder="(00) 00000-0000"
                                       required id="phone">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $p?->email) }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label required">Unidade</label>
                                <select name="clinic_id" class="form-select @error('clinic_id') is-invalid @enderror" required>
                                    <option value="">Selecione...</option>
                                    @foreach($clinics as $clinic)
                                        <option value="{{ $clinic->id }}"
                                            {{ old('clinic_id', $p?->clinic_id) == $clinic->id ? 'selected' : '' }}>
                                            {{ $clinic->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('clinic_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('operacional.pacientes.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <a href="#tab-endereco" class="btn btn-outline-primary" data-bs-toggle="tab">Próximo: Endereço &rarr;</a>
                    </div>
                </div>
            </div>

            {{-- ── ABA 2: ENDEREÇO ──────────────────────────────── --}}
            <div class="tab-pane" id="tab-endereco">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Endereço</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-3">
                                <label class="form-label">CEP</label>
                                <input type="text" name="cep" id="cep" class="form-control"
                                       value="{{ old('cep', $p?->cep) }}" placeholder="00000-000" maxlength="9">
                            </div>
                            <div class="col-12 col-md-7">
                                <label class="form-label">Logradouro</label>
                                <input type="text" name="street" id="street" class="form-control"
                                       value="{{ old('street', $p?->street) }}">
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Número</label>
                                <input type="text" name="number" class="form-control"
                                       value="{{ old('number', $p?->number) }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Complemento</label>
                                <input type="text" name="complement" class="form-control"
                                       value="{{ old('complement', $p?->complement) }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Bairro</label>
                                <input type="text" name="neighborhood" id="neighborhood" class="form-control"
                                       value="{{ old('neighborhood', $p?->neighborhood) }}">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" name="city" id="city" class="form-control"
                                       value="{{ old('city', $p?->city) }}">
                            </div>
                            <div class="col-12 col-md-1">
                                <label class="form-label">UF</label>
                                <select name="state" id="state" class="form-select">
                                    <option value="">UF</option>
                                    @foreach($states as $uf)
                                        <option value="{{ $uf }}" {{ old('state', $p?->state) === $uf ? 'selected' : '' }}>
                                            {{ $uf }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="#tab-pessoal" class="btn btn-outline-secondary" data-bs-toggle="tab">&larr; Voltar</a>
                        <a href="#tab-medico" class="btn btn-outline-primary" data-bs-toggle="tab">Próximo: Informações Médicas &rarr;</a>
                    </div>
                </div>
            </div>

            {{-- ── ABA 3: INFORMAÇÕES MÉDICAS ────────────────────── --}}
            <div class="tab-pane" id="tab-medico">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações Médicas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Histórico Médico</label>
                                <textarea name="medical_history" class="form-control" rows="4"
                                          placeholder="Descreva cirurgias, doenças crônicas, tratamentos anteriores, etc.">{{ old('medical_history', $p?->medical_history) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alergias</label>
                                <textarea name="allergies" class="form-control" rows="3"
                                          placeholder="Liste todas as alergias conhecidas (medicamentos, alimentos, etc.)">{{ old('allergies', $p?->allergies) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Medicamentos em Uso</label>
                                <textarea name="current_medications" class="form-control" rows="3"
                                          placeholder="Liste os medicamentos em uso com dose e frequência">{{ old('current_medications', $p?->current_medications) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="#tab-endereco" class="btn btn-outline-secondary" data-bs-toggle="tab">&larr; Voltar</a>
                        <a href="#tab-emergencia" class="btn btn-outline-primary" data-bs-toggle="tab">Próximo: Contato de Emergência &rarr;</a>
                    </div>
                </div>
            </div>

            {{-- ── ABA 4: CONTATO DE EMERGÊNCIA ──────────────────── --}}
            <div class="tab-pane" id="tab-emergencia">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Contato de Emergência</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Nome do Contato</label>
                                <input type="text" name="emergency_contact_name" class="form-control"
                                       value="{{ old('emergency_contact_name', $p?->emergency_contact_name) }}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Telefone do Contato</label>
                                <input type="text" name="emergency_contact_phone" class="form-control"
                                       value="{{ old('emergency_contact_phone', $p?->emergency_contact_phone) }}"
                                       placeholder="(00) 00000-0000" id="phone_emergency">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="#tab-medico" class="btn btn-outline-secondary" data-bs-toggle="tab">&larr; Voltar</a>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"/>
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M14 4l0 4l-6 0l0 -4"/>
                            </svg>
                            {{ $isEdit ? 'Salvar Alterações' : 'Cadastrar Paciente' }}
                        </button>
                    </div>
                </div>
            </div>

        </div>{{-- /tab-content --}}
    </form>

    <script>
    // Busca CEP via ViaCEP
    document.getElementById('cep')?.addEventListener('blur', function () {
        var cep = this.value.replace(/\D/g, '');
        if (cep.length !== 8) return;
        fetch('https://viacep.com.br/ws/' + cep + '/json/')
            .then(function (r) { return r.json(); })
            .then(function (d) {
                if (d.erro) return;
                document.getElementById('street').value       = d.logradouro  || '';
                document.getElementById('neighborhood').value = d.bairro       || '';
                document.getElementById('city').value         = d.localidade   || '';
                document.getElementById('state').value        = d.uf           || '';
                $('#state').trigger('change'); // refresh Select2
            });
    });

    // Máscara CPF: 000.000.000-00
    document.getElementById('cpf')?.addEventListener('input', function () {
        var v = this.value.replace(/\D/g, '').substring(0, 11);
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        this.value = v;
    });

    // Máscara telefone
    function maskPhone(el) {
        el?.addEventListener('input', function () {
            var v = this.value.replace(/\D/g, '').substring(0, 11);
            if (v.length <= 10) v = v.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            else                v = v.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            this.value = v;
        });
    }
    maskPhone(document.getElementById('phone'));
    maskPhone(document.getElementById('phone_emergency'));
    </script>
</x-app-layout>
