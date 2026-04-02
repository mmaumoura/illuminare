<x-app-layout>
    {{-- <x-slot name="header">Gerenciar Unidades</x-slot> --}}

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Gerenciar Unidades</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('gestao.clinicas.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Nova Unidade
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
            <div class="d-flex">
                <div class="text-secondary">
                    Exibir
                    <div class="mx-2 d-inline-block">
                        <span>{{ $clinics->perPage() }}</span>
                    </div>
                    resultados por página
                </div>
                <div class="ms-auto text-secondary">
                    Pesquisar:
                    <div class="ms-2 d-inline-block">
                        <form method="GET" action="{{ route('gestao.clinicas.index') }}">
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
                        <th>CNPJ</th>
                        <th>Cidade/UF</th>
                        <th>Status</th>
                        <th>Usuários</th>
                        <th>Pacientes</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clinics as $clinic)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $clinic->name }}</div>
                            @if($clinic->email)
                            <div class="text-muted small">{{ $clinic->email }}</div>
                            @endif
                        </td>
                        <td class="text-muted">{{ $clinic->cnpj ?? '—' }}</td>
                        <td class="text-muted">
                            {{ $clinic->city && $clinic->state ? $clinic->city.'/'.$clinic->state : '—' }}
                        </td>
                        <td>
                            @php
                                $color = match($clinic->status) {
                                    'Ativa'    => 'success',
                                    'Inativa'  => 'secondary',
                                    'Suspensa' => 'warning',
                                    default    => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $color }}-lt text-{{ $color }}">{{ $clinic->status ?? 'Ativa' }}</span>
                        </td>
                        <td>—</td>
                        <td>{{ $clinic->patients_count }}</td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('gestao.clinicas.show', $clinic) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Visualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                    </svg>
                                </a>
                                <a href="{{ route('gestao.clinicas.edit', $clinic) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('gestao.clinicas.destroy', $clinic) }}"
                                      onsubmit="return confirm('Excluir a unidade {{ addslashes($clinic->name) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <td colspan="7" class="text-center text-muted py-4">Nenhuma unidade cadastrada.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($clinics->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $clinics->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
