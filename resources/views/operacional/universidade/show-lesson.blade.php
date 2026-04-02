<x-app-layout>

    {{-- Navigation between lessons --}}
    @php
        $allLessons = $curso->lessons;
        $currentIndex = $allLessons->search(fn($l) => $l->id === $aula->id);
        $prevAula = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextAula = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;
    @endphp

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $aula->titulo }}</h2>
            <p class="text-muted mt-1">
                <span class="badge bg-{{ $aula->tipo_color }}-lt text-{{ $aula->tipo_color }}">{{ $aula->tipo_label }}</span>
                @if($aula->duracao_minutos) · {{ $aula->duracao_formatted }} @endif
                · Curso: <a href="{{ route('operacional.universidade.show', $curso) }}">{{ $curso->titulo }}</a>
            </p>
        </div>
        <div class="col-auto d-flex gap-2">
            <a href="{{ route('operacional.universidade.aulas.edit', [$curso, $aula]) }}" class="btn btn-outline-secondary">Editar</a>
            <a href="{{ route('operacional.universidade.show', $curso) }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
                Voltar ao Curso
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0 p-md-4">

            {{-- VÍDEO --}}
            @if($aula->tipo === 'video')
                @if($aula->arquivo_path)
                <div class="ratio ratio-16x9">
                    <video controls>
                        <source src="{{ Storage::url($aula->arquivo_path) }}" type="video/mp4">
                        Seu navegador não suporta reprodução de vídeo.
                    </video>
                </div>
                @else
                <div class="text-center py-5 text-muted">Nenhum arquivo de vídeo encontrado.</div>
                @endif

            {{-- LINK EXTERNO --}}
            @elseif($aula->tipo === 'link')
                @if($aula->link_externo)
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $aula->link_externo }}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                </div>
                <div class="mt-3 text-center">
                    <a href="{{ $aula->link_externo }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"/><path d="M11 13l9 -9"/><path d="M15 4h5v5"/></svg>
                        Abrir em Nova Aba
                    </a>
                </div>
                @else
                <div class="text-center py-5 text-muted">Nenhum link informado.</div>
                @endif

            {{-- PDF --}}
            @elseif($aula->tipo === 'pdf')
                @if($aula->arquivo_path)
                <iframe src="{{ Storage::url($aula->arquivo_path) }}" style="width:100%;height:80vh;border:0;"></iframe>
                @else
                <div class="text-center py-5 text-muted">Nenhum arquivo PDF encontrado.</div>
                @endif

            {{-- TEXTO --}}
            @elseif($aula->tipo === 'texto')
                <div class="prose" style="max-width:800px;margin:0 auto;padding:1.5rem;">
                    @if($aula->conteudo_texto)
                    <div style="white-space:pre-wrap;line-height:1.7;font-size:1rem;">{{ $aula->conteudo_texto }}</div>
                    @else
                    <p class="text-muted">Nenhum conteúdo disponível.</p>
                    @endif
                </div>
            @endif

        </div>
    </div>

    {{-- Prev / Next navigation --}}
    <div class="row mt-3">
        <div class="col">
            @if($prevAula)
            <a href="{{ route('operacional.universidade.aulas.show', [$curso, $prevAula]) }}" class="btn btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/></svg>
                {{ $prevAula->titulo }}
            </a>
            @endif
        </div>
        <div class="col-auto text-muted align-self-center">
            Aula {{ $currentIndex + 1 }} de {{ $allLessons->count() }}
        </div>
        <div class="col d-flex justify-content-end">
            @if($nextAula)
            <a href="{{ route('operacional.universidade.aulas.show', [$curso, $nextAula]) }}" class="btn btn-primary">
                {{ $nextAula->titulo }}
                <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M13 18l6 -6"/><path d="M13 6l6 6"/></svg>
            </a>
            @endif
        </div>
    </div>

</x-app-layout>
