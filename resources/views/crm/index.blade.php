<x-app-layout>

    <div class="row mb-3">
        <div class="col">
            <h2 class="page-title">CRM - Gestão de Relacionamentos</h2>
            <p class="text-muted">Gerencie seus clientes e leads em um só lugar.</p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Total de Clientes</div>
                    </div>
                    <div class="h1 mb-0">{{ count($clientes) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Leads Ativos</div>
                    <div class="h1 mb-0">{{ count($leads) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Taxa de Conversão</div>
                    <div class="h1 mb-0">68%</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Ticket Médio</div>
                    <div class="h1 mb-0">R$ 1.850</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        {{-- CLIENTES --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Clientes</h3>
                    <button class="btn btn-primary btn-sm">+ Novo Cliente</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Contato</th>
                                <th>Status</th>
                                <th>Última Compra</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm rounded me-2"
                                              style="background-image:url(https://ui-avatars.com/api/?name={{ urlencode($cliente['nome']) }})"></span>
                                        <div class="fw-semibold">{{ $cliente['nome'] }}</div>
                                    </div>
                                </td>
                                <td class="text-muted small">
                                    {{ $cliente['email'] }}<br>
                                    {{ $cliente['telefone'] }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $cliente['status'] === 'Ativo' ? 'success' : 'secondary' }}-lt">
                                        {{ $cliente['status'] }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $cliente['ultima_compra'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- LEADS --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Leads</h3>
                    <button class="btn btn-primary btn-sm">+ Novo Lead</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Origem</th>
                                <th>Temperatura</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $lead)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm rounded me-2"
                                              style="background-image:url(https://ui-avatars.com/api/?name={{ urlencode($lead['nome']) }})"></span>
                                        <div>
                                            <div class="fw-semibold">{{ $lead['nome'] }}</div>
                                            <div class="text-muted small">{{ $lead['data'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $lead['origem'] }}</td>
                                <td>
                                    @php
                                        $color = match($lead['temperatura']) {
                                            'Quente' => 'danger',
                                            'Morno' => 'warning',
                                            default => 'info',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $color }}-lt">{{ $lead['temperatura'] }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-blue-lt">{{ $lead['status'] }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
