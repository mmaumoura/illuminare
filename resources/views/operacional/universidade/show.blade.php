<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $curso->titulo }}</h2>
            <p class="text-muted mt-1">
                <span class="badge bg-{{ $curso->status_color }}-lt text-{{ $curso->status_color }}">{{ $curso->status_label }}</span>
                @if($curso->instrutor) · {{ $curso->instrutor }} @endif
                @if($curso->carga_horaria) · {{ $curso->carga_horaria_formatted }} @endif
                · {{ $curso->lessons->count() }} {{ Str::plural('aula', $curso->lessons->count()) }}
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('operacional.universidade.aulas.create', $curso) }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/></svg>
                Nova Aula
            </a>
            <a href="{{ route('operacional.universidade.edit', $curso) }}" class="btn btn-outline-secondary">Editar Curso</a>
            <a href="{{ route('operacional.universidade.index') }}" class="btn btn-secondary">
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

    @if($curso->descricao)
    <div class="card mb-3">
        <div class="card-body text-muted">{{ $curso->descricao }}</div>
    </div>
    @endif

    @if($curso->lessons->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5 text-muted">
            <h3>Nenhuma aula cadastrada</h3>
            <a href="{{ route('operacional.universidade.aulas.create', $curso) }}" class="btn btn-primary">Adicionar Primeira Aula</a>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Aulas</h3>
        </div>
        <div class="list-group list-group-flush" id="sortable-aulas">
            @foreach($curso->lessons as $aula)
            <div class="list-group-item" data-id="{{ $aula->id }}">
                <div class="row align-items-center">
                    <div class="col-auto text-muted fw-bold" style="width:2.5rem;">
                        {{ $loop->iteration }}
                    </div>
                    <div class="col-auto">
                        <span class="avatar avatar-sm bg-{{ $aula->tipo_color }}-lt text-{{ $aula->tipo_color }}">
                            @if($aula->tipo === 'video')
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 10l4.553 -2.276a1 1 0 0 1 1.447 .894v6.764a1 1 0 0 1 -1.447 .894l-4.553 -2.276v-4z"/><rect x="3" y="6" width="12" height="12" rx="2"/></svg>
                            @elseif($aula->tipo === 'pdf')
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/></svg>
                            @elseif($aula->tipo === 'link')
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14a3.5 3.5 0 0 0 5 0l4 -4a3.5 3.5 0 0 0 -5 -5l-1.5 1.5"/><path d="M14 10a3.5 3.5 0 0 0 -5 0l-4 4a3.5 3.5 0 0 0 5 5l1.5 -1.5"/></svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/><path d="M9 9l1 0"/><path d="M9 13l6 0"/><path d="M9 17l6 0"/></svg>
                            @endif
                        </span>
                    </div>
                    <div class="col">
                        <a href="{{ route('operacional.universidade.aulas.show', [$curso, $aula]) }}" class="fw-semibold text-reset">
                            {{ $aula->titulo }}
                        </a>
                        <div class="text-muted small">
                            <span class="badge badge-sm bg-{{ $aula->tipo_color }}-lt text-{{ $aula->tipo_color }}">{{ $aula->tipo_label }}</span>
                            @if($aula->duracao_minutos) · {{ $aula->duracao_formatted }} @endif
                        </div>
                    </div>
                    <div class="col-auto d-flex gap-1">
                        <a href="{{ route('operacional.universidade.aulas.show', [$curso, $aula]) }}"
                           class="btn btn-sm btn-ghost-secondary" title="Assistir / Ver">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2"/><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/></svg>
                        </a>
                        <a href="{{ route('operacional.universidade.aulas.edit', [$curso, $aula]) }}"
                           class="btn btn-sm btn-ghost-secondary" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/><path d="M16 5l3 3"/></svg>
                        </a>
                        <form method="POST" action="{{ route('operacional.universidade.aulas.destroy', [$curso, $aula]) }}"
                              onsubmit="return confirm('Excluir esta aula?')">
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
    </div>
    @endif

</x-app-layout>
