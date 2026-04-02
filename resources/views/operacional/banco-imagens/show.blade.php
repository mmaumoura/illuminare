<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $imagem->titulo }}</h2>
            <p class="text-muted mt-1">
                Pasta: <a href="{{ route('operacional.banco-imagens.pasta.show', $imagem->folder) }}">{{ $imagem->folder->nome }}</a>
                · {{ $imagem->file_size_formatted }}
                @if($imagem->user) · {{ $imagem->user->name }} @endif
                · {{ $imagem->created_at->format('d/m/Y') }}
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ Storage::url($imagem->arquivo_path) }}" target="_blank" download class="btn btn-outline-secondary">
                Download
            </a>
            <form method="POST" action="{{ route('operacional.banco-imagens.destroy', $imagem) }}"
                  onsubmit="return confirm('Excluir esta imagem?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
            <a href="{{ route('operacional.banco-imagens.pasta.show', $imagem->folder) }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body text-center">
            <img src="{{ Storage::url($imagem->arquivo_path) }}" alt="{{ $imagem->titulo }}"
                 class="img-fluid rounded" style="max-height:80vh;">
        </div>
        @if($imagem->descricao || $imagem->tags)
        <div class="card-footer">
            @if($imagem->descricao)
            <p class="mb-1">{{ $imagem->descricao }}</p>
            @endif
            @if($imagem->tags)
            <div>
                @foreach($imagem->tags_array as $tag)
                <span class="badge bg-blue-lt text-blue">{{ $tag }}</span>
                @endforeach
            </div>
            @endif
        </div>
        @endif
    </div>

</x-app-layout>
