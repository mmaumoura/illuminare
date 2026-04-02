<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Editar Aula</h2>
            <p class="text-muted mt-1">Curso: <strong>{{ $curso->titulo }}</strong></p>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.universidade.show', $curso) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('operacional.universidade.aulas.update', [$curso, $aula]) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label required">Título</label>
                        <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ old('titulo', $aula->titulo) }}" required>
                        @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label required">Tipo</label>
                        <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror"
                                onchange="toggleFields(this.value)" required>
                            <option value="video" {{ old('tipo', $aula->tipo) === 'video' ? 'selected' : '' }}>Vídeo (upload)</option>
                            <option value="link"  {{ old('tipo', $aula->tipo) === 'link'  ? 'selected' : '' }}>Link Externo</option>
                            <option value="pdf"   {{ old('tipo', $aula->tipo) === 'pdf'   ? 'selected' : '' }}>PDF</option>
                            <option value="texto" {{ old('tipo', $aula->tipo) === 'texto' ? 'selected' : '' }}>Texto</option>
                        </select>
                        @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Duração (minutos)</label>
                        <input type="number" name="duracao_minutos" class="form-control @error('duracao_minutos') is-invalid @enderror"
                               value="{{ old('duracao_minutos', $aula->duracao_minutos) }}" min="1">
                        @error('duracao_minutos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Upload de arquivo --}}
                    <div class="col-12" id="field-arquivo" style="display:none;">
                        <label class="form-label" id="arquivo-label">Arquivo</label>
                        @if($aula->arquivo_nome)
                        <div class="mb-2 text-muted small">
                            Arquivo atual: <strong>{{ $aula->arquivo_nome }}</strong>
                            ({{ $aula->file_size_formatted }})
                        </div>
                        @endif
                        <input type="file" name="arquivo" id="arquivo" class="form-control @error('arquivo') is-invalid @enderror">
                        <div class="form-text" id="arquivo-hint">Deixe em branco para manter o arquivo atual.</div>
                        @error('arquivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Link externo --}}
                    <div class="col-12" id="field-link" style="display:none;">
                        <label class="form-label">URL / Link Externo</label>
                        <input type="url" name="link_externo" class="form-control @error('link_externo') is-invalid @enderror"
                               value="{{ old('link_externo', $aula->link_externo) }}" placeholder="https://...">
                        @error('link_externo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Conteúdo texto --}}
                    <div class="col-12" id="field-texto" style="display:none;">
                        <label class="form-label">Conteúdo</label>
                        <textarea name="conteudo_texto" class="form-control @error('conteudo_texto') is-invalid @enderror"
                                  rows="10">{{ old('conteudo_texto', $aula->conteudo_texto) }}</textarea>
                        @error('conteudo_texto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror"
                                  rows="3">{{ old('descricao', $aula->descricao) }}</textarea>
                        @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    <a href="{{ route('operacional.universidade.show', $curso) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleFields(tipo) {
        document.getElementById('field-arquivo').style.display = 'none';
        document.getElementById('field-link').style.display   = 'none';
        document.getElementById('field-texto').style.display  = 'none';

        if (tipo === 'video') {
            document.getElementById('field-arquivo').style.display = '';
            document.getElementById('arquivo-label').textContent   = 'Arquivo de Vídeo';
            document.getElementById('arquivo-hint').textContent    = 'Formatos aceitos: mp4, mov, avi, webm. Déixe em branco para manter o atual.';
            document.getElementById('arquivo').setAttribute('accept', 'video/mp4,video/quicktime,video/x-msvideo,video/webm');
        } else if (tipo === 'pdf') {
            document.getElementById('field-arquivo').style.display = '';
            document.getElementById('arquivo-label').textContent   = 'Arquivo PDF';
            document.getElementById('arquivo-hint').textContent    = 'Apenas .pdf. Deixe em branco para manter o atual.';
            document.getElementById('arquivo').setAttribute('accept', '.pdf,application/pdf');
        } else if (tipo === 'link') {
            document.getElementById('field-link').style.display = '';
        } else if (tipo === 'texto') {
            document.getElementById('field-texto').style.display = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const tipoSel = document.getElementById('tipo');
        if (tipoSel.value) toggleFields(tipoSel.value);
    });
    </script>

</x-app-layout>
