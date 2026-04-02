<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Nova Pasta de Imagens</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.banco-imagens.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('operacional.banco-imagens.pastas.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label required">Nome da Pasta</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome') }}" required>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" rows="3" class="form-control">{{ old('descricao') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Unidade</label>
                    <select name="clinic_id" class="form-select">
                        <option value="">Todas as unidades</option>
                        @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                            {{ $clinic->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Criar Pasta</button>
                    <a href="{{ route('operacional.banco-imagens.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
