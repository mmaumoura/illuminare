<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Editar Produto</h2>
            <p class="text-muted mt-1">{{ $product->name }}</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('comercial.produtos.show', $product) }}" class="btn btn-secondary">
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

    <form method="POST" action="{{ route('comercial.produtos.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3">
            {{-- COLUNA PRINCIPAL --}}
            <div class="col-lg-8">

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Informações Básicas</h3></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label required">Código</label>
                                <input type="text" name="code" value="{{ old('code', $product->code) }}"
                                       class="form-control @error('code') is-invalid @enderror"
                                       placeholder="Ex: 108">
                                @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label required">Nome</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                       class="form-control @error('name') is-invalid @enderror">
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
                                                   {{ in_array($clinic->id, old('clinics', $selectedClinicIds)) ? 'checked' : '' }}>
                                            <span class="form-check-label">{{ $clinic->name }}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Categoria</label>
                                <input type="text" name="category" value="{{ old('category', $product->category) }}"
                                       class="form-control" placeholder="Ex: Skincare">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Marca</label>
                                <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                                       class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fornecedor</label>
                                <input type="text" name="supplier" value="{{ old('supplier', $product->supplier) }}"
                                       class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descrição</label>
                                <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description) }}</textarea>
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
                                           value="{{ old('cost_price', $product->cost_price) }}"
                                           class="form-control @error('cost_price') is-invalid @enderror">
                                </div>
                                @error('cost_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Preço Venda</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="sale_price" step="0.01" min="0"
                                           value="{{ old('sale_price', $product->sale_price) }}"
                                           class="form-control @error('sale_price') is-invalid @enderror">
                                </div>
                                @error('sale_price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Margem de Lucro</label>
                                <div class="input-group">
                                    <input type="text" id="margin-display" class="form-control" readonly
                                           value="{{ $product->profit_margin ? number_format($product->profit_margin, 2, ',', '.') : '' }}">
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
                                       value="{{ old('stock_current', $product->stock_current) }}"
                                       class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Estoque Mínimo</label>
                                <input type="number" name="stock_minimum" min="0"
                                       value="{{ old('stock_minimum', $product->stock_minimum) }}"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="form-hint mt-2">Para registrar movimentações use <a href="{{ route('comercial.estoque.create', ['product_id' => $product->id]) }}">Nova Movimentação</a>.</div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Imagem do Produto</h3></div>
                    <div class="card-body">
                        @if($product->image_path)
                        <div class="mb-2">
                            <img src="{{ Storage::url($product->image_path) }}" class="rounded" style="max-width:100%;max-height:120px;object-fit:cover;">
                        </div>
                        @endif
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
                                       {{ old('controls_stock', $product->controls_stock) ? 'checked' : '' }}>
                                <span class="form-check-label">Controla Estoque</span>
                            </label>
                        </div>
                        <div>
                            <label class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="toggle-status"
                                       {{ old('status', $product->status) === 'Ativo' ? 'checked' : '' }}>
                                <span class="form-check-label">Ativo</span>
                            </label>
                            <input type="hidden" name="status" id="status-value"
                                   value="{{ old('status', $product->status) }}">
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
                        Salvar Alterações
                    </button>
                    <a href="{{ route('comercial.produtos.show', $product) }}" class="btn btn-secondary">Cancelar</a>
                </div>

            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    const cost = document.querySelector('[name="cost_price"]');
    const sale = document.querySelector('[name="sale_price"]');
    const margin = document.getElementById('margin-display');
    function updateMargin() {
        const c = parseFloat(cost.value), s = parseFloat(sale.value);
        margin.value = (c > 0 && s >= 0) ? ((s - c) / c * 100).toFixed(2).replace('.', ',') : '';
    }
    cost.addEventListener('input', updateMargin);
    sale.addEventListener('input', updateMargin);

    const toggle = document.getElementById('toggle-status');
    const statusVal = document.getElementById('status-value');
    toggle.addEventListener('change', () => { statusVal.value = toggle.checked ? 'Ativo' : 'Inativo'; });
    </script>
    @endpush

</x-app-layout>
