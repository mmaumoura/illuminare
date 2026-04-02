<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Universidade Corporativa</h2>
            <p class="text-muted mt-1">Cursos e treinamentos da plataforma.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.universidade.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                Novo Curso
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($cursos->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"/><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"/></svg>
            <h3>Nenhum curso cadastrado</h3>
            <a href="{{ route('operacional.universidade.create') }}" class="btn btn-primary">Criar Primeiro Curso</a>
        </div>
    </div>
    @else
    <div class="row row-cards">
        @foreach($cursos as $curso)
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                @if($curso->thumbnail_path)
                <a href="{{ route('operacional.universidade.show', $curso) }}">
                    <img src="{{ Storage::url($curso->thumbnail_path) }}" alt="{{ $curso->titulo }}"
                         class="card-img-top" style="height:180px; object-fit:cover;">
                </a>
                @else
                <a href="{{ route('operacional.universidade.show', $curso) }}"
                   class="card-img-top d-flex align-items-center justify-content-center bg-blue-lt"
                   style="height:140px; text-decoration:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-blue" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"/><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"/></svg>
                </a>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <a href="{{ route('operacional.universidade.show', $curso) }}" class="fw-semibold text-reset">
                            {{ $curso->titulo }}
                        </a>
                        <span class="badge bg-{{ $curso->status_color }}-lt text-{{ $curso->status_color }} ms-2 flex-shrink-0">
                            {{ $curso->status_label }}
                        </span>
                    </div>
                    @if($curso->instrutor)
                    <div class="text-muted small mb-1">{{ $curso->instrutor }}</div>
                    @endif
                    <div class="text-muted small">
                        {{ $curso->lessons_count }} {{ Str::plural('aula', $curso->lessons_count) }}
                        @if($curso->carga_horaria_formatted !== '—')
                        · {{ $curso->carga_horaria_formatted }}
                        @endif
                    </div>
                </div>
                <div class="card-footer d-flex gap-1">
                    <a href="{{ route('operacional.universidade.show', $curso) }}" class="btn btn-sm flex-fill">Abrir</a>
                    <a href="{{ route('operacional.universidade.edit', $curso) }}" class="btn btn-sm btn-ghost-secondary" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                    </a>
                    <form method="POST" action="{{ route('operacional.universidade.destroy', $curso) }}"
                          onsubmit="return confirm('Excluir este curso e todas as aulas?')">
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
