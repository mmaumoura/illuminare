<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Adicionar Arquivo</h2>
            <p class="text-muted mt-1">Pasta: <strong>{{ $pasta->nome }}</strong></p>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.treinamentos.pasta.show', $pasta) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('operacional.treinamentos.pasta.store-file', $pasta) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label required">Título</label>
                    <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                           value="{{ old('titulo') }}" required>
                    @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" rows="2" class="form-control">{{ old('descricao') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label required">Tipo de Conteúdo</label>
                    <select name="tipo" id="tipo" class="form-select @error('tipo') is-invalid @enderror" required onchange="toggleFields()">
                        <option value="">Selecione...</option>
                        <option value="pdf"    {{ old('tipo') === 'pdf'    ? 'selected' : '' }}>PDF</option>
                        <option value="imagem" {{ old('tipo') === 'imagem' ? 'selected' : '' }}>Imagem</option>
                        <option value="texto"  {{ old('tipo') === 'texto'  ? 'selected' : '' }}>Texto</option>
                    </select>
                    @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div id="field-arquivo" style="display:none" class="mb-3">
                    <label class="form-label">Arquivo (PDF ou Imagem)</label>
                    <input type="file" name="arquivo" class="form-control @error('arquivo') is-invalid @enderror"
                           accept=".pdf,.jpg,.jpeg,.png,.gif,.webp">
                    <div class="form-hint">Máximo 50 MB.</div>
                    @error('arquivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div id="field-texto" style="display:none" class="mb-3">
                    <label class="form-label">Conteúdo do Texto</label>
                    <textarea name="conteudo_texto" rows="12" class="form-control @error('conteudo_texto') is-invalid @enderror">{{ old('conteudo_texto') }}</textarea>
                    @error('conteudo_texto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('operacional.treinamentos.pasta.show', $pasta) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleFields() {
        const tipo = document.getElementById('tipo').value;
        document.getElementById('field-arquivo').style.display = (tipo === 'pdf' || tipo === 'imagem') ? '' : 'none';
        document.getElementById('field-texto').style.display   = tipo === 'texto' ? '' : 'none';
    }
    toggleFields();
    </script>

</x-app-layout>
