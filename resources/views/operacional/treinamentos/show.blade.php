<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $treinamento->titulo }}</h2>
            <p class="text-muted mt-1">
                <span class="badge bg-{{ $treinamento->tipo_color }}-lt text-{{ $treinamento->tipo_color }}">
                    {{ $treinamento->tipo_label }}
                </span>
                · Pasta: <a href="{{ route('operacional.treinamentos.pasta.show', $treinamento->folder) }}">{{ $treinamento->folder->nome }}</a>
                @if($treinamento->arquivo_tamanho)
                · {{ $treinamento->file_size_formatted }}
                @endif
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            @if($treinamento->arquivo_path)
            <a href="{{ Storage::url($treinamento->arquivo_path) }}" target="_blank" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"/><path d="M7 11l5 5l5 -5"/><path d="M12 4l0 12"/></svg>
                Download
            </a>
            @endif
            <form method="POST" action="{{ route('operacional.treinamentos.destroy', $treinamento) }}"
                  onsubmit="return confirm('Excluir este arquivo?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
            <a href="{{ route('operacional.treinamentos.pasta.show', $treinamento->folder) }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
                Voltar
            </a>
        </div>
    </div>

    @if($treinamento->descricao)
    <div class="alert alert-info mb-3">{{ $treinamento->descricao }}</div>
    @endif

    @if($treinamento->tipo === 'texto')
    <div class="card">
        <div class="card-body" style="white-space: pre-wrap; line-height: 1.7;">{{ $treinamento->conteudo_texto }}</div>
    </div>

    @elseif($treinamento->tipo === 'pdf' && $treinamento->arquivo_path)
    <div class="card">
        <div class="card-body p-0">
            <iframe src="{{ Storage::url($treinamento->arquivo_path) }}"
                    style="width:100%; height:80vh; border:0;" title="{{ $treinamento->titulo }}"></iframe>
        </div>
    </div>

    @elseif($treinamento->tipo === 'imagem' && $treinamento->arquivo_path)
    <div class="card">
        <div class="card-body text-center">
            <img src="{{ Storage::url($treinamento->arquivo_path) }}" alt="{{ $treinamento->titulo }}"
                 class="img-fluid rounded" style="max-height:80vh;">
        </div>
    </div>
    @endif

    <div class="text-muted small mt-3">
        Adicionado por <strong>{{ $treinamento->user->name ?? '—' }}</strong>
        em {{ $treinamento->created_at->format('d/m/Y \à\s H:i') }}
    </div>

</x-app-layout>
