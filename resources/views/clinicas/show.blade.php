<x-app-layout>

    @php
        $statusColor = match($clinica->status) {
            'Ativa'    => 'success',
            'Inativa'  => 'secondary',
            'Suspensa' => 'warning',
            default    => 'secondary',
        };
    @endphp

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">
                {{ $clinica->name }}
                <span class="badge bg-{{ $statusColor }}-lt text-{{ $statusColor }} ms-2">{{ $clinica->status ?? 'Ativa' }}</span>
            </h2>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('gestao.clinicas.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
            <a href="{{ route('gestao.clinicas.edit', $clinica) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                </svg>
                Editar
            </a>
            <form method="POST" action="{{ route('gestao.clinicas.destroy', $clinica) }}"
                  onsubmit="return confirm('Excluir esta unidade? Esta ação não pode ser desfeita.')">
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

    {{-- STATS --}}
    <div class="row row-cards mb-3">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="7" r="4"/><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $clinica->patients_count }}</div>
                            <div class="text-muted">Pacientes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-azure text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $clinica->users_count }}</div>
                            <div class="text-muted">Usuários Cadastrados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-green text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $clinica->documents_count }}</div>
                            <div class="text-muted">Documentos Anexados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($clinica->contract_start && $clinica->contract_end)
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-{{ $clinica->contract_end->isPast() ? 'red' : 'cyan' }} text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="4" y="5" width="16" height="16" rx="2"/><path d="M16 3v4"/><path d="M8 3v4"/>
                                    <path d="M4 11h16"/>
                                </svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $clinica->contract_end->format('d/m/Y') }}</div>
                            <div class="text-muted">{{ $clinica->contract_end->isPast() ? 'Contrato Encerrado' : 'Término do Contrato' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row row-cards">
        {{-- Coluna principal --}}
        <div class="col-lg-8">

            {{-- Informações Gerais --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Informações Gerais</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted">CNPJ</dt>
                        <dd class="col-7">{{ $clinica->cnpj ?: '—' }}</dd>

                        <dt class="col-5 text-muted">Telefone</dt>
                        <dd class="col-7">{{ $clinica->phone ?: '—' }}</dd>

                        <dt class="col-5 text-muted">E-mail</dt>
                        <dd class="col-7">{{ $clinica->email ?: '—' }}</dd>
                    </dl>
                </div>
            </div>

            {{-- Endereço --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Endereço</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted">Logradouro</dt>
                        <dd class="col-7">
                            @if($clinica->street)
                                {{ $clinica->street }}{{ $clinica->number ? ', '.$clinica->number : '' }}
                            @else
                                —
                            @endif
                        </dd>

                        <dt class="col-5 text-muted">Complemento</dt>
                        <dd class="col-7">{{ $clinica->complement ?: '—' }}</dd>

                        <dt class="col-5 text-muted">Bairro</dt>
                        <dd class="col-7">{{ $clinica->neighborhood ?: '—' }}</dd>

                        <dt class="col-5 text-muted">Cidade / Estado</dt>
                        <dd class="col-7">
                            @if($clinica->city || $clinica->state)
                                {{ $clinica->city }}{{ $clinica->state ? ' - '.$clinica->state : '' }}
                            @else
                                —
                            @endif
                        </dd>

                        <dt class="col-5 text-muted">CEP</dt>
                        <dd class="col-7">{{ $clinica->cep ?: '—' }}</dd>
                    </dl>
                </div>
            </div>

            {{-- Representante Legal --}}
            @if($clinica->rep_name || $clinica->rep_cpf || $clinica->rep_phone || $clinica->rep_email)
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Representante Legal</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted">Nome Completo</dt>
                        <dd class="col-7">{{ $clinica->rep_name ?: '—' }}</dd>

                        <dt class="col-5 text-muted">CPF</dt>
                        <dd class="col-7">{{ $clinica->rep_cpf ?: '—' }}</dd>

                        <dt class="col-5 text-muted">Telefone</dt>
                        <dd class="col-7">{{ $clinica->rep_phone ?: '—' }}</dd>

                        <dt class="col-5 text-muted">E-mail</dt>
                        <dd class="col-7">{{ $clinica->rep_email ?: '—' }}</dd>
                    </dl>
                </div>
            </div>
            @endif

            {{-- Informações do Contrato --}}
            @if($clinica->contract_start || $clinica->contract_end || $clinica->contract_notes)
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Informações do Contrato</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5 text-muted">Data de Início</dt>
                        <dd class="col-7">{{ $clinica->contract_start?->format('d/m/Y') ?? '—' }}</dd>

                        <dt class="col-5 text-muted">Data de Término</dt>
                        <dd class="col-7">{{ $clinica->contract_end?->format('d/m/Y') ?? '—' }}</dd>
                    </dl>
                    @if($clinica->contract_notes)
                    <div class="mt-2 pt-2 border-top">
                        <span class="text-muted small d-block mb-1">Observações</span>
                        <p class="mb-0">{{ $clinica->contract_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Coluna lateral --}}
        <div class="col-lg-4">

            {{-- Informações --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Informações</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-6 text-muted">Cadastrado em</dt>
                        <dd class="col-6">{{ $clinica->created_at->format('d/m/Y') }}</dd>

                        <dt class="col-6 text-muted">Última atualização</dt>
                        <dd class="col-6">{{ $clinica->updated_at->diffForHumans() }}</dd>
                    </dl>
                </div>
            </div>

            {{-- Pacientes recentes --}}
            @if($clinica->patients_count > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Pacientes Recentes</h3>
                    <div class="ms-auto">
                        <a href="{{ route('operacional.pacientes.index') }}?clinic_id={{ $clinica->id }}" class="btn btn-sm btn-secondary">
                            Ver todos
                        </a>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($clinica->patients()->latest()->take(5)->get() as $patient)
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col text-truncate">
                                <a href="{{ route('operacional.pacientes.show', $patient) }}" class="d-block fw-semibold text-truncate">
                                    {{ $patient->name }}
                                </a>
                                <div class="text-muted small">{{ $patient->phone ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Documentos da Unidade — listagem + upload lado a lado --}}
    <div class="row row-cards mt-1">

        {{-- Listagem --}}
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-muted" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                        </svg>
                        Documentos da Unidade
                    </h3>
                    <div class="ms-auto">
                        <span class="badge bg-secondary-lt">{{ $clinica->documents_count }}</span>
                    </div>
                </div>

                @if($documents->isEmpty())
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height:120px">
                    <div class="text-center text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2 opacity-50" width="40" height="40" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                            <path d="M9 13h6"/><path d="M9 17h3"/>
                        </svg>
                        <p class="mb-0 small">Nenhum documento anexado ainda.</p>
                    </div>
                </div>
                @else
                <div class="table-responsive" style="max-height:340px;overflow-y:auto;">
                    <table class="table table-vcenter card-table table-hover">
                        <thead>
                            <tr>
                                <th>Nome / Descrição</th>
                                <th>Tipo</th>
                                <th>Tamanho</th>
                                <th>Data</th>
                                <th class="w-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $doc)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $doc->name }}</div>
                                    @if($doc->description)
                                    <div class="text-muted small mt-1">{{ $doc->description }}</div>
                                    @endif
                                </td>
                                <td><span class="badge bg-blue-lt text-blue">{{ $doc->type }}</span></td>
                                <td class="text-muted small">{{ $doc->formatted_size }}</td>
                                <td class="text-muted small">{{ $doc->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- Visualizar --}}
                                        <a href="{{ Storage::url($doc->path) }}" target="_blank"
                                           class="btn btn-sm btn-ghost-secondary" title="Visualizar arquivo">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                                            </svg>
                                        </a>
                                        {{-- Editar --}}
                                        <button type="button"
                                                class="btn btn-sm btn-ghost-secondary"
                                                title="Editar documento"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal-edit-doc"
                                                data-doc-id="{{ $doc->id }}"
                                                data-doc-name="{{ $doc->name }}"
                                                data-doc-type="{{ $doc->type }}"
                                                data-doc-description="{{ $doc->description }}"
                                                data-doc-url="{{ Storage::url($doc->path) }}"
                                                data-doc-action="{{ route('gestao.clinicas.documents.update', [$clinica, $doc]) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/>
                                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/>
                                            </svg>
                                        </button>
                                        {{-- Remover --}}
                                        <form method="POST"
                                              action="{{ route('gestao.clinicas.documents.destroy', [$clinica, $doc]) }}"
                                              onsubmit="return confirm('Remover este documento?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-ghost-danger" title="Remover">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 24 24"
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        {{-- Formulário de upload --}}
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 text-muted" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                        </svg>
                        Novo Documento
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST"
                          action="{{ route('gestao.clinicas.documents.store', $clinica) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label required">Tipo de Documento</label>
                            <select name="doc_type" class="form-select @error('doc_type') is-invalid @enderror">
                                <option value="">Selecione...</option>
                                @foreach(['Contrato','CNPJ','Alvará','Licença Sanitária','Documento de Identidade','Comprovante de Endereço','Outro'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('doc_type') === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                                @endforeach
                            </select>
                            @error('doc_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Nome do Documento</label>
                            <input type="text" name="doc_name" value="{{ old('doc_name') }}"
                                   class="form-control @error('doc_name') is-invalid @enderror"
                                   placeholder="Ex: Contrato 2025, CNPJ Atualizado...">
                            @error('doc_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Arquivo</label>
                            <input type="file" name="doc_file"
                                   class="form-control @error('doc_file') is-invalid @enderror"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @error('doc_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-hint mt-1">PDF, DOC, DOCX, JPG, PNG — máx. 5 MB</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descrição <span class="text-muted fw-normal">(opcional)</span></label>
                            <textarea name="doc_description" rows="3"
                                      class="form-control @error('doc_description') is-invalid @enderror"
                                      placeholder="Informações adicionais sobre este documento...">{{ old('doc_description') }}</textarea>
                            @error('doc_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/>
                                    <path d="M7 9l5 -5l5 5"/><path d="M12 4l0 12"/>
                                </svg>
                                Anexar Documento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: Editar Documento --}}
<div class="modal modal-blur fade" id="modal-edit-doc" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" id="form-edit-doc" action="" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Editar Documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Tipo de Documento</label>
                        <select name="doc_type" id="edit-doc-type" class="form-select" data-no-select2>
                            @foreach(['Contrato','CNPJ','Alvará','Licença Sanitária','Documento de Identidade','Comprovante de Endereço','Outro'] as $tipo)
                            <option value="{{ $tipo }}">{{ $tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Nome do Documento</label>
                        <input type="text" name="doc_name" id="edit-doc-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Novo Arquivo <span class="text-muted fw-normal">(opcional — deixe vazio para manter o atual)</span></label>
                        <input type="file" name="doc_file" id="edit-doc-file" class="form-control"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-hint">PDF, DOC, DOCX, JPG, PNG — máx. 5 MB</div>
                        <div id="edit-doc-current" class="mt-1 small text-muted d-none">
                            Arquivo atual: <a id="edit-doc-current-link" href="#" target="_blank">ver arquivo</a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição <span class="text-muted fw-normal">(opcional)</span></label>
                        <textarea name="doc_description" id="edit-doc-description" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('modal-edit-doc').addEventListener('show.bs.modal', function (event) {
    var btn         = event.relatedTarget;
    var form        = document.getElementById('form-edit-doc');
    form.action     = btn.getAttribute('data-doc-action');
    document.getElementById('edit-doc-name').value        = btn.getAttribute('data-doc-name');
    document.getElementById('edit-doc-description').value = btn.getAttribute('data-doc-description') || '';    document.getElementById('edit-doc-file').value        = '';
    var url = btn.getAttribute('data-doc-url');
    var currentBox  = document.getElementById('edit-doc-current');
    var currentLink = document.getElementById('edit-doc-current-link');
    if (url) {
        currentLink.href = url;
        currentBox.classList.remove('d-none');
    } else {
        currentBox.classList.add('d-none');
    }    var typeSelect = document.getElementById('edit-doc-type');
    var type       = btn.getAttribute('data-doc-type');
    for (var i = 0; i < typeSelect.options.length; i++) {
        typeSelect.options[i].selected = (typeSelect.options[i].value === type);
    }
});
</script>
@endpush

</x-app-layout>
