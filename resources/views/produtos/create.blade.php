<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Novo Produto</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('comercial.produtos.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
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

    <form method="POST" action="{{ route('comercial.produtos.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            {{-- COLUNA PRINCIPAL --}}
            <div class="col-lg-8">

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Informações Básicas</h3></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label required">Código</label>
                                <input type="text" name="code" value="{{ old('code') }}"
                                       class="form-control @error('code') is-invalid @enderror"
                                       placeholder="Ex: 108">
                                @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label required">Nome</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Nome do produto">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label required">Unidades</label>
                                @error('clinics')<div class="text-danger small mb-1">{{ $message }}</div>@enderror
                                <div class="row g-2">
                                    @foreach($clinics as $clinic)
                                    <div class="col-md-4 col-lg-3">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="clinics[]" value="{{ $clinic->id }}"
                                                   {{ in_array($clinic->id, old('clinics', [])) ? 'checked' : '' }}>
                                            <span class="form-check-label">{{ $clinic->name }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="form-hint">Selecione as unidades onde este produto estará disponível</div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Categoria</label>
                                <input type="text" name="category" value="{{ old('category') }}"
                                       class="form-control" placeholder="Ex: Skincare">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Marca</label>
                                <input type="text" name="brand" value="{{ old('brand') }}"
                                       class="form-control" placeholder="Ex: Bellife">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fornecedor</label>
                                <input type="text" name="supplier" value="{{ old('supplier') }}"
                                       class="form-control" placeholder="Nome do fornecedor">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descrição</label>
                                <textarea name="description" rows="3" class="form-control"
                                          placeholder="Descrição do produto…">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Preços</h3></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Custo</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="cost_price" step="0.01" min="0"
                                           value="{{ old('cost_price') }}"
                                           class="form-control @error('cost_price') is-invalid @enderror"
                                           placeholder="0,00">
                                </div>
                                @error('cost_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Preço Venda</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="sale_price" step="0.01" min="0"
                                           value="{{ old('sale_price') }}"
                                           class="form-control @error('sale_price') is-invalid @enderror"
                                           placeholder="0,00">
                                </div>
                                @error('sale_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Margem de Lucro</label>
                                <div class="input-group">
                                    <input type="text" id="margin-display" class="form-control" readonly placeholder="—">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- COLUNA LATERAL --}}
            <div class="col-lg-4">

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Estoque</h3></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label">Estoque Atual</label>
                                <input type="number" name="stock_current" min="0"
                                       value="{{ old('stock_current', 0) }}"
                                       class="form-control @error('stock_current') is-invalid @enderror">
                                @error('stock_current')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Estoque Mínimo</label>
                                <input type="number" name="stock_minimum" min="0"
                                       value="{{ old('stock_minimum', 0) }}"
                                       class="form-control @error('stock_minimum') is-invalid @enderror">
                                @error('stock_minimum')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Imagem do Produto</h3></div>
                    <div class="card-body">
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/gif">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-hint">Formatos aceitos: JPG, PNG, GIF (máx. 2MB)</div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Configurações</h3></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="controls_stock" value="1"
                                       {{ old('controls_stock', '1') == '1' ? 'checked' : '' }}>
                                <span class="form-check-label">Controla Estoque</span>
                            </label>
                        </div>
                        <div>
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="toggle-status">
                                <span class="form-check-label">Ativo</span>
                            </label>
                            <input type="hidden" name="status" id="status-value"
                                   value="{{ old('status', 'Ativo') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2z"/>
                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M14 4l0 4l-6 0l0 -4"/>
                        </svg>
                        Salvar Produto
                    </button>
                    <a href="{{ route('comercial.produtos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>

            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    // Margin calculator
    const cost = document.querySelector('[name="cost_price"]');
    const sale = document.querySelector('[name="sale_price"]');
    const margin = document.getElementById('margin-display');
    function updateMargin() {
        const c = parseFloat(cost.value), s = parseFloat(sale.value);
        if (c > 0 && s >= 0) {
            margin.value = ((s - c) / c * 100).toFixed(2).replace('.', ',');
        } else {
            margin.value = '';
        }
    }
    cost.addEventListener('input', updateMargin);
    sale.addEventListener('input', updateMargin);

    // Status toggle
    const toggle = document.getElementById('toggle-status');
    const statusVal = document.getElementById('status-value');
    toggle.checked = statusVal.value === 'Ativo';
    toggle.addEventListener('change', () => { statusVal.value = toggle.checked ? 'Ativo' : 'Inativo'; });
    </script>
    @endpush

</x-app-layout>
