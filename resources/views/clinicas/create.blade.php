<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Nova Unidade</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('gestao.clinicas.index') }}" class="btn btn-secondary">
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

    <form method="POST" action="{{ route('gestao.clinicas.store') }}">
        @csrf

        {{-- INFORMAÇÕES BÁSICAS --}}
        <div class="card mb-3">
            <div class="card-header">
                <span class="avatar avatar-sm me-2 bg-primary text-white" style="font-size:.85rem">1</span>
                <h3 class="card-title">Informações Básicas</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Nome da Unidade</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror" placeholder="Ex: Unidade Centro">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CNPJ</label>
                        <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj') }}"
                               class="form-control @error('cnpj') is-invalid @enderror"
                               placeholder="00.000.000/0000-00" maxlength="18">
                        @error('cnpj')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">Status de Operação</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach(['Ativa','Inativa','Suspensa'] as $s)
                            <option value="{{ $s }}" {{ old('status','Ativa') === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                               class="form-control @error('phone') is-invalid @enderror" placeholder="(00) 00000-0000">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror" placeholder="contato@unidade.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ENDEREÇO --}}
        <div class="card mb-3">
            <div class="card-header">
                <span class="avatar avatar-sm me-2 bg-primary text-white" style="font-size:.85rem">2</span>
                <h3 class="card-title">Endereço</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">CEP</label>
                        <input type="text" name="cep" id="cep" value="{{ old('cep') }}"
                               class="form-control @error('cep') is-invalid @enderror"
                               placeholder="00000-000" maxlength="9">
                        @error('cep')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Logradouro</label>
                        <input type="text" name="street" id="street" value="{{ old('street') }}"
                               class="form-control @error('street') is-invalid @enderror" placeholder="Rua, Av., etc.">
                        @error('street')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Número</label>
                        <input type="text" name="number" id="number" value="{{ old('number') }}"
                               class="form-control @error('number') is-invalid @enderror" placeholder="00">
                        @error('number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Complemento</label>
                        <input type="text" name="complement" value="{{ old('complement') }}"
                               class="form-control" placeholder="Apto, Sala, etc.">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bairro</label>
                        <input type="text" name="neighborhood" id="neighborhood" value="{{ old('neighborhood') }}"
                               class="form-control @error('neighborhood') is-invalid @enderror">
                        @error('neighborhood')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}"
                               class="form-control @error('city') is-invalid @enderror">
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">UF</label>
                        <input type="text" name="state" id="state" value="{{ old('state') }}"
                               class="form-control @error('state') is-invalid @enderror"
                               placeholder="SP" maxlength="2" style="text-transform:uppercase">
                        @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- REPRESENTANTE LEGAL --}}
        <div class="card mb-3">
            <div class="card-header">
                <span class="avatar avatar-sm me-2 bg-primary text-white" style="font-size:.85rem">3</span>
                <h3 class="card-title">Representante Legal</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome do Representante</label>
                        <input type="text" name="rep_name" value="{{ old('rep_name') }}"
                               class="form-control" placeholder="Nome completo">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CPF do Representante</label>
                        <input type="text" name="rep_cpf" id="rep_cpf" value="{{ old('rep_cpf') }}"
                               class="form-control" placeholder="000.000.000-00" maxlength="14">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Telefone do Representante</label>
                        <input type="text" name="rep_phone" id="rep_phone" value="{{ old('rep_phone') }}"
                               class="form-control" placeholder="(00) 00000-0000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">E-mail do Representante</label>
                        <input type="email" name="rep_email" value="{{ old('rep_email') }}"
                               class="form-control" placeholder="representante@email.com">
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTRATO --}}
        <div class="card mb-3">
            <div class="card-header">
                <span class="avatar avatar-sm me-2 bg-primary text-white" style="font-size:.85rem">4</span>
                <h3 class="card-title">Informações do Contrato</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Início do Contrato</label>
                        <input type="date" name="contract_start" value="{{ old('contract_start') }}"
                               class="form-control @error('contract_start') is-invalid @enderror">
                        @error('contract_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Término do Contrato</label>
                        <input type="date" name="contract_end" value="{{ old('contract_end') }}"
                               class="form-control @error('contract_end') is-invalid @enderror">
                        @error('contract_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Observações do Contrato</label>
                        <textarea name="contract_notes" rows="3"
                                  class="form-control" placeholder="Informações adicionais do contrato...">{{ old('contract_notes') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('gestao.clinicas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Unidade</button>
        </div>
    </form>

    @push('scripts')
    <script>
    // CEP auto-fill
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

    // CEP mask
    document.getElementById('cep').addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '');
        if (v.length > 5) v = v.slice(0,5) + '-' + v.slice(5,8);
        this.value = v;
    });

    // CNPJ mask
    document.getElementById('cnpj').addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '');
        v = v.replace(/^(\d{2})(\d)/, '$1.$2');
        v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
        v = v.replace(/(\d{4})(\d)/, '$1-$2');
        this.value = v.slice(0, 18);
    });

    // CPF mask
    document.getElementById('rep_cpf').addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d)/, '$1.$2');
        v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        this.value = v.slice(0, 14);
    });

    // Phone masks
    ['phone','rep_phone'].forEach(id => {
        document.getElementById(id).addEventListener('input', function () {
            let v = this.value.replace(/\D/g, '');
            if (v.length > 10)
                v = v.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            else
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            this.value = v;
        });
    });
    </script>
    @endpush
</x-app-layout>
