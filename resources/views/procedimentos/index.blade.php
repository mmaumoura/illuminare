<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Gerenciar Procedimentos</h2>
            <p class="text-muted mt-1">Gerencie os procedimentos e tratamentos oferecidos</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('gestao.procedimentos.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Procedimento
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
                        <span>{{ $procedures->perPage() }}</span>
                    </div>
                    resultados por página
                </div>
                <div class="ms-auto text-secondary">
                    Pesquisar:
                    <div class="ms-2 d-inline-block">
                        <form method="GET" action="{{ route('gestao.procedimentos.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control form-control-sm" placeholder="Buscar registros">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Duração</th>
                        <th>Status</th>
                        <th>Unidades</th>
                        <th>Docs</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($procedures as $procedure)
                    @php
                        $clinicNames = $procedure->clinics->pluck('name');
                        $displayClinic = $clinicNames->first();
                        $extraCount   = $clinicNames->count() - 1;
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $procedure->name }}</div>
                        </td>
                        <td>
                            <span class="badge bg-blue-lt">{{ $procedure->category }}</span>
                        </td>
                        <td class="text-muted">
                            R$ {{ number_format($procedure->price, 2, ',', '.') }}
                        </td>
                        <td class="text-muted">
                            {{ $procedure->duration_label }}
                        </td>
                        <td>
                            @php $statusColor = $procedure->status === 'Ativo' ? 'success' : 'secondary'; @endphp
                            <span class="badge bg-{{ $statusColor }}-lt text-{{ $statusColor }}">
                                {{ $procedure->status }}
                            </span>
                        </td>
                        <td class="text-muted">
                            @if($clinicNames->isEmpty())
                                <span class="text-muted">—</span>
                            @else
                                {{ $displayClinic }}
                                @if($extraCount > 0)
                                <span class="badge bg-secondary ms-1" title="{{ $clinicNames->skip(1)->join(', ') }}">+{{ $extraCount }} mais</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-muted">0</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('gestao.procedimentos.show', $procedure) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                    </svg>
                                </a>
                                <a href="{{ route('gestao.procedimentos.edit', $procedure) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('gestao.procedimentos.destroy', $procedure) }}"
                                      onsubmit="return confirm('Excluir este procedimento?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Nenhum procedimento encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($procedures->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $procedures->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
