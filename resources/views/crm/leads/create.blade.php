<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Novo Lead</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('crm.leads.index') }}" class="btn btn-secondary">
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

    <form method="POST" action="{{ route('crm.leads.store') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Dados do Lead</h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label required">Nome Completo</label>
                        <input type="text" name="nome_completo" value="{{ old('nome_completo') }}"
                               class="form-control @error('nome_completo') is-invalid @enderror" required>
                        @error('nome_completo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" value="{{ old('telefone') }}"
                               class="form-control" placeholder="(00) 00000-0000">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Empresa</label>
                        <input type="text" name="empresa" value="{{ old('empresa') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cargo</label>
                        <input type="text" name="cargo" value="{{ old('cargo') }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Valor Estimado (R$)</label>
                        <input type="number" name="valor_estimado" value="{{ old('valor_estimado') }}"
                               class="form-control" step="0.01" min="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data de Contato</label>
                        <input type="date" name="data_contato" value="{{ old('data_contato') }}" class="form-control">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Classificação</h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="novo"        {{ old('status','novo') === 'novo'        ? 'selected' : '' }}>Novo</option>
                            <option value="contatado"   {{ old('status') === 'contatado'   ? 'selected' : '' }}>Contatado</option>
                            <option value="qualificado" {{ old('status') === 'qualificado' ? 'selected' : '' }}>Qualificado</option>
                            <option value="convertido"  {{ old('status') === 'convertido'  ? 'selected' : '' }}>Convertido</option>
                            <option value="perdido"     {{ old('status') === 'perdido'     ? 'selected' : '' }}>Perdido</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">Origem</label>
                        <select name="origem" class="form-select @error('origem') is-invalid @enderror" required>
                            <option value="site"          {{ old('origem','site') === 'site'          ? 'selected' : '' }}>Site</option>
                            <option value="indicacao"     {{ old('origem') === 'indicacao'     ? 'selected' : '' }}>Indicação</option>
                            <option value="redes_sociais" {{ old('origem') === 'redes_sociais' ? 'selected' : '' }}>Redes Sociais</option>
                            <option value="evento"        {{ old('origem') === 'evento'        ? 'selected' : '' }}>Evento</option>
                            <option value="ligacao"       {{ old('origem') === 'ligacao'       ? 'selected' : '' }}>Ligação</option>
                            <option value="email"         {{ old('origem') === 'email'         ? 'selected' : '' }}>E-mail</option>
                            <option value="outro"         {{ old('origem') === 'outro'         ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('origem')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">Responsável</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Selecione…</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unidade</label>
                        <select name="clinic_id" class="form-select">
                            <option value="">Selecione…</option>
                            @foreach($clinics as $c)
                            <option value="{{ $c->id }}" {{ old('clinic_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Observações</h3></div>
            <div class="card-body">
                <textarea name="observacoes" rows="3" class="form-control"
                          placeholder="Informações adicionais sobre o lead…">{{ old('observacoes') }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('crm.leads.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Lead</button>
        </div>
    </form>

</x-app-layout>
