<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Detalhes do Aviso</h2>
        </div>
        <div class="col-auto d-flex gap-2">
            @if(auth()->user()->isAdministrador() || auth()->user()->isGestor())
            <form method="POST" action="{{ route('operacional.avisos.destroy', $aviso) }}"
                  onsubmit="return confirm('Excluir este aviso?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7"/>
                        <line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/>
                        <path d="M9 7v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
                    </svg>
                    Excluir
                </button>
            </form>
            @endif
            <a href="{{ route('operacional.avisos.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    <div class="row g-3">
        {{-- Conteúdo principal --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    {{-- Cabeçalho --}}
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            @if($aviso->is_pinned)
                            <span class="badge bg-warning-lt me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4v6l-2 4v2h10v-2l-2-4v-6"/><path d="M12 16l0 5"/><path d="M8 4l8 0"/></svg>
                                Fixado
                            </span>
                            @endif
                            @if($aviso->type)
                            <span class="badge bg-blue-lt">{{ $aviso->type }}</span>
                            @endif
                        </div>
                        <span class="badge bg-{{ $aviso->priorityColor() }}-lt fs-6">{{ $aviso->priorityLabel() }}</span>
                    </div>

                    <h2 class="mb-3">{{ $aviso->title }}</h2>

                    <div class="text-body" style="white-space: pre-wrap">{{ $aviso->content }}</div>

                    {{-- Anexo --}}
                    @if($aviso->attachment_path)
                    <div class="mt-3 pt-3 border-top">
                        <a href="{{ Storage::url($aviso->attachment_path) }}" target="_blank" class="btn btn-ghost-secondary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/></svg>
                            {{ $aviso->attachment_name }}
                        </a>
                    </div>
                    @endif

                    {{-- Metadados --}}
                    <div class="mt-3 pt-3 border-top text-muted small d-flex flex-wrap gap-3">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4"/><path d="M5.5 21a8.5 8.5 0 0 1 13 0"/></svg>
                            Autor: <strong>{{ $aviso->author?->name }}</strong>
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="5" width="16" height="16" rx="2"/><path d="M16 3l0 4"/><path d="M8 3l0 4"/><path d="M4 11l16 0"/></svg>
                            Publicado em: <strong>{{ $aviso->created_at->format('d/m/Y H:i') }}</strong>
                        </span>
                        @if($aviso->expires_at)
                        <span>
                            Validade: <strong>{{ $aviso->expires_at->format('d/m/Y') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Lista de destinatários --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Destinatários ({{ $aviso->recipients->count() }})</h3>
                </div>
                <div class="list-group list-group-flush">
                    @forelse($aviso->recipients as $recipient)
                    @php $lido = !is_null($recipient->pivot->read_at); @endphp
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="fw-semibold">{{ $recipient->name }}</div>
                                <div class="text-muted small">{{ $recipient->clinic?->name ?? 'Sem unidade' }}</div>
                            </div>
                            <div class="col-auto">
                                @if($lido)
                                <span class="text-success d-flex align-items-center gap-1" title="Lido em {{ $recipient->pivot->read_at?->format('d/m/Y H:i') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/></svg>
                                    <span class="small">Lido</span>
                                </span>
                                @else
                                <span class="text-muted d-flex align-items-center gap-1" title="Não lido">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9"/><path d="M12 8l0 4"/><path d="M12 16l.01 0"/></svg>
                                    <span class="small">Não lido</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-muted text-center py-3">Nenhum destinatário.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
