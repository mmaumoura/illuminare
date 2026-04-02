<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col"><h2 class="page-title">Nova Oportunidade</h2></div>
        <div class="col-auto">
            <a href="{{ route('crm.oportunidades.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
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

    <form method="POST" action="{{ route('crm.oportunidades.store') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Dados da Oportunidade</h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label required">Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}"
                               class="form-control @error('titulo') is-invalid @enderror" required>
                        @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">Estágio</label>
                        <select name="estagio" class="form-select" required>
                            @foreach(['prospeccao'=>'Prospecção','qualificacao'=>'Qualificação','proposta'=>'Proposta','negociacao'=>'Negociação','fechamento'=>'Fechamento','ganho'=>'Ganho','perdido'=>'Perdido'] as $val => $lbl)
                            <option value="{{ $val }}" {{ old('estagio','prospeccao') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Probabilidade (%)</label>
                        <input type="number" name="probabilidade" value="{{ old('probabilidade', 0) }}"
                               class="form-control" min="0" max="100">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Valor (R$)</label>
                        <input type="number" name="valor" value="{{ old('valor') }}"
                               class="form-control" step="0.01" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Previsão de Fechamento</label>
                        <input type="date" name="data_fechamento_previsto"
                               value="{{ old('data_fechamento_previsto') }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Responsável</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Selecione…</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Unidade</label>
                        <select name="clinic_id" class="form-select">
                            <option value="">Selecione…</option>
                            @foreach($clinics as $c)
                            <option value="{{ $c->id }}" {{ old('clinic_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cliente</label>
                        <select name="crm_client_id" class="form-select">
                            <option value="">Selecione…</option>
                            @foreach($clients as $cl)
                            <option value="{{ $cl->id }}" {{ old('crm_client_id', request('crm_client_id')) == $cl->id ? 'selected' : '' }}>{{ $cl->nome_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lead</label>
                        <select name="lead_id" class="form-select">
                            <option value="">Selecione…</option>
                            @foreach($leads as $l)
                            <option value="{{ $l->id }}" {{ old('lead_id', request('lead_id')) == $l->id ? 'selected' : '' }}>{{ $l->nome_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" rows="3" class="form-control">{{ old('descricao') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('crm.oportunidades.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Oportunidade</button>
        </div>
    </form>

</x-app-layout>
