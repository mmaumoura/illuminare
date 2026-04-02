<x-app-layout>

    @push('styles')
    <style>
        .funnel-stage { position: relative; margin-bottom: 6px; }
        .funnel-bar { height: 54px; display: flex; align-items: center; justify-content: center; border-radius: 6px; font-weight: 600; font-size: 15px; color: #fff; transition: opacity .15s; }
        .funnel-bar:hover { opacity: .85; }
        .funnel-label { font-size: 13px; text-align: right; padding-right: 12px; }
    </style>
    @endpush

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Funil de Leads</h2>
            <p class="text-muted mt-1">Visualização do pipeline de conversão.</p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('crm.leads.index') }}" class="btn btn-outline-secondary">Lista</a>
            <a href="{{ route('crm.leads.kanban') }}" class="btn btn-outline-secondary">Kanban</a>
        </div>
    </div>

    @php
        $stages = [
            'novo'        => ['label' => 'Novo',        'color' => '#206bc4'],
            'contatado'   => ['label' => 'Contatado',   'color' => '#4299e1'],
            'qualificado' => ['label' => 'Qualificado', 'color' => '#f59f00'],
            'convertido'  => ['label' => 'Convertido',  'color' => '#2fb344'],
            'perdido'     => ['label' => 'Perdido',     'color' => '#d63939'],
        ];
        $maxTotal = $data->max('total') ?: 1;
    @endphp

    <div class="row g-3 mb-4">
        @foreach($data as $stage)
        @php $s = $stages[$stage['status']] ?? ['label' => $stage['status'], 'color' => '#888']; @endphp
        <div class="col-md-2 col-4">
            <div class="card text-center">
                <div class="card-body py-3">
                    <div class="h1 mb-0" style="color: {{ $s['color'] }}">{{ $stage['total'] }}</div>
                    <div class="text-muted small">{{ $s['label'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header"><h3 class="card-title">Funil de Conversão</h3></div>
        <div class="card-body">
            @foreach($data as $stage)
            @php
                $s = $stages[$stage['status']] ?? ['label' => $stage['status'], 'color' => '#888'];
                $pct = $maxTotal > 0 ? round(($stage['total'] / $maxTotal) * 100) : 0;
                $width = max(20, 100 - (($loop->index) * 15));
            @endphp
            <div class="funnel-stage d-flex align-items-center gap-3 mb-2">
                <div style="width: 100px;" class="text-end text-muted fw-semibold small">{{ $s['label'] }}</div>
                <div class="flex-grow-1">
                    <div class="funnel-bar" style="background:{{ $s['color'] }}; width: {{ $width }}%;">
                        {{ $stage['total'] }} leads
                    </div>
                </div>
                <div style="width: 50px;" class="text-muted small">{{ $pct }}%</div>
            </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
