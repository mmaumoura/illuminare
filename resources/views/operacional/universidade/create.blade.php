<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Novo Curso</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.universidade.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('operacional.universidade.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label required">Título do Curso</label>
                        <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ old('titulo') }}" required>
                        @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="rascunho"  {{ old('status', 'rascunho') === 'rascunho'  ? 'selected' : '' }}>Rascunho</option>
                            <option value="publicado" {{ old('status') === 'publicado' ? 'selected' : '' }}>Publicado</option>
                            <option value="arquivado" {{ old('status') === 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Instrutor / Autor</label>
                        <input type="text" name="instrutor" class="form-control" value="{{ old('instrutor') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Carga Horária (minutos)</label>
                        <input type="number" name="carga_horaria" class="form-control" min="1"
                               value="{{ old('carga_horaria') }}" placeholder="Ex: 120">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Unidade</label>
                        <select name="clinic_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                {{ $clinic->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" rows="4" class="form-control">{{ old('descricao') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Thumbnail (capa do curso)</label>
                        <input type="file" name="thumbnail" class="form-control" accept=".jpg,.jpeg,.png,.webp"
                               onchange="previewThumb(this)">
                        <div class="form-hint">JPG, PNG ou WebP · Máximo 5 MB</div>
                        <img id="thumb-preview" src="#" class="mt-2 img-fluid rounded" style="max-height:150px; display:none;">
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Criar Curso</button>
                    <a href="{{ route('operacional.universidade.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function previewThumb(input) {
        const img = document.getElementById('thumb-preview');
        if (input.files && input.files[0]) {
            const r = new FileReader();
            r.onload = e => { img.src = e.target.result; img.style.display = ''; };
            r.readAsDataURL(input.files[0]);
        }
    }
    </script>

</x-app-layout>
