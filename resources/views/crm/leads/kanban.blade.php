<x-app-layout>

    @push('styles')
    <style>
        .kanban-board { display: flex; gap: 16px; overflow-x: auto; padding-bottom: 20px; align-items: flex-start; }
        .kanban-column { flex: 0 0 260px; background: var(--tblr-bg-surface-secondary); border-radius: 8px; padding: 14px; min-height: 200px; }
        .kanban-column-header { font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; }
        .kanban-cards { min-height: 60px; }
        .kanban-card { background: var(--tblr-bg-surface); border-radius: 8px; padding: 14px; margin-bottom: 10px; box-shadow: 0 1px 4px rgba(0,0,0,.08); cursor: grab; border-left: 4px solid #ccc; transition: box-shadow .15s; }
        .kanban-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.12); }
        .kanban-card:active { cursor: grabbing; }
        .kanban-card.dragging { opacity: .4; }
        .kanban-column.drag-over { background: var(--tblr-primary-lt); }
        .kanban-card.status-novo        { border-left-color: #206bc4; }
        .kanban-card.status-contatado   { border-left-color: #4299e1; }
        .kanban-card.status-qualificado { border-left-color: #f59f00; }
        .kanban-card.status-convertido  { border-left-color: #2fb344; }
        .kanban-card.status-perdido     { border-left-color: #d63939; }
        .card-lead-name { font-weight: 600; font-size: 14px; margin-bottom: 6px; }
        .card-meta { font-size: 12px; color: var(--tblr-secondary); margin-bottom: 3px; }
    </style>
    @endpush

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Kanban de Leads</h2>
            <p class="text-muted mt-1">Arraste os cards para mudar o status do lead.</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.leads.index') }}" class="btn btn-outline-secondary">Lista</a>
            <a href="{{ route('crm.leads.funnel') }}" class="btn btn-outline-secondary">Funil</a>
            <a href="{{ route('crm.leads.create') }}" class="btn btn-primary">+ Novo Lead</a>
        </div>
    </div>

    @php
        $columns = [
            'novo'        => ['label' => 'Novo',        'color' => 'blue'],
            'contatado'   => ['label' => 'Contatado',   'color' => 'azure'],
            'qualificado' => ['label' => 'Qualificado', 'color' => 'yellow'],
            'convertido'  => ['label' => 'Convertido',  'color' => 'green'],
            'perdido'     => ['label' => 'Perdido',     'color' => 'red'],
        ];
    @endphp

    <div id="kanban-toast" class="alert alert-success" style="display:none; position:fixed; top:20px; right:20px; z-index:9999; min-width:280px;">
        <span id="kanban-toast-msg"></span>
    </div>

    <div class="kanban-board">
        @foreach($columns as $status => $col)
        <div class="kanban-column" data-status="{{ $status }}">
            <div class="kanban-column-header">
                <span class="badge bg-{{ $col['color'] }}-lt text-{{ $col['color'] }}">{{ $col['label'] }}</span>
                <span class="badge bg-secondary-lt">{{ $leads->get($status, collect())->count() }}</span>
            </div>
            <div class="kanban-cards" data-status="{{ $status }}">
                @foreach($leads->get($status, collect()) as $lead)
                <div class="kanban-card status-{{ $status }}" draggable="true" data-lead-id="{{ $lead->id }}">
                    <div class="card-lead-name">{{ $lead->nome_completo }}</div>
                    @if($lead->empresa)
                    <div class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"/></svg>
                        {{ $lead->empresa }}
                    </div>
                    @endif
                    @if($lead->email)
                    <div class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2"/><polyline points="3 7 12 13 21 7"/></svg>
                        {{ $lead->email }}
                    </div>
                    @endif
                    @if($lead->telefone)
                    <div class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"/></svg>
                        {{ $lead->telefone_formatado }}
                    </div>
                    @endif
                    @if($lead->valor_estimado)
                    <div class="card-meta">
                        R$ {{ number_format($lead->valor_estimado, 2, ',', '.') }}
                    </div>
                    @endif
                    <div class="mt-2 d-flex gap-1">
                        <a href="{{ route('crm.leads.show', $lead) }}" class="btn btn-sm btn-ghost-secondary">Ver</a>
                        <a href="{{ route('crm.leads.edit', $lead) }}" class="btn btn-sm btn-ghost-secondary">Editar</a>
                    </div>
                </div>
                @endforeach
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
                const leadId = draggedCard.dataset.leadId;
                const oldClass = [...draggedCard.classList].find(c => c.startsWith('status-'));

                col.querySelector('.kanban-cards').appendChild(draggedCard);
                if (oldClass) draggedCard.classList.remove(oldClass);
                draggedCard.classList.add('status-' + newStatus);

                // Update counters
                document.querySelectorAll('.kanban-column').forEach(c => {
                    c.querySelector('.badge-secondary-lt, .badge.bg-secondary-lt').textContent =
                        c.querySelector('.kanban-cards').querySelectorAll('.kanban-card').length;
                });

                // Persist
                fetch('{{ url("crm/leads") }}/' + leadId + '/status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ status: newStatus }),
                })
                .then(r => r.json())
                .then(res => {
                    const toast = document.getElementById('kanban-toast');
                    document.getElementById('kanban-toast-msg').textContent = res.message;
                    toast.style.display = 'block';
                    setTimeout(() => toast.style.display = 'none', 3000);
                });
            });
        });
    </script>
    @endpush

</x-app-layout>
