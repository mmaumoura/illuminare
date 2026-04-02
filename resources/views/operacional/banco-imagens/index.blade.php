<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Banco de Imagens</h2>
            <p class="text-muted mt-1">Imagens organizadas por pastas.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.banco-imagens.pastas.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                Nova Pasta
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($folders->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M4 16l4 -4c.928 -.893 2.072 -.893 3 0l5 5"/><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l2 2"/></svg>
            <h3>Nenhuma pasta cadastrada</h3>
            <a href="{{ route('operacional.banco-imagens.pastas.create') }}" class="btn btn-primary">Criar Pasta</a>
        </div>
    </div>
    @else
    <div class="row row-cards">
        @foreach($folders as $folder)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar bg-blue-lt text-blue">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M4 16l4 -4c.928 -.893 2.072 -.893 3 0l5 5"/><path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l2 2"/></svg>
                            </span>
                        </div>
                        <div class="col">
                            <a href="{{ route('operacional.banco-imagens.pasta.show', $folder) }}" class="fw-semibold text-reset d-block">
                                {{ $folder->nome }}
                            </a>
                            <div class="text-muted small">
                                {{ $folder->images_count }} {{ Str::plural('imagem', $folder->images_count) }}
                                @if($folder->clinic) · {{ $folder->clinic->name }} @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <form method="POST" action="{{ route('operacional.banco-imagens.pasta.destroy', $folder) }}"
                                  onsubmit="return confirm('Excluir pasta e todas as imagens?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @if($folder->descricao)
                    <p class="text-muted small mt-2 mb-0">{{ Str::limit($folder->descricao, 80) }}</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('operacional.banco-imagens.pasta.show', $folder) }}" class="btn btn-sm w-100">
                        Abrir Pasta
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</x-app-layout>
