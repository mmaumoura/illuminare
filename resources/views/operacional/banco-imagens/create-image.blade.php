<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Adicionar Imagem</h2>
            <p class="text-muted mt-1">Pasta: <strong>{{ $pasta->nome }}</strong></p>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.banco-imagens.pasta.show', $pasta) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('operacional.banco-imagens.pasta.store-image', $pasta) }}" enctype="multipart/form-data">
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
                    <label class="form-label required">Imagem</label>
                    <input type="file" name="arquivo" id="arquivo"
                           class="form-control @error('arquivo') is-invalid @enderror"
                           accept=".jpg,.jpeg,.png,.gif,.webp" required onchange="previewImage(this)">
                    <div class="form-hint">JPG, PNG, GIF ou WebP · Máximo 20 MB</div>
                    @error('arquivo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <img id="preview" src="#" alt="preview" class="mt-2 img-fluid rounded" style="max-height:300px; display:none;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tags</label>
                    <input type="text" name="tags" class="form-control" value="{{ old('tags') }}"
                           placeholder="antes, depois, harmonização (separadas por vírgula)">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('operacional.banco-imagens.pasta.show', $pasta) }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; preview.style.display = ''; };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

</x-app-layout>
