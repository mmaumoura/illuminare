<x-app-layout>

    @push('styles')
    <style>
        .kanban-board { display: flex; gap: 16px; overflow-x: auto; padding-bottom: 20px; align-items: flex-start; }
        .kanban-column { flex: 0 0 270px; background: var(--tblr-bg-surface-secondary); border-radius: 8px; padding: 14px; min-height: 200px; }
        .kanban-column-header { font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; }
        .kanban-cards { min-height: 60px; }
        .kanban-card { background: var(--tblr-bg-surface); border-radius: 8px; padding: 12px 14px; margin-bottom: 10px; box-shadow: 0 1px 4px rgba(0,0,0,.08); cursor: grab; border-left: 4px solid #ccc; transition: box-shadow .15s; }
        .kanban-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.12); }
        .kanban-card:active { cursor: grabbing; }
        .kanban-card.dragging { opacity: .4; }
        .kanban-column.drag-over { background: var(--tblr-primary-lt); }
        .kanban-card.status-pendente     { border-left-color: #f59f00; }
        .kanban-card.status-em_andamento { border-left-color: #206bc4; }
        .kanban-card.status-concluida    { border-left-color: #2fb344; }
        .kanban-card.status-cancelada    { border-left-color: #d63939; }
        .card-task-title { font-weight: 600; font-size: 14px; margin-bottom: 6px; }
        .card-meta { font-size: 12px; color: var(--tblr-secondary); margin-bottom: 3px; display: flex; align-items: center; gap: 4px; }
        .kanban-empty { text-align: center; color: var(--tblr-secondary); font-size: 13px; padding: 20px 0; }
    </style>
    @endpush

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Kanban - Minhas Tarefas</h2>
            <p class="text-muted mt-1">Arraste os cartões para alterar o status</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.tarefas.index') }}" class="btn btn-outline-secondary">Lista</a>
            <a href="{{ route('crm.tarefas.create') }}" class="btn btn-primary">+ Nova Tarefa</a>
        </div>
    </div>

    <div id="kanban-toast" class="alert alert-success" style="display:none; position:fixed; top:20px; right:20px; z-index:9999; min-width:280px;">
        <span id="kanban-toast-msg"></span>
    </div>

    @php
        $columns = [
            'pendente'     => ['label' => 'Pendente',     'color' => 'yellow'],
            'em_andamento' => ['label' => 'Em Andamento', 'color' => 'blue'],
            'concluida'    => ['label' => 'Concluída',    'color' => 'green'],
            'cancelada'    => ['label' => 'Cancelada',    'color' => 'red'],
        ];
    @endphp

    <div class="kanban-board">
        @foreach($columns as $status => $col)
        @php $colTasks = $tasks->get($status, collect()); @endphp
        <div class="kanban-column" data-status="{{ $status }}">
            <div class="kanban-column-header">
                <span class="badge bg-{{ $col['color'] }}-lt text-{{ $col['color'] }}">{{ $col['label'] }}</span>
                <span class="badge bg-secondary-lt count-badge">{{ $colTasks->count() }}</span>
            </div>
            <div class="kanban-cards" data-status="{{ $status }}">
                @forelse($colTasks as $tarefa)
                <div class="kanban-card status-{{ $status }}" draggable="true" data-task-id="{{ $tarefa->id }}">
                    <div class="card-task-title">
                        <a href="{{ route('crm.tarefas.show', $tarefa) }}" class="text-reset">{{ $tarefa->titulo }}</a>
                    </div>

                    <div class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/><path d="M4 12m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z"/></svg>
                        {{ $tarefa->tipo_label }}
                        &nbsp;·&nbsp;
                        <span class="badge badge-sm bg-{{ $tarefa->prioridade_color }}-lt text-{{ $tarefa->prioridade_color }}" style="font-size:10px">{{ $tarefa->prioridade_label }}</span>
                    </div>

                    @if($tarefa->user)
                    <div class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4"/><path d="M5.5 21a8.5 8.5 0 0 1 13 0"/></svg>
                        {{ $tarefa->user->name }}
                    </div>
                    @endif

                    @if($tarefa->data_vencimento)
                    <div class="card-meta {{ $tarefa->is_atrasada ? 'text-danger' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M16 3l0 4"/><path d="M8 3l0 4"/><path d="M4 11l16 0"/></svg>
                        {{ $tarefa->data_vencimento->format('d/m/Y H:i') }}
                        @if($tarefa->is_atrasada) <strong>(Atrasada)</strong> @endif
                    </div>
                    @endif

                    <div class="mt-2 d-flex gap-1">
                        <a href="{{ route('crm.tarefas.show', $tarefa) }}" class="btn btn-sm btn-ghost-secondary py-0 px-2">Ver</a>
                        <a href="{{ route('crm.tarefas.edit', $tarefa) }}" class="btn btn-sm btn-ghost-secondary py-0 px-2">Editar</a>
                    </div>
                </div>
                @empty
                <div class="kanban-empty">Nenhuma tarefa</div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

    @push('scripts')
    <script>
    let draggedCard = null;

    document.querySelectorAll('.kanban-card').forEach(card => {
        card.addEventListener('dragstart', () => {
            draggedCard = card;
            setTimeout(() => card.classList.add('dragging'), 0);
        });
        card.addEventListener('dragend', () => {
            card.classList.remove('dragging');
            document.querySelectorAll('.kanban-column').forEach(c => c.classList.remove('drag-over'));
        });
    });

    document.querySelectorAll('.kanban-column').forEach(col => {
        col.addEventListener('dragover', e => { e.preventDefault(); col.classList.add('drag-over'); });
        col.addEventListener('dragleave', () => col.classList.remove('drag-over'));
        col.addEventListener('drop', e => {
            e.preventDefault();
            col.classList.remove('drag-over');
            if (!draggedCard) return;

            const newStatus = col.dataset.status;
            const taskId    = draggedCard.dataset.taskId;

            // Remove old status class, add new
            const oldClass = [...draggedCard.classList].find(c => c.startsWith('status-'));
            if (oldClass) draggedCard.classList.remove(oldClass);
            draggedCard.classList.add('status-' + newStatus);

            // Move card to new column
            const targetContainer = col.querySelector('.kanban-cards');
            const emptyMsg = targetContainer.querySelector('.kanban-empty');
            if (emptyMsg) emptyMsg.remove();
            targetContainer.appendChild(draggedCard);

            // Remove card from old column; show empty message if needed
            document.querySelectorAll('.kanban-cards').forEach(c => {
                if (!c.querySelector('.kanban-card')) {
                    if (!c.querySelector('.kanban-empty')) {
                        const div = document.createElement('div');
                        div.className = 'kanban-empty';
                        div.textContent = 'Nenhuma tarefa';
                        c.appendChild(div);
                    }
                }
            });

            // Update counts
            document.querySelectorAll('.kanban-column').forEach(c => {
                c.querySelector('.count-badge').textContent =
                    c.querySelector('.kanban-cards').querySelectorAll('.kanban-card').length;
            });

            // Persist via AJAX
            fetch('{{ url("crm/tarefas") }}/' + taskId + '/status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newStatus }),
            })
            .then(r => r.json())
            .then(res => {
                const toast = document.getElementById('kanban-toast');
                document.getElementById('kanban-toast-msg').textContent = res.message;
                toast.style.display = 'block';
                setTimeout(() => toast.style.display = 'none', 2500);
            });
        });
    });
    </script>
    @endpush

</x-app-layout>
