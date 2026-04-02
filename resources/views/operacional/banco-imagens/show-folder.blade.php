<x-app-layout>

    @push('styles')
    <style>
        .img-thumb { width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 6px; cursor: pointer; transition: transform .15s; }
        .img-thumb:hover { transform: scale(1.03); }
    </style>
    @endpush

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $pasta->nome }}</h2>
            <p class="text-muted mt-1">
                {{ $pasta->images->count() }} {{ Str::plural('imagem', $pasta->images->count()) }}
                @if($pasta->clinic) · {{ $pasta->clinic->name }} @endif
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('operacional.banco-imagens.pasta.create-image', $pasta) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                Adicionar Imagem
            </a>
            <a href="{{ route('operacional.banco-imagens.index') }}" class="btn btn-secondary">
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

    @if($pasta->images->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <h3>Pasta vazia</h3>
            <a href="{{ route('operacional.banco-imagens.pasta.create-image', $pasta) }}" class="btn btn-primary">Adicionar Imagem</a>
        </div>
    </div>
    @else
    <div class="row row-cards">
        @foreach($pasta->images as $imagem)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="card card-sm">
                <a href="{{ route('operacional.banco-imagens.show', $imagem) }}">
                    <img src="{{ Storage::url($imagem->arquivo_path) }}" alt="{{ $imagem->titulo }}"
                         class="img-thumb card-img-top">
                </a>
                <div class="card-body">
                    <div class="fw-semibold">{{ $imagem->titulo }}</div>
                    @if($imagem->descricao)
                    <div class="text-muted small">{{ Str::limit($imagem->descricao, 60) }}</div>
                    @endif
                    @if($imagem->tags)
                    <div class="mt-1">
                        @foreach($imagem->tags_array as $tag)
                        <span class="badge bg-blue-lt text-blue">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="card-footer d-flex gap-1">
                    <a href="{{ Storage::url($imagem->arquivo_path) }}" target="_blank"
                       class="btn btn-sm flex-fill">Download</a>
                    <form method="POST" action="{{ route('operacional.banco-imagens.destroy', $imagem) }}"
                          onsubmit="return confirm('Excluir esta imagem?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-ghost-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</x-app-layout>
