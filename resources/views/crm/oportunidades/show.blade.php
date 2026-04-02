<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $oportunidade->titulo }}</h2>
            <p class="text-muted mt-1">
                <span class="badge bg-{{ $oportunidade->estagio_color }}-lt text-{{ $oportunidade->estagio_color }}">{{ $oportunidade->estagio_label }}</span>
                <span class="ms-1">{{ $oportunidade->probabilidade }}% de probabilidade</span>
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.oportunidades.edit', $oportunidade) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('crm.oportunidades.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
                Voltar
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-3">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Detalhes</h3></div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-5 text-muted">Valor</dt>
                        <dd class="col-7">{{ $oportunidade->valor ? 'R$ ' . number_format($oportunidade->valor, 2, ',', '.') : '—' }}</dd>
                        <dt class="col-5 text-muted">Probabilidade</dt>
                        <dd class="col-7">
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px;">
                                    <div class="progress-bar bg-{{ $oportunidade->estagio_color }}" style="width:{{ $oportunidade->probabilidade }}%"></div>
                                </div>
                                {{ $oportunidade->probabilidade }}%
                            </div>
                        </dd>
                        <dt class="col-5 text-muted">Contato</dt>
                        <dd class="col-7">{{ $oportunidade->contact_name }}</dd>
                        <dt class="col-5 text-muted">Responsável</dt>
                        <dd class="col-7">{{ $oportunidade->user->name ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Unidade</dt>
                        <dd class="col-7">{{ $oportunidade->clinic->name ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Prev. Fechamento</dt>
                        <dd class="col-7">{{ $oportunidade->data_fechamento_previsto?->format('d/m/Y') ?? '—' }}</dd>
                        <dt class="col-5 text-muted">Fechamento Real</dt>
                        <dd class="col-7">{{ $oportunidade->data_fechamento_real?->format('d/m/Y') ?? '—' }}</dd>
                    </dl>
                    @if($oportunidade->descricao)
                    <hr>
                    <div class="text-muted small fw-semibold mb-1">Descrição</div>
                    <p class="mb-0">{{ $oportunidade->descricao }}</p>
                    @endif
                    @if($oportunidade->motivo_perda)
                    <hr>
                    <div class="text-muted small fw-semibold mb-1">Motivo da Perda</div>
                    <p class="mb-0 text-danger">{{ $oportunidade->motivo_perda }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tarefas</h3>
                    <div class="card-options">
                        <a href="{{ route('crm.tarefas.create') }}?taskable_type={{ urlencode(\App\Models\Opportunity::class) }}&taskable_id={{ $oportunidade->id }}" class="btn btn-sm btn-primary">+ Nova</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead><tr><th>Título</th><th>Tipo</th><th>Status</th><th>Vencimento</th></tr></thead>
                        <tbody>
                            @forelse($oportunidade->tasks as $task)
                            <tr class="{{ $task->is_atrasada ? 'table-danger' : '' }}">
                                <td><a href="{{ route('crm.tarefas.show', $task) }}">{{ $task->titulo }}</a></td>
                                <td class="text-muted">{{ $task->tipo_label }}</td>
                                <td><span class="badge bg-{{ $task->status_color }}-lt text-{{ $task->status_color }}">{{ $task->status_label }}</span></td>
                                <td class="text-muted">{{ $task->data_vencimento?->format('d/m/Y H:i') ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">Nenhuma tarefa.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
