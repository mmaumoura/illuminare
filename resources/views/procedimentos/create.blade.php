<x-app-layout>

    @php
    $categories = [
        "Clínico Geral",
        "Cirurgia Oral e Maxilofacial",
        "Dentística e Restauração",
        "Endodontia",
        "Estética Dental",
        "Implantodontia",
        "Odontopediatria",
        "Ortodontia e Ortopedia Facial",
        "Periodontia",
        "Prótese Dentária",
        "Prótese sobre Implante",
        "Radiologia Odontológica",
        "Harmonização Orofacial",
        "Clareamento Dental",
        "Urgência Odontológica",
        "Prevenção e Profilaxia",
        "Traumatologia Dentária",
        "Outro",
    ];
    @endphp

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Cadastrar Novo Procedimento</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('gestao.procedimentos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('gestao.procedimentos.store') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tb-basico" type="button">Dados Básicos</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tb-tecnico" type="button">Informações Técnicas</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tb-cuidados" type="button">Cuidados</button></li>
                </ul>
            </div>
            <div class="card-body tab-content">

                <div class="tab-pane fade show active" id="tb-basico">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Nome do Procedimento</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Ex: Extração de Terceiro Molar">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label required">Categoria</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror">
                                <option value="">Selecione...</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label required">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="Ativo" {{ old('status','Ativo') === 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="Inativo" {{ old('status') === 'Inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label required">Preço (R$)</label>
                            <div class="input-group"><span class="input-group-text">R$</span>
                            <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" placeholder="0,00"></div>
                            @error('price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label required">Duração (minutos)</label>
                            <div class="input-group">
                            <input type="number" name="duration_minutes" min="1" value="{{ old('duration_minutes') }}" class="form-control @error('duration_minutes') is-invalid @enderror" placeholder="60">
                            <span class="input-group-text">min</span></div>
                            @error('duration_minutes')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sessões Recomendadas</label>
                            <input type="number" name="sessions_recommended" min="1" value="{{ old('sessions_recommended') }}" class="form-control" placeholder="1">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Intervalo entre Sessões (dias)</label>
                            <div class="input-group">
                            <input type="number" name="sessions_interval_days" min="0" value="{{ old('sessions_interval_days') }}" class="form-control" placeholder="30">
                            <span class="input-group-text">dias</span></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Unidades *</label>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">Selecione as unidades onde este procedimento estará disponível</small>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-sa">Selecionar todas</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-da">Desmarcar todas</button>
                                </div>
                            </div>
                            @error('clinics')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                            <div class="row g-2">
                                @foreach($clinics as $clinic)
                                <div class="col-md-4 col-lg-3">
                                    <label class="form-check">
                                        <input class="form-check-input clinic-check" type="checkbox" name="clinics[]" value="{{ $clinic->id }}" {{ in_array($clinic->id, old('clinics', [])) ? 'checked' : '' }}>
                                        <span class="form-check-label">{{ $clinic->name }}</span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descrição</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="Descreva o procedimento de forma geral">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tb-tecnico">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Indicações</label>
                            <textarea name="indications" rows="6" class="form-control" placeholder="Casos em que este procedimento é indicado">{{ old('indications') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contraindicações</label>
                            <textarea name="contraindications" rows="6" class="form-control" placeholder="Casos em que este procedimento NÃO deve ser realizado">{{ old('contraindications') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Materiais Utilizados</label>
                            <textarea name="products_used" rows="6" class="form-control" placeholder="Resinas, cimentos, anestésicos, implantes, fios de sutura, etc.">{{ old('products_used') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Equipamentos Necessários</label>
                            <textarea name="equipment_needed" rows="6" class="form-control" placeholder="Instrumental cirúrgico, motor, fotopolimerizador, RX, etc.">{{ old('equipment_needed') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tb-cuidados">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Cuidados Pré-Procedimento</label>
                            <textarea name="pre_care" rows="8" class="form-control" placeholder="Orientações ao paciente ANTES do procedimento (higiene bucal, medicações, jejum se necessário, etc.)">{{ old('pre_care') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Cuidados Pós-Procedimento</label>
                            <textarea name="post_care" rows="8" class="form-control" placeholder="Orientações ao paciente APÓS o procedimento (dieta, higiene, medicações, sinais de alerta, retorno)">{{ old('post_care') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Custos do Procedimento</h3></div>
            <div class="card-body">
                <p class="text-muted small mb-3">Adicione os custos associados (materiais, laboratório protético, etc.).</p>
                <table class="table table-sm mb-2">
                    <thead><tr><th>Descrição do Custo</th><th style="width:180px">Valor (R$)</th><th style="width:50px"></th></tr></thead>
                    <tbody id="costs-body">
                        @if(old('costs'))
                        @foreach(old('costs') as $i => $c)
                        <tr class="cost-row">
                            <td><input type="text" name="costs[{{ $i }}][name]" value="{{ $c['name'] ?? '' }}" class="form-control form-control-sm" placeholder="Ex: Resina, Lab. protético…" required></td>
                            <td><div class="input-group input-group-sm"><span class="input-group-text">R$</span>
                                <input type="number" name="costs[{{ $i }}][value]" value="{{ $c['value'] ?? '' }}" step="0.01" min="0" class="form-control" placeholder="0,00" required></div></td>
                            <td><button type="button" class="btn btn-sm btn-ghost-danger btn-rc">✕</button></td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-add-cost">+ Adicionar Custo</button>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('gestao.procedimentos.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Procedimento</button>
        </div>
    </form>

    @push('scripts')
    <script>
    document.getElementById('btn-sa').addEventListener('click', () => document.querySelectorAll('.clinic-check').forEach(c => c.checked = true));
    document.getElementById('btn-da').addEventListener('click', () => document.querySelectorAll('.clinic-check').forEach(c => c.checked = false));
    var ci = {{ old('costs') ? count(old('costs')) : 0 }};
    document.getElementById('btn-add-cost').addEventListener('click', function() {
        var i = ci++, tr = document.createElement('tr');
        tr.className = 'cost-row';
        tr.innerHTML = '<td><input type="text" name="costs['+i+'][name]" class="form-control form-control-sm" placeholder="Ex: Resina, Lab. protético…" required></td>'
            +'<td><div class="input-group input-group-sm"><span class="input-group-text">R$</span>'
            +'<input type="number" name="costs['+i+'][value]" step="0.01" min="0" class="form-control" placeholder="0,00" required></div></td>'
            +'<td><button type="button" class="btn btn-sm btn-ghost-danger btn-rc">✕</button></td>';
        document.getElementById('costs-body').appendChild(tr);
    });
    document.getElementById('costs-body').addEventListener('click', function(e) {
        if (e.target.closest('.btn-rc')) e.target.closest('tr').remove();
    });
    </script>
    @endpush

</x-app-layout>