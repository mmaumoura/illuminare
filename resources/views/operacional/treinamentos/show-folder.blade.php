<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $pasta->nome }}</h2>
            <p class="text-muted mt-1">
                {{ $pasta->trainings->count() }} {{ Str::plural('arquivo', $pasta->trainings->count()) }}
                @if($pasta->clinic) · {{ $pasta->clinic->name }} @endif
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('operacional.treinamentos.pasta.create-file', $pasta) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                Adicionar Arquivo
            </a>
            <a href="{{ route('operacional.treinamentos.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
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

    @if($pasta->descricao)
    <div class="alert alert-info">{{ $pasta->descricao }}</div>
    @endif

    @if($pasta->trainings->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <h3>Pasta vazia</h3>
            <p>Adicione PDF, texto ou imagens a esta pasta.</p>
            <a href="{{ route('operacional.treinamentos.pasta.create-file', $pasta) }}" class="btn btn-primary">Adicionar Arquivo</a>
        </div>
    </div>
    @else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Arquivo</th>
                        <th>Tipo</th>
                        <th>Tamanho</th>
                        <th>Adicionado por</th>
                        <th>Data</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pasta->trainings as $item)
                    <tr>
                        <td>
                            <a href="{{ route('operacional.treinamentos.show', $item) }}" class="fw-semibold text-reset">
                                {{ $item->titulo }}
                            </a>
                            @if($item->descricao)
                            <div class="text-muted small">{{ Str::limit($item->descricao, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $item->tipo_color }}-lt text-{{ $item->tipo_color }}">
                                {{ $item->tipo_label }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $item->file_size_formatted }}</td>
                        <td class="text-muted">{{ $item->user->name ?? '—' }}</td>
                        <td class="text-muted">{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('operacional.treinamentos.show', $item) }}"
                                   class="btn btn-sm btn-ghost-secondary" title="Visualizar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/></svg>
                                </a>
                                @if($item->arquivo_path)
                                <a href="{{ Storage::url($item->arquivo_path) }}" target="_blank"
                                   class="btn btn-sm btn-ghost-secondary" title="Download">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/><path d="M7 11l5 5l5 -5"/><path d="M12 4l0 12"/></svg>
                                </a>
                                @endif
                                <form method="POST" action="{{ route('operacional.treinamentos.destroy', $item) }}"
                                      onsubmit="return confirm('Excluir este arquivo?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
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
    </div>
    @endif

</x-app-layout>
