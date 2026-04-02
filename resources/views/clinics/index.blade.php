<x-app-layout>
    <x-slot name="header">Clínicas</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted">
            {{ $clinics->total() }} unidade{{ $clinics->total() !== 1 ? 's' : '' }} cadastrada{{ $clinics->total() !== 1 ? 's' : '' }}
        </div>
        @if(auth()->user()->hasAnyRole(['administrador', 'gestor']))
        <a href="{{ route('gestao.clinicas.create') }}" class="btn btn-primary btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Nova Unidade
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-hover">
                <thead>
                    <tr>
                        <th>Unidade</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Cidade</th>
                        <th class="text-center">Pacientes</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clinics as $clinic)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="avatar avatar-sm rounded text-white"
                                      style="background-color: var(--tblr-primary);">
                                    {{ mb_strtoupper(mb_substr($clinic->name, 0, 2)) }}
                                </span>
                                <span class="fw-medium">{{ $clinic->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $clinic->phone ?? '—' }}</td>
                        <td class="text-muted">{{ $clinic->email ?? '—' }}</td>
                        <td class="text-muted">
                            @if($clinic->city && $clinic->state)
                                {{ $clinic->city }}/{{ $clinic->state }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary-lt text-primary">{{ $clinic->patients_count }}</span>
                        </td>
                        <td class="text-center">
                            @if($clinic->active)
                                <span class="badge bg-success-lt text-success">Ativa</span>
                            @else
                                <span class="badge bg-danger-lt text-danger">Inativa</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('gestao.clinicas.edit', $clinic) }}"
                                   class="btn btn-sm btn-outline-primary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                    </svg>
                                </a>
                                <form method="POST"
                                      action="{{ route('gestao.clinicas.destroy', $clinic) }}"
                                      onsubmit="return confirm('Excluir a unidade \'{{ addslashes($clinic->name) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12M9 7V4a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted mb-3">Nenhuma unidade cadastrada ainda.</div>
                            <a href="{{ route('gestao.clinicas.create') }}" class="btn btn-primary btn-sm">
                                Cadastrar primeira unidade
                            </a>
                        </td>
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
