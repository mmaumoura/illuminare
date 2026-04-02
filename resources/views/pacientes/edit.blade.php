<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">
                Editar Paciente:
                <span class="text-muted fw-normal">{{ $paciente->name }}</span>
            </h2>
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
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('operacional.pacientes.update', $paciente) }}">
        @csrf @method('PUT')

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                    <li class="nav-item">
                        <a href="#tab-pessoal" class="nav-link active" data-bs-toggle="tab">Dados Pessoais</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tab-endereco" class="nav-link" data-bs-toggle="tab">Endereço</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tab-medico" class="nav-link" data-bs-toggle="tab">Informações Médicas</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tab-emergencia" class="nav-link" data-bs-toggle="tab">Contato de Emergência</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">

                    {{-- ABA 1: DADOS PESSOAIS --}}
                    <div class="tab-pane active show" id="tab-pessoal">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Nome Completo</label>
                                <input type="text" name="name" value="{{ old('name', $paciente->name) }}"
                                       class="form-control @error('name') is-invalid @enderror">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">CPF</label>
                                <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $paciente->cpf) }}"
                                       class="form-control @error('cpf') is-invalid @enderror"
                                       placeholder="000.000.000-00" maxlength="14">
                                @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Data de Nascimento</label>
                                <input type="date" name="birth_date"
                                       value="{{ old('birth_date', $paciente->birth_date?->format('Y-m-d')) }}"
                                       class="form-control @error('birth_date') is-invalid @enderror">
                                @error('birth_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Telefone</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $paciente->phone) }}"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="(00) 00000-0000">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" value="{{ old('email', $paciente->email) }}"
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Unidade</label>
                                @if($userClinicId && $clinics->isNotEmpty())
                                    <input type="hidden" name="clinic_id" value="{{ $userClinicId }}">
                                    <p class="form-control-plaintext fw-semibold mb-0">{{ $clinics->first()->name }}</p>
                                @else
                                    <select name="clinic_id" class="form-select @error('clinic_id') is-invalid @enderror">
                                        <option value="">Selecione a unidade</option>
                                        @foreach($clinics as $clinic)
                                        <option value="{{ $clinic->id }}"
                                            {{ old('clinic_id', $paciente->clinic_id) == $clinic->id ? 'selected' : '' }}>
                                            {{ $clinic->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('clinic_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ABA 2: ENDEREÇO --}}
                    <div class="tab-pane" id="tab-endereco">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">CEP</label>
                                <input type="text" name="cep" id="cep" value="{{ old('cep', $paciente->cep) }}"
                                       class="form-control" placeholder="00000-000" maxlength="9">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Logradouro</label>
                                <input type="text" name="street" id="street" value="{{ old('street', $paciente->street) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Número</label>
                                <input type="text" name="number" id="number" value="{{ old('number', $paciente->number) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Complemento</label>
                                <input type="text" name="complement" value="{{ old('complement', $paciente->complement) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Bairro</label>
                                <input type="text" name="neighborhood" id="neighborhood" value="{{ old('neighborhood', $paciente->neighborhood) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" name="city" id="city" value="{{ old('city', $paciente->city) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">UF</label>
                                <input type="text" name="state" id="state" value="{{ old('state', $paciente->state) }}"
                                       class="form-control" maxlength="2" style="text-transform:uppercase">
                            </div>
                        </div>
                    </div>

                    {{-- ABA 3: INFORMAÇÕES MÉDICAS --}}
                    <div class="tab-pane" id="tab-medico">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Histórico Médico</label>
                                <textarea name="medical_history" rows="4" class="form-control">{{ old('medical_history', $paciente->medical_history) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alergias</label>
                                <textarea name="allergies" rows="3" class="form-control">{{ old('allergies', $paciente->allergies) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Medicamentos em Uso</label>
                                <textarea name="current_medications" rows="3" class="form-control">{{ old('current_medications', $paciente->current_medications) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ABA 4: CONTATO DE EMERGÊNCIA --}}
                    <div class="tab-pane" id="tab-emergencia">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome do Contato</label>
                                <input type="text" name="emergency_contact_name"
                                       value="{{ old('emergency_contact_name', $paciente->emergency_contact_name) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Telefone do Contato</label>
                                <input type="text" name="emergency_contact_phone" id="emerg_phone"
                                       value="{{ old('emergency_contact_phone', $paciente->emergency_contact_phone) }}"
                                       class="form-control" placeholder="(00) 00000-0000">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('operacional.pacientes.show', $paciente) }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    document.getElementById('cep').addEventListener('blur', function () {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length !== 8) return;
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(r => r.json())
            .then(d => {
                if (d.erro) return;
                document.getElementById('street').value       = d.logradouro || '';
                document.getElementById('neighborhood').value = d.bairro     || '';
                document.getElementById('city').value         = d.localidade  || '';
                document.getElementById('state').value        = d.uf          || '';
                $('#state').trigger('change'); // refresh Select2
            }).catch(() => {});
    });

    document.getElementById('cep').addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '');
        if (v.length > 5) v = v.slice(0,5) + '-' + v.slice(5,8);
        this.value = v;
    });

    document.getElementById('cpf').addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        this.value = v.slice(0, 14);
    });

    ['phone','emerg_phone'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input', function () {
            let v = this.value.replace(/\D/g, '');
            if (v.length > 10)
                v = v.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            else
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            this.value = v;
        });
    });

    @if($errors->any())
    const errorFields = {
        'tab-pessoal':   ['name','cpf','birth_date','phone','email','clinic_id'],
        'tab-endereco':  ['cep','street','number','neighborhood','city','state'],
        'tab-medico':    ['medical_history','allergies','current_medications'],
        'tab-emergencia':['emergency_contact_name','emergency_contact_phone'],
    };
    const errorKeys = @json(array_keys($errors->toArray()));
    for (const [tab, fields] of Object.entries(errorFields)) {
        if (fields.some(f => errorKeys.includes(f))) {
            const tabEl = document.querySelector(`[href="#${tab}"]`);
            if (tabEl) { new bootstrap.Tab(tabEl).show(); break; }
        }
    }
    @endif
    </script>
    @endpush
</x-app-layout>
