<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Clientes CRM</h2>
            <p class="text-muted mt-1">Gerencie os clientes e contatos do CRM.</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.clientes.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Cliente
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
            <div class="d-flex align-items-center gap-3">
                <div class="text-secondary">
                    Exibindo <strong>{{ $clients->count() }}</strong> de <strong>{{ $clients->total() }}</strong> registros
                </div>
                <div class="ms-auto d-flex gap-2">
                    <form method="GET" action="{{ route('crm.clientes.index') }}" class="d-flex gap-2">
                        <select name="tipo" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Todos os tipos</option>
                            <option value="cliente" {{ request('tipo') === 'cliente' ? 'selected' : '' }}>Cliente</option>
                            <option value="lead"    {{ request('tipo') === 'lead'    ? 'selected' : '' }}>Lead</option>
                        </select>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control form-control-sm" placeholder="Buscar por nome, e-mail, CPF…">
                        <button type="submit" class="btn btn-sm btn-secondary">Buscar</button>
                        @if(request('search') || request('tipo'))
                        <a href="{{ route('crm.clientes.index') }}" class="btn btn-sm btn-outline-secondary">Limpar</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Cidade / UF</th>
                        <th>Unidade</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td>
                            <a href="{{ route('crm.clientes.show', $client) }}" class="fw-semibold text-reset">
                                {{ $client->nome_completo }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-{{ $client->tipo_color }}-lt text-{{ $client->tipo_color }}">
                                {{ $client->tipo_label }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $client->cpf_formatado ?? '—' }}</td>
                        <td class="text-muted text-nowrap">{{ $client->telefone }}</td>
                        <td class="text-muted">{{ $client->email ?? '—' }}</td>
                        <td class="text-muted">
                            @if($client->cidade)
                                {{ $client->cidade }} / {{ $client->estado }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-muted">
                            @if($client->clinic)
                                <span class="badge bg-secondary-lt">{{ $client->clinic->name }}</span>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('crm.clientes.show', $client) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                    </svg>
                                </a>
                                <a href="{{ route('crm.clientes.edit', $client) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                        <path d="M16 5l3 3"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('crm.clientes.destroy', $client) }}"
                                      onsubmit="return confirm('Remover {{ addslashes($client->nome_completo) }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <line x1="4" y1="7" x2="20" y2="7"/><line x1="10" y1="11" x2="10" y2="17"/>
                                            <line x1="14" y1="11" x2="14" y2="17"/>
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
                        <td colspan="8" class="text-center text-muted py-4">Nenhum cliente encontrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($clients->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $clients->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
