<x-app-layout>

    @push('styles')
    <style>
        .kanban-board { display: flex; gap: 16px; overflow-x: auto; padding-bottom: 20px; align-items: flex-start; }
        .kanban-column { flex: 0 0 270px; background: var(--tblr-bg-surface-secondary); border-radius: 8px; padding: 14px; min-height: 200px; }
        .kanban-column-header { font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; }
        .kanban-cards { min-height: 60px; }
        .kanban-card { background: var(--tblr-bg-surface); border-radius: 8px; padding: 12px 14px; margin-bottom: 10px; box-shadow: 0 1px 4px rgba(0,0,0,.08); border-left: 4px solid #ccc; transition: box-shadow .15s; }
        .kanban-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.12); }
        .kanban-card.estagio-prospeccao   { border-left-color: #206bc4; }
        .kanban-card.estagio-qualificacao { border-left-color: #4299e1; }
        .kanban-card.estagio-proposta     { border-left-color: #f59f00; }
        .kanban-card.estagio-negociacao   { border-left-color: #fd7e14; }
        .kanban-card.estagio-fechamento   { border-left-color: #0ca678; }
        .kanban-card.estagio-ganho        { border-left-color: #2fb344; }
        .kanban-card.estagio-perdido      { border-left-color: #d63939; }
        .card-opp-title { font-weight: 600; font-size: 14px; margin-bottom: 6px; }
        .card-meta { font-size: 12px; color: var(--tblr-secondary); margin-bottom: 3px; display: flex; align-items: center; gap: 4px; }
        .kanban-empty { text-align: center; color: var(--tblr-secondary); font-size: 13px; padding: 20px 0; }
    </style>
    @endpush

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Kanban — Oportunidades</h2>
            <p class="text-muted mt-1">Visão de oportunidades por estágio</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.oportunidades.index') }}" class="btn btn-outline-secondary">Lista</a>
            <a href="{{ route('crm.oportunidades.create') }}" class="btn btn-primary">+ Nova Oportunidade</a>
        </div>
    </div>

    @php
        $columns = [
            'prospeccao'   => ['label' => 'Prospecção',   'color' => 'blue'],
            'qualificacao' => ['label' => 'Qualificação', 'color' => 'azure'],
            'proposta'     => ['label' => 'Proposta',     'color' => 'yellow'],
            'negociacao'   => ['label' => 'Negociação',   'color' => 'orange'],
            'fechamento'   => ['label' => 'Fechamento',   'color' => 'teal'],
            'ganho'        => ['label' => 'Ganho',        'color' => 'green'],
            'perdido'      => ['label' => 'Perdido',      'color' => 'red'],
        ];
    @endphp

    <div class="kanban-board">
        @foreach($columns as $estagio => $col)
        @php $colOpps = $opportunities->get($estagio, collect()); @endphp
        <div class="kanban-column">
            <div class="kanban-column-header">
                <span class="badge bg-{{ $col['color'] }}-lt text-{{ $col['color'] }}">{{ $col['label'] }}</span>
                <span class="badge bg-secondary-lt">{{ $colOpps->count() }}</span>
            </div>
            <div class="kanban-cards">
                @forelse($colOpps as $opp)
                <div class="kanban-card estagio-{{ $estagio }}">
                    <div class="card-opp-title">
                        <a href="{{ route('crm.oportunidades.show', $opp) }}" class="text-reset">{{ $opp->titulo }}</a>
                    </div>

                    @if($opp->contact_name !== '—')
                    <div class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4"/><path d="M5.5 21a8.5 8.5 0 0 1 13 0"/></svg>
                        {{ $opp->contact_name }}
                    </div>
                    @endif

                    @if($opp->user)
                    <div class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"/><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M17 10h2a2 2 0 0 1 2 2v1"/><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M3 13v-1a2 2 0 0 1 2 -2h2"/></svg>
                        {{ $opp->user->name }}
                    </div>
                    @endif

                    <div class="card-meta">
                        @if($opp->valor)
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"/><path d="M12 6l0 2m0 8l0 2"/></svg>
                        R$ {{ number_format($opp->valor, 2, ',', '.') }}
                        @endif
                        @if($opp->probabilidade !== null)
                        &nbsp;·&nbsp; {{ $opp->probabilidade }}%
                        @endif
                    </div>

                    @if($opp->data_fechamento_previsto)
                    <div class="card-meta">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M16 3l0 4"/><path d="M8 3l0 4"/><path d="M4 11l16 0"/></svg>
                        {{ $opp->data_fechamento_previsto->format('d/m/Y') }}
                    </div>
                    @endif
                </div>
                @empty
                <div class="kanban-empty">Nenhuma oportunidade</div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

</x-app-layout>
