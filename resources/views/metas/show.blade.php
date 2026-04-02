<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $meta->titulo }}</h2>
            <p class="text-muted mt-1">
                <span class="badge bg-{{ $meta->status_color }}-lt text-{{ $meta->status_color }}">{{ $meta->status_label }}</span>
                <span class="badge bg-blue-lt text-blue ms-1">{{ $meta->tipo_label }}</span>
                &nbsp;{{ $meta->periodo_inicio->format('d/m/Y') }} → {{ $meta->periodo_fim->format('d/m/Y') }}
                @if($meta->clinic) · {{ $meta->clinic->name }} @endif
                @if($meta->responsavel) · {{ $meta->responsavel->name }} @endif
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('comercial.metas.edit', $meta) }}" class="btn btn-outline-secondary">Editar Meta</a>
            <a href="{{ route('comercial.metas.index') }}" class="btn btn-secondary">
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

    {{-- Progress Cards --}}
    <div class="row g-3 mb-4">
        @if($meta->meta_valor)
        @php
            $prog = $meta->progresso_valor;
            $c = $prog >= 100 ? 'success' : ($prog >= 60 ? 'warning' : 'danger');
        @endphp
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="subheader">Faturamento</div>
                        <div class="ms-auto lh-1">
                            <span class="badge bg-{{ $c }}-lt text-{{ $c }}">{{ $prog }}%</span>
                        </div>
                    </div>
                    <div class="h3 mb-0">R$ {{ number_format($meta->valor_realizado, 2, ',', '.') }}</div>
                    <div class="text-muted mb-3">de R$ {{ number_format($meta->meta_valor, 2, ',', '.') }}</div>
                    <div class="progress mb-0">
                        <div class="progress-bar bg-{{ $c }}" style="width:{{ $prog }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($meta->meta_procedimentos)
        @php
            $prog = $meta->progresso_procedimentos;
            $c = $prog >= 100 ? 'success' : ($prog >= 60 ? 'warning' : 'danger');
        @endphp
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="subheader">Procedimentos</div>
                        <div class="ms-auto lh-1">
                            <span class="badge bg-{{ $c }}-lt text-{{ $c }}">{{ $prog }}%</span>
                        </div>
                    </div>
                    <div class="h3 mb-0">{{ $meta->procedimentos_realizados }}</div>
                    <div class="text-muted mb-3">de {{ $meta->meta_procedimentos }} procedimentos</div>
                    <div class="progress mb-0">
                        <div class="progress-bar bg-{{ $c }}" style="width:{{ $prog }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($meta->meta_pacientes_novos)
        @php
            $prog = $meta->progresso_pacientes;
            $c = $prog >= 100 ? 'success' : ($prog >= 60 ? 'warning' : 'danger');
        @endphp
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="subheader">Pacientes Novos</div>
                        <div class="ms-auto lh-1">
                            <span class="badge bg-{{ $c }}-lt text-{{ $c }}">{{ $prog }}%</span>
                        </div>
                    </div>
                    <div class="h3 mb-0">{{ $meta->pacientes_novos_realizados }}</div>
                    <div class="text-muted mb-3">de {{ $meta->meta_pacientes_novos }} pacientes</div>
                    <div class="progress mb-0">
                        <div class="progress-bar bg-{{ $c }}" style="width:{{ $prog }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row g-3">
        {{-- Add daily entry --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $todayEntry ? 'Atualizar Registro de Hoje' : 'Registrar Hoje' }}
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comercial.metas.entries.store', $meta) }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label required">Data</label>
                                <input type="date" name="data" class="form-control"
                                       value="{{ $todayEntry ? $todayEntry->data->format('Y-m-d') : now()->format('Y-m-d') }}" required>
                            </div>
                            @if($meta->meta_valor)
                            <div class="col-12">
                                <label class="form-label">Faturamento do Dia (R$)</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" name="valor_realizado" step="0.01" min="0"
                                           class="form-control"
                                           value="{{ $todayEntry?->valor_realizado ?? '' }}" placeholder="0,00">
                                </div>
                            </div>
                            @endif
                            @if($meta->meta_procedimentos)
                            <div class="col-12">
                                <label class="form-label">Procedimentos Realizados</label>
                                <input type="number" name="procedimentos_realizados" min="0"
                                       class="form-control"
                                       value="{{ $todayEntry?->procedimentos_realizados ?? '' }}">
                            </div>
                            @endif
                            @if($meta->meta_pacientes_novos)
                            <div class="col-12">
                                <label class="form-label">Pacientes Novos</label>
                                <input type="number" name="pacientes_novos" min="0"
                                       class="form-control"
                                       value="{{ $todayEntry?->pacientes_novos ?? '' }}">
                            </div>
                            @endif
                            <div class="col-12">
                                <label class="form-label">Observações</label>
                                <textarea name="notas" rows="2" class="form-control"
                                          placeholder="Notas do dia…">{{ $todayEntry?->notas }}</textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ $todayEntry ? 'Atualizar' : 'Salvar Registro' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($meta->descricao)
            <div class="card mt-3">
                <div class="card-header"><h3 class="card-title">Observações</h3></div>
                <div class="card-body text-muted">{{ $meta->descricao }}</div>
            </div>
            @endif
        </div>

        {{-- History --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Histórico Diário</h3>
                    <div class="card-options">
                        <span class="text-muted small">{{ $entries->count() }} registro(s)</span>
                    </div>
                </div>
                @if($entries->isEmpty())
                <div class="card-body text-center text-muted py-4">
                    Nenhum registro ainda. Use o formulário ao lado para registrar o primeiro dia.
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-vcenter card-table table-sm">
                        <thead>
                            <tr>
                                <th>Data</th>
                                @if($meta->meta_valor) <th>Faturamento</th> @endif
                                @if($meta->meta_procedimentos) <th>Procedimentos</th> @endif
                                @if($meta->meta_pacientes_novos) <th>Pacientes</th> @endif
                                <th>Notas</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entries as $entry)
                            <tr>
                                <td class="text-nowrap">
                                    <strong>{{ $entry->data->format('d/m/Y') }}</strong>
                                    <div class="text-muted small">{{ $entry->data->locale('pt_BR')->dayName }}</div>
                                </td>
                                @if($meta->meta_valor)
                                <td>R$ {{ number_format($entry->valor_realizado, 2, ',', '.') }}</td>
                                @endif
                                @if($meta->meta_procedimentos)
                                <td>{{ $entry->procedimentos_realizados }}</td>
                                @endif
                                @if($meta->meta_pacientes_novos)
                                <td>{{ $entry->pacientes_novos }}</td>
                                @endif
                                <td class="text-muted small">{{ Str::limit($entry->notas, 40) }}</td>
                                <td>
                                    <form method="POST"
                                          action="{{ route('comercial.metas.entries.destroy', [$meta, $entry]) }}"
                                          onsubmit="return confirm('Excluir este registro?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24"
                                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/>
                                                <path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-semibold">
                                <td>Total</td>
                                @if($meta->meta_valor)
                                <td>R$ {{ number_format($meta->valor_realizado, 2, ',', '.') }}</td>
                                @endif
                                @if($meta->meta_procedimentos)
                                <td>{{ $meta->procedimentos_realizados }}</td>
                                @endif
                                @if($meta->meta_pacientes_novos)
                                <td>{{ $meta->pacientes_novos_realizados }}</td>
                                @endif
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
