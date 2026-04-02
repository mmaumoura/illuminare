@php
    $isEdit = isset($clinic);
    $action = $isEdit
        ? route('gestao.clinicas.update', $clinic)
        : route('gestao.clinicas.store');
    $title  = $isEdit ? 'Editar Unidade' : 'Nova Unidade';
    $c      = $clinic ?? null;

    $states = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG',
               'PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
@endphp
<x-app-layout>
    <x-slot name="header">{{ $title }}</x-slot>

    <div class="d-flex mb-3">
        <a href="{{ route('gestao.clinicas.index') }}" class="btn btn-outline-secondary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 6l-6 6l6 6"/>
            </svg>
            Voltar
        </a>
    </div>

    <form method="POST" action="{{ $action }}">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="row g-3">

            {{-- Informações Básicas --}}
            <div class="col-12 col-lg-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Informações da Unidade</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label required">Nome da unidade</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $c?->name) }}" placeholder="Ex: Illuminare PNZ" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Telefone</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $c?->phone) }}" placeholder="(00) 00000-0000">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $c?->email) }}" placeholder="contato@illuminare.com.br">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Endereço --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Endereço</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <label class="form-label">CEP</label>
                                <input type="text" name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror"
                                       value="{{ old('cep', $c?->cep) }}" placeholder="00000-000" maxlength="9">
                                @error('cep')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Logradouro</label>
                                <input type="text" name="street" id="street" class="form-control @error('street') is-invalid @enderror"
                                       value="{{ old('street', $c?->street) }}" placeholder="Rua, Av, Praça...">
                                @error('street')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-2">
                                <label class="form-label">Número</label>
                                <input type="text" name="number" class="form-control @error('number') is-invalid @enderror"
                                       value="{{ old('number', $c?->number) }}" placeholder="123">
                                @error('number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Complemento</label>
                                <input type="text" name="complement" class="form-control @error('complement') is-invalid @enderror"
                                       value="{{ old('complement', $c?->complement) }}" placeholder="Sala 201">
                                @error('complement')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label">Bairro</label>
                                <input type="text" name="neighborhood" id="neighborhood" class="form-control @error('neighborhood') is-invalid @enderror"
                                       value="{{ old('neighborhood', $c?->neighborhood) }}">
                                @error('neighborhood')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror"
                                       value="{{ old('city', $c?->city) }}">
                                @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-1">
                                <label class="form-label">UF</label>
                                <select name="state" id="state" class="form-select @error('state') is-invalid @enderror">
                                    <option value=""></option>
                                    @foreach($states as $uf)
                                        <option value="{{ $uf }}" {{ old('state', $c?->state) === $uf ? 'selected' : '' }}>
                                            {{ $uf }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-12 col-lg-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Status</h3>
                    </div>
                    <div class="card-body">
                        <label class="form-check form-switch">
                            <input type="hidden" name="active" value="0">
                            <input class="form-check-input" type="checkbox" name="active" value="1"
                                   {{ old('active', $c?->active ?? true) ? 'checked' : '' }}>
                            <span class="form-check-label">Unidade ativa</span>
                        </label>
                        <p class="text-muted mt-2 mb-0 small">
                            Unidades inativas não aparecem no cadastro de pacientes.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2H6a2 2 0 0 1 -2 -2V6a2 2 0 0 1 2 -2"/>
                                    <path d="M10 14a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M8 4v4h8V4"/>
                                </svg>
                                {{ $isEdit ? 'Salvar alterações' : 'Cadastrar unidade' }}
                            </button>
                            <a href="{{ route('gestao.clinicas.index') }}" class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    @push('scripts')
    <script>
    // ViaCEP
    document.getElementById('cep').addEventListener('blur', function () {
        const raw = this.value.replace(/\D/g, '');
        if (raw.length !== 8) return;
        fetch('https://viacep.com.br/ws/' + raw + '/json/')
            .then(r => r.json())
            .then(data => {
                if (data.erro) return;
                document.getElementById('street').value       = data.logradouro || '';
                document.getElementById('neighborhood').value = data.bairro      || '';
                document.getElementById('city').value         = data.localidade  || '';
                $('#state').val(data.uf || '').trigger('change'); // refresh Select2
            })
            .catch(() => {});
    });

    // CEP mask
    document.getElementById('cep').addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '').slice(0, 8);
        if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5);
        this.value = v;
    });

    // Phone mask
    document.getElementById('phone').addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '').slice(0, 11);
        if (v.length > 6) v = '(' + v.slice(0,2) + ') ' + v.slice(2,7) + '-' + v.slice(7);
        else if (v.length > 2) v = '(' + v.slice(0,2) + ') ' + v.slice(2);
        else if (v.length > 0) v = '(' + v;
        this.value = v;
    });
    </script>
    @endpush
</x-app-layout>
