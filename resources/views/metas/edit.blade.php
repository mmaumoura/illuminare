<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Editar Meta</h2>
            <p class="text-muted mt-1">{{ $meta->titulo }}</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('comercial.metas.show', $meta) }}" class="btn btn-secondary">Cancelar</a>
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

    <form method="POST" action="{{ route('comercial.metas.update', $meta) }}">
        @csrf @method('PUT')

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Informações da Meta</h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label required">Título</label>
                        <input type="text" name="titulo"
                               class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ old('titulo', $meta->titulo) }}">
                        @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label required">Tipo</label>
                        <select name="tipo" class="form-select @error('tipo') is-invalid @enderror">
                            @foreach(['diaria'=>'Diária','semanal'=>'Semanal','mensal'=>'Mensal','trimestral'=>'Trimestral','anual'=>'Anual'] as $v => $l)
                            <option value="{{ $v }}" {{ old('tipo', $meta->tipo) === $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                        @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="ativa"     {{ old('status', $meta->status) === 'ativa'     ? 'selected' : '' }}>Ativa</option>
                            <option value="concluida" {{ old('status', $meta->status) === 'concluida' ? 'selected' : '' }}>Concluída</option>
                            <option value="cancelada" {{ old('status', $meta->status) === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label required">Início do Período</label>
                        <input type="date" name="periodo_inicio"
                               class="form-control @error('periodo_inicio') is-invalid @enderror"
                               value="{{ old('periodo_inicio', $meta->periodo_inicio->format('Y-m-d')) }}">
                        @error('periodo_inicio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label required">Fim do Período</label>
                        <input type="date" name="periodo_fim"
                               class="form-control @error('periodo_fim') is-invalid @enderror"
                               value="{{ old('periodo_fim', $meta->periodo_fim->format('Y-m-d')) }}">
                        @error('periodo_fim')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unidade</label>
                        <select name="clinic_id" class="form-select @error('clinic_id') is-invalid @enderror">
                            <option value="">Todas as unidades</option>
                            @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ old('clinic_id', $meta->clinic_id) == $clinic->id ? 'selected' : '' }}>
                                {{ $clinic->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('clinic_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Responsável</label>
                        <select name="responsavel_id" class="form-select @error('responsavel_id') is-invalid @enderror">
                            <option value="">Sem responsável</option>
                            @foreach($usuarios as $user)
                            <option value="{{ $user->id }}" {{ old('responsavel_id', $meta->responsavel_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('responsavel_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Metas</h3></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Meta de Faturamento (R$)</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="number" name="meta_valor" step="0.01" min="0"
                                   class="form-control @error('meta_valor') is-invalid @enderror"
                                   value="{{ old('meta_valor', $meta->meta_valor) }}">
                        </div>
                        @error('meta_valor')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Meta de Procedimentos</label>
                        <input type="number" name="meta_procedimentos" min="0"
                               class="form-control @error('meta_procedimentos') is-invalid @enderror"
                               value="{{ old('meta_procedimentos', $meta->meta_procedimentos) }}">
                        @error('meta_procedimentos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Meta de Pacientes Novos</label>
                        <input type="number" name="meta_pacientes_novos" min="0"
                               class="form-control @error('meta_pacientes_novos') is-invalid @enderror"
                               value="{{ old('meta_pacientes_novos', $meta->meta_pacientes_novos) }}">
                        @error('meta_pacientes_novos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descrição / Observações</label>
                        <textarea name="descricao" rows="3" class="form-control">{{ old('descricao', $meta->descricao) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="{{ route('comercial.metas.show', $meta) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

</x-app-layout>
