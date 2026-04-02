<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $cliente->nome_completo }}</h2>
            <p class="text-muted mt-1">
                <span class="badge bg-{{ $cliente->tipo_color }}-lt text-{{ $cliente->tipo_color }}">
                    {{ $cliente->tipo_label }}
                </span>
                @if($cliente->clinic)
                <span class="ms-1 text-muted">— {{ $cliente->clinic->name }}</span>
                @endif
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.clientes.edit', $cliente) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('crm.clientes.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/>
                    <path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
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
        {{-- Dados do cliente --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Dados Pessoais</h3></div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-5 text-muted">Telefone</dt>
                        <dd class="col-7">{{ $cliente->telefone }}</dd>
                        <dt class="col-5 text-muted">E-mail</dt>
                        <dd class="col-7">{{ $cliente->email ?? '—' }}</dd>
                        <dt class="col-5 text-muted">CPF</dt>
                        <dd class="col-7">{{ $cliente->cpf_formatado ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Data de Nascimento</dt>
                        <dd class="col-7">{{ $cliente->data_nascimento?->format('d/m/Y') ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Endereço</dt>
                        <dd class="col-7">{{ $cliente->endereco_completo ?: '—' }}</dd>
                        <dt class="col-5 text-muted">Observações</dt>
                        <dd class="col-7">{{ $cliente->observacoes ?? '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        {{-- Resumo: oportunidades e tarefas --}}
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Oportunidades</h3>
                    <div class="card-options">
                        <a href="{{ route('crm.oportunidades.create') }}?crm_client_id={{ $cliente->id }}" class="btn btn-sm btn-primary">+ Nova</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr><th>Título</th><th>Estágio</th><th>Valor</th></tr>
                        </thead>
                        <tbody>
                            @forelse($cliente->opportunities as $opp)
                            <tr>
                                <td><a href="{{ route('crm.oportunidades.show', $opp) }}">{{ $opp->titulo }}</a></td>
                                <td><span class="badge bg-{{ $opp->estagio_color }}-lt text-{{ $opp->estagio_color }}">{{ $opp->estagio_label }}</span></td>
                                <td class="text-muted">{{ $opp->valor ? 'R$ ' . number_format($opp->valor, 2, ',', '.') : '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Nenhuma oportunidade.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tarefas</h3>
                    <div class="card-options">
                        <a href="{{ route('crm.tarefas.create') }}?taskable_type={{ urlencode(\App\Models\CrmClient::class) }}&taskable_id={{ $cliente->id }}" class="btn btn-sm btn-primary">+ Nova</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr><th>Título</th><th>Status</th><th>Vencimento</th></tr>
                        </thead>
                        <tbody>
                            @forelse($cliente->tasks as $task)
                            <tr>
                                <td><a href="{{ route('crm.tarefas.show', $task) }}">{{ $task->titulo }}</a></td>
                                <td><span class="badge bg-{{ $task->status_color }}-lt text-{{ $task->status_color }}">{{ $task->status_label }}</span></td>
                                <td class="text-muted {{ $task->is_atrasada ? 'text-danger' : '' }}">
                                    {{ $task->data_vencimento?->format('d/m/Y H:i') ?? '—' }}
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted py-3">Nenhuma tarefa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
