<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Gerenciar Pacientes</h2>
        </div>
        <div class="col-auto d-flex gap-2 flex-wrap">
            {{-- Exportar --}}
            <a href="{{ route('operacional.pacientes.export', request()->query()) }}"
               class="btn btn-outline-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                    <path d="M8 11h8"/><path d="M8 15h5"/>
                </svg>
                Exportar
            </a>

            {{-- Baixar Modelo --}}
            <a href="{{ route('operacional.pacientes.import-template') }}"
               class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                    <path d="M7 11l5 5l5 -5"/><path d="M12 4l0 12"/>
                </svg>
                Modelo
            </a>

            {{-- Importar --}}
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                    <path d="M7 9l5 -5l5 5"/><path d="M12 4l0 12"/>
                </svg>
                Importar
            </button>

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
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body border-bottom py-3">
            <form method="GET" action="{{ route('operacional.pacientes.index') }}" class="d-flex flex-wrap gap-2 align-items-center">
                <div class="text-secondary me-auto">
                    Total: <strong>{{ $patients->total() }}</strong> pacientes
                </div>

                <div class="input-group input-group-sm w-auto">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control" style="min-width:300px"
                           placeholder="Buscar por nome, e-mail, telefone ou CPF...">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                </div>
                @if(request('search'))
                <a href="{{ route('operacional.pacientes.index') }}" class="btn btn-sm btn-ghost-secondary">Limpar</a>
                @endif
            </form>
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
                        <th>Documentos</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>
                            <a href="{{ route('operacional.pacientes.show', $patient) }}" class="fw-semibold text-reset">
                                {{ $patient->name }}
                            </a>
                            @if($patient->birth_date)
                            <div class="text-muted small">{{ $patient->birth_date->format('d/m/Y') }}</div>
                            @endif
                        </td>
                        <td class="text-muted">{{ $patient->cpf ?? '—' }}</td>
                        <td class="text-muted">{{ $patient->email ?? '—' }}</td>
                        <td class="text-muted">{{ $patient->phone ?? '—' }}</td>
                        <td class="text-muted">{{ $patient->clinic?->name ?? '—' }}</td>
                        <td>
                            <span class="badge bg-secondary-lt text-secondary">0</span>
                        </td>
                        <td>
                            <div class="btn-list flex-nowrap">
                                <a href="{{ route('operacional.pacientes.show', $patient) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Visualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="2"/>
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
                        <td colspan="7" class="text-center text-muted py-4">Nenhum paciente encontrado.</td>
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

    {{-- Modal Importar --}}
    <div class="modal modal-blur fade" id="importModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Importar Pacientes (CSV)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('operacional.pacientes.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted small mb-3">
                            Faça o upload de um arquivo CSV gerado a partir do modelo.
                            Campos obrigatórios: <strong>Nome</strong> e <strong>Telefone</strong>.
                            @if(!auth()->user()->clinicScope())
                            Para administradores, a coluna <strong>Unidade</strong> também é obrigatória.
                            @endif
                        </p>
                        <div class="mb-2">
                            <label class="form-label required">Arquivo CSV</label>
                            <input type="file" name="file"
                                   class="form-control @error('file') is-invalid @enderror"
                                   accept=".csv,.txt" required>
                            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-hint">
                            <a href="{{ route('operacional.pacientes.import-template') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                                    <path d="M7 11l5 5l5 -5"/><path d="M12 4l0 12"/>
                                </svg>
                                Baixar modelo de importação
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                                <path d="M7 9l5 -5l5 5"/><path d="M12 4l0 12"/>
                            </svg>
                            Importar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
