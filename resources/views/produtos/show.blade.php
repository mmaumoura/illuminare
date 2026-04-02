<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Detalhes do Produto</h2>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('comercial.produtos.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
            <a href="{{ route('comercial.produtos.edit', $product) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                </svg>
                Editar
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-3">

        {{-- COLUNA PRINCIPAL --}}
        <div class="col-lg-8">

            {{-- HEADER CARD --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center gap-3">
                        <div class="col-auto">
                            @if($product->image_path)
                            <img src="{{ Storage::url($product->image_path) }}" class="rounded"
                                 style="width:80px;height:80px;object-fit:cover;">
                            @else
                            <span class="avatar avatar-xl rounded bg-blue-lt text-blue"
                                  style="font-size:2rem">
                                {{ strtoupper(substr($product->name, 0, 1)) }}
                            </span>
                            @endif
                        </div>
                        <div class="col">
                            <h2 class="mb-1">{{ $product->name }}</h2>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="text-muted">Código: <strong>{{ $product->code ?? '—' }}</strong></span>
                                @if($product->category)
                                <span class="text-muted">Categoria: <strong>{{ $product->category }}</strong></span>
                                @endif
                                @if($product->brand)
                                <span class="text-muted">Marca: <strong>{{ $product->brand }}</strong></span>
                                @endif
                            </div>
                            <div class="mt-2 d-flex flex-wrap gap-2 align-items-center">
                                @php $sColor = $product->status === 'Ativo' ? 'success' : 'secondary'; @endphp
                                <span class="badge bg-{{ $sColor }}-lt text-{{ $sColor }}">{{ $product->status }}</span>
                                @if($product->controls_stock)
                                <span class="badge bg-blue-lt text-blue">Controla Estoque</span>
                                @endif
                            </div>
                            @if($product->clinics->isNotEmpty())
                            <div class="mt-2">
                                <span class="text-muted small">Unidades: </span>
                                @foreach($product->clinics as $clinic)
                                <span class="badge bg-secondary-lt text-secondary me-1">{{ $clinic->name }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- PREÇOS --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Preços</h3>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Preço de Custo</div>
                            <div class="fs-3 fw-bold">
                                {{ $product->cost_price ? 'R$ ' . number_format($product->cost_price, 2, ',', '.') : '—' }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Preço de Venda</div>
                            <div class="fs-3 fw-bold text-primary">
                                R$ {{ number_format($product->sale_price, 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Margem de Lucro</div>
                            <div class="fs-3 fw-bold {{ $product->profit_margin >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $product->profit_margin !== null ? number_format($product->profit_margin, 2, ',', '.') . '%' : '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ESTOQUE --}}
            @if($product->controls_stock)
            <div class="card mb-3">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title mb-0">Estoque</h3>
                    <a href="{{ route('comercial.estoque.create', ['product_id' => $product->id]) }}"
                       class="btn btn-sm btn-primary">
                        + Nova Movimentação
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-3 text-center mb-3">
                        <div class="col-6">
                            <div class="text-muted small mb-1">Estoque Atual</div>
                            <div class="fs-2 fw-bold {{ $product->is_low_stock ? 'text-danger' : 'text-success' }}">
                                {{ $product->stock_current }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted small mb-1">Estoque Mínimo</div>
                            <div class="fs-2 fw-bold">{{ $product->stock_minimum }}</div>
                        </div>
                    </div>
                    @if($product->is_low_stock)
                    <div class="alert alert-warning mb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 9v4"/><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"/>
                            <path d="M12 16h.01"/>
                        </svg>
                        Estoque baixo! Considere reabastecer.
                    </div>
                    @endif
                </div>
                @if($product->stockMovements->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-sm">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Tipo</th>
                                <th>Qtd</th>
                                <th>Antes → Depois</th>
                                <th>Motivo</th>
                                <th>Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->stockMovements->take(10) as $m)
                            <tr>
                                <td class="text-muted small">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @php $tColor = match($m->type) { 'Entrada' => 'success', 'Saída' => 'danger', default => 'warning' }; @endphp
                                    <span class="badge bg-{{ $tColor }}-lt text-{{ $tColor }}">{{ $m->type }}</span>
                                </td>
                                <td class="{{ $m->quantity >= 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                                    {{ $m->quantity >= 0 ? '+' : '' }}{{ $m->quantity }}
                                </td>
                                <td class="text-muted small">{{ $m->stock_before }} → {{ $m->stock_after }}</td>
                                <td class="text-muted small">{{ $m->reason }}</td>
                                <td class="text-muted small">{{ $m->user->name ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            @endif

            {{-- DESCRIÇÃO --}}
            @if($product->description)
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Descrição</h3></div>
                <div class="card-body">
                    <p class="mb-0" style="white-space:pre-line">{{ $product->description }}</p>
                </div>
            </div>
            @endif

        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">

            {{-- AÇÕES --}}
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Ações Rápidas</h3></div>
                <div class="card-body d-flex flex-column gap-2">
                    <a href="{{ route('comercial.produtos.edit', $product) }}" class="btn btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                        </svg>
                        Editar Produto
                    </a>
                    @if($product->controls_stock)
                    <a href="{{ route('comercial.estoque.create', ['product_id' => $product->id]) }}"
                       class="btn btn-outline-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3"/>
                            <line x1="12" y1="12" x2="20" y2="7.5"/><line x1="12" y1="12" x2="12" y2="21"/>
                            <line x1="12" y1="12" x2="4" y2="7.5"/>
                        </svg>
                        Nova Movimentação
                    </a>
                    @endif
                    <form method="POST" action="{{ route('comercial.produtos.destroy', $product) }}"
                          onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Excluir Produto
                        </button>
                    </form>
                </div>
            </div>

            {{-- INFORMAÇÕES --}}
            <div class="card">
                <div class="card-header"><h3 class="card-title">Informações</h3></div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Cadastrado em</div>
                            <div class="datagrid-content">{{ $product->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Última atualização</div>
                            <div class="datagrid-content">{{ $product->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                        @if($product->supplier)
                        <div class="datagrid-item">
                            <div class="datagrid-title">Fornecedor</div>
                            <div class="datagrid-content">{{ $product->supplier }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
