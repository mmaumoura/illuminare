<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Movimentações de Estoque</h2>
            <p class="text-muted mt-1">Histórico de entradas, saídas e ajustes.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('comercial.estoque.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Nova Movimentação
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center">
                <div class="text-secondary">
                    Exibir
                    <div class="mx-2 d-inline-block">
                        <span>{{ $movements->perPage() }}</span>
                    </div>
                    resultados por página
                </div>
                <div class="ms-auto text-secondary d-flex align-items-center gap-2">
                    Pesquisar:
                    <form method="GET" action="{{ route('comercial.estoque.index') }}" class="d-flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control form-control-sm" placeholder="Buscar registros">
                        @if(request('search'))
                        <a href="{{ route('comercial.estoque.index') }}" class="btn btn-sm btn-outline-secondary">✕</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Produto</th>
                        <th>Tipo</th>
                        <th>Quantidade</th>
                        <th>Estoque Anterior</th>
                        <th>Estoque Atual</th>
                        <th>Motivo</th>
                        <th>Usuário</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                    <tr>
                        <td class="text-muted small">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="fw-semibold">{{ $movement->product?->name ?? '—' }}</div>
                            @if($movement->clinic)
                            <div class="text-muted small">{{ $movement->clinic->name }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $tColor = match($movement->type) {
                                    'Entrada' => 'success',
                                    'Saída'   => 'danger',
                                    default   => 'warning',
                                };
                            @endphp
                            <span class="badge bg-{{ $tColor }}-lt text-{{ $tColor }}">{{ $movement->type }}</span>
                        </td>
                        <td class="{{ $movement->quantity >= 0 ? 'text-success' : 'text-danger' }} fw-semibold">
                            {{ $movement->quantity >= 0 ? '+' : '' }}{{ $movement->quantity }}
                        </td>
                        <td class="text-muted">{{ $movement->stock_before }}</td>
                        <td class="text-muted">{{ $movement->stock_after }}</td>
                        <td class="text-muted">{{ $movement->reason }}</td>
                        <td class="text-muted">{{ $movement->user?->name ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Nenhuma movimentação registrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($movements->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $movements->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
