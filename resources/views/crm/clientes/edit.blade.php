<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Editar Cliente</h2>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.clientes.show', $cliente) }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/>
                    <path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('crm.clientes.update', $cliente) }}">
        @csrf @method('PATCH')

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Dados Pessoais</h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Nome Completo</label>
                        <input type="text" name="nome_completo" value="{{ old('nome_completo', $cliente->nome_completo) }}"
                               class="form-control @error('nome_completo') is-invalid @enderror" required>
                        @error('nome_completo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">Tipo</label>
                        <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                            <option value="cliente" {{ old('tipo', $cliente->tipo) === 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="lead"    {{ old('tipo', $cliente->tipo) === 'lead'    ? 'selected' : '' }}>Lead</option>
                        </select>
                        @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unidade</label>
                        <select name="clinic_id" class="form-select">
                            <option value="">Selecione…</option>
                            @foreach($clinics as $c)
                            <option value="{{ $c->id }}" {{ old('clinic_id', $cliente->clinic_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Telefone</label>
                        <input type="text" name="telefone" value="{{ old('telefone', $cliente->telefone) }}"
                               class="form-control @error('telefone') is-invalid @enderror" required>
                        @error('telefone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" value="{{ old('email', $cliente->email) }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">CPF</label>
                        <input type="text" name="cpf" value="{{ old('cpf', $cliente->cpf) }}"
                               class="form-control @error('cpf') is-invalid @enderror" placeholder="000.000.000-00">
                        @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Data de Nascimento</label>
                        <input type="date" name="data_nascimento"
                               value="{{ old('data_nascimento', $cliente->data_nascimento?->format('Y-m-d')) }}"
                               class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Endereço</h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">CEP</label>
                        <input type="text" name="cep" value="{{ old('cep', $cliente->cep) }}" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Logradouro</label>
                        <input type="text" name="logradouro" value="{{ old('logradouro', $cliente->logradouro) }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Número</label>
                        <input type="text" name="numero" value="{{ old('numero', $cliente->numero) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Complemento</label>
                        <input type="text" name="complemento" value="{{ old('complemento', $cliente->complemento) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bairro</label>
                        <input type="text" name="bairro" value="{{ old('bairro', $cliente->bairro) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cidade</label>
                        <input type="text" name="cidade" value="{{ old('cidade', $cliente->cidade) }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Estado (UF)</label>
                        <input type="text" name="estado" value="{{ old('estado', $cliente->estado) }}" class="form-control" maxlength="2">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Observações</h3></div>
            <div class="card-body">
                <textarea name="observacoes" rows="3" class="form-control">{{ old('observacoes', $cliente->observacoes) }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('crm.clientes.show', $cliente) }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>

</x-app-layout>
