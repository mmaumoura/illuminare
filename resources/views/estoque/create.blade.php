<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Nova Movimentação de Estoque</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('comercial.estoque.index') }}" class="btn btn-secondary">
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

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Dados da Movimentação</h3></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comercial.estoque.store') }}" id="form-mov">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label required">Produto</label>
                                <select name="product_id" id="product-select"
                                        class="form-select @error('product_id') is-invalid @enderror">
                                    <option value="">Selecione...</option>
                                    @foreach($products as $p)
                                    <option value="{{ $p->id }}"
                                            data-stock="{{ $p->stock_current }}"
                                            data-clinics="{{ $p->clinics->pluck('id')->implode(',') }}"
                                            {{ old('product_id', $selectedProduct?->id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                        @if($p->code) ({{ $p->code }}) @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Tipo de Movimentação</label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror">
                                    <option value="">Selecione...</option>
                                    @foreach(['Entrada', 'Saída', 'Ajuste'] as $t)
                                    <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Quantidade</label>
                                <input type="number" name="quantity" min="1"
                                       value="{{ old('quantity', 1) }}"
                                       class="form-control @error('quantity') is-invalid @enderror">
                                @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Valor Unitário</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="unit_value" step="0.01" min="0"
                                           value="{{ old('unit_value') }}"
                                           class="form-control @error('unit_value') is-invalid @enderror"
                                           placeholder="0,00">
                                </div>
                                @error('unit_value')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Unidade</label>
                                @if($userClinicId && $clinics->isNotEmpty())
                                    <input type="hidden" name="clinic_id" value="{{ $userClinicId }}">
                                    <p class="form-control-plaintext fw-semibold mb-0">{{ $clinics->first()->name }}</p>
                                @else
                                    <select name="clinic_id" id="clinic-select"
                                            class="form-select @error('clinic_id') is-invalid @enderror">
                                        <option value="">Selecione...</option>
                                        @foreach($clinics as $clinic)
                                        <option value="{{ $clinic->id }}"
                                                data-clinic-id="{{ $clinic->id }}"
                                                {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                            {{ $clinic->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('clinic_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-hint" id="clinic-hint">Apenas unidades vinculadas ao produto selecionado</div>
                                @endif
                            </div>

                            <div class="col-12">
                                <label class="form-label required">Motivo</label>
                                <input type="text" name="reason" value="{{ old('reason') }}"
                                       class="form-control @error('reason') is-invalid @enderror"
                                       placeholder="Ex: Compra de fornecedor, Venda, Perda, etc.">
                                @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Observações</label>
                                <textarea name="notes" rows="3" class="form-control"
                                          placeholder="Informações adicionais…">{{ old('notes') }}</textarea>
                            </div>

                            <div class="col-12 d-flex justify-content-between">
                                <a href="{{ route('comercial.estoque.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Registrar Movimentação</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- PAINEL LATERAL --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informações do Produto</h3></div>
                <div class="card-body">
                    <div id="stock-info" class="text-muted text-center py-3">
                        Selecione um produto para ver o estoque atual.
                    </div>
                    <div id="stock-details" class="d-none">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Estoque Atual</div>
                                <div class="datagrid-content fw-bold fs-4" id="stock-current">—</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    $(function () {
        var $productSelect = $('#product-select');
        var $clinicSelect  = $('#clinic-select');
        var $stockInfo     = $('#stock-info');
        var $stockDetails  = $('#stock-details');
        var $stockCurrent  = $('#stock-current');

        // Cache all clinic options (excluding the empty placeholder)
        var allClinicOptions = $clinicSelect.find('option[data-clinic-id]').clone();

        // Run on initial load (product may already be pre-selected)
        filterClinicsForProduct($productSelect.val(), $productSelect.find(':selected'));

        // Select2 fires jQuery 'change' — this handler works with both native and Select2
        $productSelect.on('change', function () {
            filterClinicsForProduct($(this).val(), $(this).find(':selected'));
        });

        function filterClinicsForProduct(productId, $opt) {
            // Remove all clinic options (keep placeholder)
            $clinicSelect.find('option[data-clinic-id]').remove();

            if (!productId) {
                $clinicSelect.append(allClinicOptions.clone());
                $clinicSelect.val('').trigger('change.select2');
                $stockInfo.removeClass('d-none');
                $stockDetails.addClass('d-none');
                return;
            }

            var allowedIds = ($opt.attr('data-clinics') || '').split(',').filter(Boolean);

            allClinicOptions.each(function () {
                var id = $(this).attr('data-clinic-id');
                if (allowedIds.indexOf(id) !== -1) {
                    $clinicSelect.append($(this).clone());
                }
            });

            // Reset if current selection is no longer valid
            var currentVal = $clinicSelect.val();
            if (currentVal && allowedIds.indexOf(currentVal) === -1) {
                $clinicSelect.val('');
            }
            $clinicSelect.trigger('change.select2');

            // Show stock panel
            var stock = $opt.attr('data-stock') || '—';
            $stockCurrent.text(stock);
            $stockInfo.addClass('d-none');
            $stockDetails.removeClass('d-none');
        }
    });
    </script>
    @endpush

</x-app-layout>
