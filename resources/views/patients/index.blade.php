<x-app-layout>
    <x-slot name="header">Pacientes</x-slot>

    <div class="row mb-3">
        <div class="col">
            <form method="GET" action="{{ route('operacional.pacientes.index') }}" class="row g-2">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="10" cy="10" r="7"/><path d="M21 21l-6 -6"/>
                            </svg>
                        </span>
                        <input type="text" name="search" class="form-control"
                               placeholder="Buscar por nome, CPF ou e-mail..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-12 col-md-3">
                    <select name="clinic_id" class="form-select">
                        <option value="">Todas as unidades</option>
                        @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ request('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                {{ $clinic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                    @if(request('search') || request('clinic_id'))
                        <a href="{{ route('operacional.pacientes.index') }}" class="btn btn-secondary ms-1">Limpar</a>
                    @endif
                </div>
            </form>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.pacientes.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Paciente
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible mb-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gerenciar Pacientes</h3>
            <div class="card-options">
                <span class="badge bg-secondary">{{ $patients->total() }} paciente(s)</span>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Nome Completo</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Unidade</th>
                        <th class="text-center">Documentos</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="avatar avatar-sm rounded"
                                      style="background-color:var(--tblr-primary); color:#fff; font-weight:700; font-size:.75rem;">
                                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                                </span>
                                <div>
                                    <a href="{{ route('operacional.pacientes.show', $patient) }}" class="fw-semibold text-reset">
                                        {{ $patient->name }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted">{{ $patient->cpf ?? '—' }}</td>
                        <td class="text-muted">{{ $patient->email ?? '—' }}</td>
                        <td>{{ $patient->phone ?? '—' }}</td>
                        <td>
                            @if($patient->clinic)
                                <span class="badge badge-outline text-secondary">{{ $patient->clinic->name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary-lt text-secondary">0</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('operacional.pacientes.show', $patient) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Visualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2"/>
                                        <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                    </svg>
                                </a>
                                <a href="{{ route('operacional.pacientes.edit', $patient) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('operacional.pacientes.destroy', $patient) }}"
                                      onsubmit="return confirm('Excluir o paciente {{ addslashes($patient->name) }}?')">
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
                        <td colspan="7" class="text-center py-5 text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2" width="40" height="40" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                            </svg>
                            <p class="mb-1">Nenhum paciente encontrado.</p>
                            <a href="{{ route('operacional.pacientes.create') }}" class="btn btn-primary btn-sm mt-2">
                                Cadastrar primeiro paciente
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($patients->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $patients->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
