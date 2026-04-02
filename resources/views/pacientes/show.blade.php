<x-app-layout>

    {{-- PAGE HEADER --}}
    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $paciente->name }}</h2>
            <div class="text-muted mt-1">
                @if($paciente->birth_date)
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <rect x="4" y="5" width="16" height="16" rx="2"/>
                        <path d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11h16"/>
                    </svg>
                    {{ $paciente->birth_date->format('d/m/Y') }} ({{ $paciente->birth_date->age }} anos)
                @else
                    Data de nascimento não informada
                @endif
            </div>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('operacional.pacientes.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
            <a href="{{ route('operacional.pacientes.edit', $paciente) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                </svg>
                Editar
            </a>
            <form method="POST" action="{{ route('operacional.pacientes.destroy', $paciente) }}"
                  onsubmit="return confirm('Excluir este paciente? Esta ação não pode ser desfeita.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                    </svg>
                    Excluir
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('public_fill_link'))
    <div class="alert alert-info alert-dismissible" role="alert" id="alert-public-link">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <div>
                <strong>Link de preenchimento gerado!</strong><br>
                <span class="text-muted small">Envie este link para o paciente preencher a ficha de anamnese:</span>
            </div>
            <div class="d-flex align-items-center gap-2 flex-grow-1">
                <input type="text" class="form-control form-control-sm" id="generated-fill-link" value="{{ session('public_fill_link') }}" readonly>
                <button type="button" class="btn btn-sm btn-info text-white text-nowrap" onclick="copyGeneratedLink()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6-6"/><path d="M11 6l.463-.536a5 5 0 017.071 7.072l-.534.463"/><path d="M13 18l-.397.534a5.068 5.068 0 01-7.127 0a4.972 4.972 0 010-7.071l.524-.463"/></svg>
                    Copiar
                </button>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- STATS ROW --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card card-sm text-center">
                <div class="card-body">
                    <div class="h1 fw-bold text-blue mb-0">{{ $paciente->documents->count() }}</div>
                    <div class="text-muted small">Documentos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card card-sm text-center">
                <div class="card-body">
                    <div class="h1 fw-bold text-green mb-0">{{ $paciente->contracts->count() }}</div>
                    <div class="text-muted small">Contratos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card card-sm text-center">
                <div class="card-body">
                    <div class="h1 fw-bold text-purple mb-0">{{ $paciente->anamneses->count() }}</div>
                    <div class="text-muted small">Anamneses</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card card-sm text-center">
                <div class="card-body">
                    <div class="h1 fw-bold text-orange mb-0">{{ $paciente->medicalRecords->count() }}</div>
                    <div class="text-muted small">Prontuários</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card card-sm text-center">
                <div class="card-body">
                    <div class="h1 fw-bold text-pink mb-0">{{ $paciente->photos->count() }}</div>
                    <div class="text-muted small">Fotos</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card card-sm text-center">
                <div class="card-body">
                    <div class="h1 fw-bold text-cyan mb-0">{{ $paciente->appointments->count() }}</div>
                    <div class="text-muted small">Agendamentos</div>
                </div>
            </div>
        </div>
    </div>

    {{-- INFO CARDS GRID --}}
    <div class="row row-cards mb-3">

        {{-- Dados Pessoais --}}
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Dados Pessoais</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr><td class="text-muted ps-3" style="width:46%">Nome Completo</td><td class="fw-semibold">{{ $paciente->name }}</td></tr>
                            <tr><td class="text-muted ps-3">CPF</td><td>{{ $paciente->cpf ?: 'Não informado' }}</td></tr>
                            <tr><td class="text-muted ps-3">Data de Nascimento</td><td>{{ $paciente->birth_date ? $paciente->birth_date->format('d/m/Y') : 'Não informado' }}</td></tr>
                            <tr><td class="text-muted ps-3">Telefone</td><td>{{ $paciente->phone ?: 'Não informado' }}</td></tr>
                            <tr><td class="text-muted ps-3">E-mail</td><td>{{ $paciente->email ?: 'Não informado' }}</td></tr>
                            <tr>
                                <td class="text-muted ps-3">Unidade</td>
                                <td>
                                    @if($paciente->clinic)
                                        <a href="{{ route('gestao.clinicas.show', $paciente->clinic) }}">{{ $paciente->clinic->name }}</a>
                                    @else
                                        <span class="text-muted">Não vinculado</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Endereço --}}
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Endereço</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr><td class="text-muted ps-3" style="width:46%">CEP</td><td>{{ $paciente->cep ?: '—' }}</td></tr>
                            <tr>
                                <td class="text-muted ps-3">Logradouro</td>
                                <td>{{ $paciente->street ? $paciente->street . ($paciente->number ? ', ' . $paciente->number : '') : '—' }}</td>
                            </tr>
                            @if($paciente->complement)
                            <tr><td class="text-muted ps-3">Complemento</td><td>{{ $paciente->complement }}</td></tr>
                            @endif
                            <tr><td class="text-muted ps-3">Bairro</td><td>{{ $paciente->neighborhood ?: '—' }}</td></tr>
                            <tr>
                                <td class="text-muted ps-3">Cidade / Estado</td>
                                <td>{{ $paciente->city ? $paciente->city . ($paciente->state ? ' - ' . $paciente->state : '') : '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Informações Médicas --}}
        <div class="col-md-6 col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Informações Médicas</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr><td class="text-muted ps-3" style="width:46%">Histórico Médico</td><td>{{ $paciente->medical_history ?: 'Não informado' }}</td></tr>
                            <tr><td class="text-muted ps-3">Alergias</td><td>{{ $paciente->allergies ?: 'Não informado' }}</td></tr>
                            <tr><td class="text-muted ps-3">Medicamentos em Uso</td><td>{{ $paciente->current_medications ?: 'Não informado' }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Contato de Emergência --}}
        <div class="col-md-6 col-xl-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Contato de Emergência</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr><td class="text-muted ps-3" style="width:46%">Nome</td><td>{{ $paciente->emergency_contact_name ?: '—' }}</td></tr>
                            <tr><td class="text-muted ps-3">Telefone</td><td>{{ $paciente->emergency_contact_phone ?: '—' }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Informações do sistema --}}
        <div class="col-md-6 col-xl-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Informações</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr><td class="text-muted ps-3" style="width:46%">Cadastrado em</td><td>{{ $paciente->created_at->format('d/m/Y') }}</td></tr>
                            <tr><td class="text-muted ps-3">Última atualização</td><td>{{ $paciente->updated_at->diffForHumans() }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>{{-- /info cards --}}

    {{-- TABS CARD — full width --}}
    <div class="card">
        <div class="card-body">

                    <ul class="nav nav-tabs mb-3" id="patientTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-documentos" type="button" role="tab">
                                Documentos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-contratos" type="button" role="tab">
                                Contratos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-anamneses" type="button" role="tab">
                                Anamneses
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-prontuarios" type="button" role="tab">
                                Prontuários
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-fotos" type="button" role="tab">
                                Fotos do Paciente
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-agendamentos" type="button" role="tab">
                                Agendamentos
                                <span class="badge bg-blue ms-1">0</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-vendas" type="button" role="tab">
                                Vendas
                                <span class="badge bg-green ms-1">0</span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">

                        {{-- Documentos --}}
                        <div class="tab-pane fade show active" id="tab-documentos" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Documentos do Paciente</h6>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-upload-doc">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                                    Upload Documento
                                </button>
                            </div>
                            @if($paciente->documents->count())
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead><tr><th>Nome</th><th>Tipo</th><th>Data</th><th class="w-1"></th></tr></thead>
                                    <tbody>
                                        @foreach($paciente->documents->sortByDesc('created_at') as $doc)
                                        <tr>
                                            <td>
                                                <a href="{{ Storage::disk('public')->url($doc->file_path) }}" target="_blank">{{ $doc->name }}</a>
                                                @if($doc->description)<div class="text-muted small">{{ $doc->description }}</div>@endif
                                            </td>
                                            <td><span class="badge bg-blue-lt">{{ $doc->type }}</span></td>
                                            <td class="text-muted">{{ $doc->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <form method="POST" action="{{ route('operacional.pacientes.documentos.destroy', [$paciente, $doc]) }}" onsubmit="return confirm('Excluir este documento?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-ghost-danger btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2 text-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/></svg>
                                <p class="mb-0">Nenhum documento anexado</p>
                            </div>
                            @endif
                        </div>

                        {{-- Contratos --}}
                        <div class="tab-pane fade" id="tab-contratos" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Contratos do Paciente</h6>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-novo-contrato">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                                    Novo Contrato
                                </button>
                            </div>
                            @if($paciente->contracts->count())
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead><tr><th>Título</th><th>Tipo</th><th>Gerado em</th><th class="w-1"></th></tr></thead>
                                    <tbody>
                                        @foreach($paciente->contracts->sortByDesc('created_at') as $contrato)
                                        <tr>
                                            <td class="fw-semibold">{{ $contrato->title }}</td>
                                            <td><span class="badge bg-purple-lt text-purple">{{ $contrato->type }}</span></td>
                                            <td class="text-muted">{{ $contrato->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('operacional.pacientes.contratos.show', [$paciente, $contrato]) }}"
                                                       target="_blank"
                                                       class="btn btn-ghost-primary btn-sm" title="Visualizar / Imprimir">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M21 12c-2.4 4-5.4 6-9 6c-3.6 0-6.6-2-9-6c2.4-4 5.4-6 9-6c3.6 0 6.6 2 9 6"/></svg>
                                                    </a>
                                                    <form method="POST" action="{{ route('operacional.pacientes.contratos.destroy', [$paciente, $contrato]) }}" onsubmit="return confirm('Excluir este contrato?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-ghost-danger btn-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2 text-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/></svg>
                                <p class="mb-2">Nenhum contrato gerado ainda</p>
                                @if($contractTemplates->count())
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-novo-contrato">
                                    Gerar Primeiro Contrato
                                </button>
                                @else
                                <p class="text-muted small">Crie modelos de contrato em <a href="{{ route('gestao.contratos-modelos.index') }}">Modelos de Contrato</a> para usar aqui.</p>
                                @endif
                            </div>
                            @endif
                        </div>

                        {{-- Anamneses --}}
                        <div class="tab-pane fade" id="tab-anamneses" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Fichas de Anamnese</h6>
                                <div class="d-flex gap-2">
                                    <form method="POST" action="{{ route('operacional.pacientes.anamneses.gerar-link', $paciente) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-cyan btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6-6"/><path d="M11 6l.463-.536a5 5 0 017.071 7.072l-.534.463"/><path d="M13 18l-.397.534a5.068 5.068 0 01-7.127 0a4.972 4.972 0 010-7.071l.524-.463"/></svg>
                                            Gerar Link para Paciente
                                        </button>
                                    </form>
                                    <a href="{{ route('operacional.pacientes.anamneses.create', $paciente) }}" class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                                    Nova Anamnese
                                </a>
                                </div>
                            </div>
                            @if($paciente->anamneses->count())
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead><tr><th>Data</th><th>Status</th><th>Preenchida por</th><th>Queixa Principal</th><th>Links Públicos</th><th class="w-1"></th></tr></thead>
                                    <tbody>
                                        @foreach($paciente->anamneses->sortByDesc('anamnesis_date') as $anamnese)
                                        <tr>
                                            <td>{{ $anamnese->anamnesis_date->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $anamnese->status === 'completa' ? 'success' : ($anamnese->status === 'pendente_assinatura' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $anamnese->status)) }}
                                                </span>
                                            </td>
                                            <td>{{ $anamnese->filled_by === 'paciente' ? 'Paciente' : 'Profissional' }}</td>
                                            <td class="text-muted">{{ Str::limit($anamnese->chief_complaint, 50) }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button type="button" class="btn btn-outline-cyan btn-sm" onclick="copyLink('{{ route('anamnese.public.fill', $anamnese->token) }}')" title="Copiar link de preenchimento">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6-6"/><path d="M11 6l.463-.536a5 5 0 017.071 7.072l-.534.463"/><path d="M13 18l-.397.534a5.068 5.068 0 01-7.127 0a4.972 4.972 0 010-7.071l.524-.463"/></svg>
                                                        Preenchimento
                                                    </button>
                                                    <button type="button" class="btn btn-outline-orange btn-sm" onclick="copyLink('{{ route('anamnese.assinatura', $anamnese->signature_token) }}')" title="Copiar link de assinatura">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17c3.333 -3.333 5 -6 5 -8c0 -3 -1 -3 -2 -3s-2.032 1.085 -2 3c.034 2.048 1.658 4.877 2.5 6c1.5 2 2.5 2.5 3.5 1l2 -3c.333 2.667 1.333 4 3 4"/></svg>
                                                        Assinatura
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('operacional.pacientes.anamneses.show', [$paciente, $anamnese]) }}" class="btn btn-ghost-primary btn-sm" title="Visualizar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M21 12c-2.4 4-5.4 6-9 6c-3.6 0-6.6-2-9-6c2.4-4 5.4-6 9-6c3.6 0 6.6 2 9 6"/></svg>
                                                    </a>
                                                    <form method="POST" action="{{ route('operacional.pacientes.anamneses.destroy', [$paciente, $anamnese]) }}" onsubmit="return confirm('Excluir esta anamnese?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-ghost-danger btn-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2 text-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/><path d="M9 12h6"/><path d="M9 16h6"/></svg>
                                <p class="mb-0">Nenhuma anamnese registrada</p>
                            </div>
                            @endif
                        </div>

                        {{-- Prontuários --}}
                        <div class="tab-pane fade" id="tab-prontuarios" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Prontuários Odontológicos</h6>
                                <a href="{{ route('operacional.pacientes.prontuarios.create', $paciente) }}" class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                                    Novo Prontuário
                                </a>
                            </div>
                            @if($paciente->medicalRecords->count())
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead><tr><th>Data</th><th>Profissional</th><th>Procedimento</th><th>Dente/Região</th><th class="w-1"></th></tr></thead>
                                    <tbody>
                                        @foreach($paciente->medicalRecords->sortByDesc('record_date') as $prontuario)
                                        <tr>
                                            <td>{{ $prontuario->record_date->format('d/m/Y') }}</td>
                                            <td>{{ $prontuario->professional?->name ?? '—' }}</td>
                                            <td>{{ $prontuario->procedure?->name ?? '—' }}</td>
                                            <td>{{ $prontuario->tooth_region ?: '—' }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('operacional.pacientes.prontuarios.show', [$paciente, $prontuario]) }}" class="btn btn-ghost-primary btn-sm" title="Visualizar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/><path d="M21 12c-2.4 4-5.4 6-9 6c-3.6 0-6.6-2-9-6c2.4-4 5.4-6 9-6c3.6 0 6.6 2 9 6"/></svg>
                                                    </a>
                                                    <form method="POST" action="{{ route('operacional.pacientes.prontuarios.destroy', [$paciente, $prontuario]) }}" onsubmit="return confirm('Excluir este prontuário?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-ghost-danger btn-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2 text-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2z"/><path d="M9 12h6"/><path d="M12 9v6"/></svg>
                                <p class="mb-0">Nenhum prontuário registrado</p>
                            </div>
                            @endif
                        </div>

                        {{-- Fotos --}}
                        <div class="tab-pane fade" id="tab-fotos" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Galeria de Fotos</h6>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-upload-foto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                                    Upload Foto
                                </button>
                            </div>
                            @if($paciente->photos->count())
                            <div class="row g-3">
                                @foreach($paciente->photos->sortByDesc('photo_date') as $foto)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card card-sm">
                                        <a href="{{ Storage::disk('public')->url($foto->file_path) }}" target="_blank">
                                            <img src="{{ Storage::disk('public')->url($foto->file_path) }}" class="card-img-top" alt="{{ $foto->title }}" style="height:180px;object-fit:cover">
                                        </a>
                                        <div class="card-body p-2">
                                            <div class="fw-semibold small">{{ $foto->title }}</div>
                                            <div class="text-muted small">{{ $foto->photo_date->format('d/m/Y') }} — {{ $foto->type }}</div>
                                            @if($foto->region)<div class="text-muted small">{{ $foto->region }}</div>@endif
                                        </div>
                                        <div class="card-footer p-1 text-end">
                                            <form method="POST" action="{{ route('operacional.pacientes.fotos.destroy', [$paciente, $foto]) }}" class="d-inline" onsubmit="return confirm('Excluir esta foto?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-ghost-danger btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2 text-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 8h.01"/><path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"/><path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l4 4"/><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"/></svg>
                                <p class="mb-0">Nenhuma foto registrada</p>
                            </div>
                            @endif
                        </div>

                        {{-- Agendamentos --}}
                        <div class="tab-pane fade" id="tab-agendamentos" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Histórico de Agendamentos</h6>
                                <a href="{{ route('operacional.agenda.create', ['patient_id' => $paciente->id]) }}"
                                   class="btn btn-primary btn-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                                    Novo Agendamento
                                </a>
                            </div>
                            @if($paciente->appointments->count())
                            <div class="table-responsive">
                                <table class="table table-vcenter table-striped">
                                    <thead><tr><th>Data</th><th>Horário</th><th>Procedimento</th><th>Status</th></tr></thead>
                                    <tbody>
                                        @foreach($paciente->appointments->sortByDesc('starts_at') as $apt)
                                        <tr>
                                            <td>{{ $apt->starts_at->format('d/m/Y') }}</td>
                                            <td>{{ $apt->starts_at->format('H:i') }} — {{ $apt->ends_at->format('H:i') }}</td>
                                            <td>{{ $apt->procedures->pluck('name')->join(', ') ?: '—' }}</td>
                                            <td><span class="badge bg-{{ $apt->status_color }}">{{ $apt->status }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2 text-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M4 11h16"/></svg>
                                <p class="mb-0">Nenhum agendamento registrado</p>
                            </div>
                            @endif
                        </div>

                        {{-- Vendas --}}
                        <div class="tab-pane fade" id="tab-vendas" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Histórico de Vendas</h6>
                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-em-dev">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                                    Nova Venda
                                </button>
                            </div>
                            <div class="text-center py-5 text-muted">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2 text-muted" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2 -1.61l1.6 -8.39h-16"/></svg>
                                <p class="mb-0">Em desenvolvimento</p>
                            </div>
                        </div>

                    </div>{{-- /tab-content --}}
                </div>
            </div>{{-- /tabs card --}}

    {{-- Modal: Upload Documento --}}
    <div class="modal modal-blur fade" id="modal-upload-doc" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('operacional.pacientes.documentos.store', $paciente) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload de Documento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-12">
                            <label class="form-label required">Nome do Documento</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Tipo</label>
                            <select name="type" class="form-select" data-no-select2 required>
                                <option value="">Selecione</option>
                                @foreach(['RG','CPF','Comprovante de Residência','Receita','Atestado','Imagem de Exame','Raio-X','Tomografia','Contrato','Termo de Consentimento','Outro'] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Arquivo</label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                            <small class="text-muted">PDF, JPG, PNG, DOC ou DOCX (máx. 5MB)</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descrição</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar Documento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Upload Foto --}}
    <div class="modal modal-blur fade" id="modal-upload-foto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('operacional.pacientes.fotos.store', $paciente) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload de Foto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-8">
                            <label class="form-label required">Título</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Data</label>
                            <input type="date" name="photo_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Tipo</label>
                            <select name="type" class="form-select" data-no-select2 required>
                                <option value="">Selecione</option>
                                @foreach(['Antes','Durante','Depois','Raio-X','Tomografia','Panorâmica','Intraoral','Extraoral','Outro'] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Região</label>
                            <select name="region" class="form-select" data-no-select2>
                                <option value="">Selecione (opcional)</option>
                                @foreach(['Arcada Superior','Arcada Inferior','Anterior','Posterior','Face Frontal','Perfil Direito','Perfil Esquerdo','Sorriso','Oclusão'] as $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Foto</label>
                            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png" required>
                            <small class="text-muted">JPG ou PNG (máx. 10MB)</small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Descrição</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="visible_to_patient" value="1">
                                <span class="form-check-label">Visível para o paciente</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Toast para copiar link --}}
    <div id="copy-toast" class="position-fixed top-0 end-0 p-3" style="z-index:9999;display:none">
        <div class="alert alert-success mb-0">Link copiado para a área de transferência!</div>
    </div>

    {{-- Modal: funcionalidade em desenvolvimento --}}
    <div class="modal modal-blur fade" id="modal-em-dev" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-title">Em desenvolvimento</div>
                    <div class="text-muted mt-1">Esta funcionalidade será disponibilizada em breve.</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal: Novo Contrato --}}
    <div class="modal modal-blur fade" id="modal-novo-contrato" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('operacional.pacientes.contratos.store', $paciente) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Gerar Novo Contrato</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if($contractTemplates->count())
                        <div class="mb-3">
                            <label class="form-label required">Modelo de Contrato</label>
                            <select name="contract_template_id" class="form-select" required>
                                <option value="">Selecione um modelo...</option>
                                @foreach($contractTemplates as $tpl)
                                <option value="{{ $tpl->id }}">{{ $tpl->title }} — <span class="text-muted">{{ $tpl->type }}</span></option>
                                @endforeach
                            </select>
                            <div class="form-hint">O contrato será gerado com os dados do paciente preenchidos automaticamente.</div>
                        </div>
                        @else
                        <div class="alert alert-warning mb-0">
                            Nenhum modelo de contrato cadastrado. <a href="{{ route('gestao.contratos-modelos.create') }}">Criar modelo</a>.
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Cancelar</button>
                        @if($contractTemplates->count())
                        <button type="submit" class="btn btn-primary">Gerar Contrato</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('scripts')
<script>
function copyLink(url) {
    navigator.clipboard.writeText(url).then(function () {
        var t = document.getElementById('copy-toast');
        t.style.display = 'block';
        setTimeout(function () { t.style.display = 'none'; }, 2000);
    });
}

function copyGeneratedLink() {
    var input = document.getElementById('generated-fill-link');
    if (input) {
        navigator.clipboard.writeText(input.value).then(function () {
            var t = document.getElementById('copy-toast');
            t.style.display = 'block';
            setTimeout(function () { t.style.display = 'none'; }, 2000);
        });
    }
}

@if(session('active_tab'))
document.addEventListener('DOMContentLoaded', function () {
    var tab = document.querySelector('[data-bs-target="#tab-{{ session('active_tab') }}"]');
    if (tab) { new bootstrap.Tab(tab).show(); }
});
@endif
</script>
@endpush
</x-app-layout>