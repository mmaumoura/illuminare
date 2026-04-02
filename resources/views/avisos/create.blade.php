<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Novo Aviso</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.avisos.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible mb-3" role="alert">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('operacional.avisos.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            {{-- Coluna principal --}}
            <div class="col-lg-8">

                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Título</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <input type="text" name="type" class="form-control @error('type') is-invalid @enderror"
                                   placeholder="Ex: Comunicado, Aviso, Urgente" value="{{ old('type') }}">
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Conteúdo</label>
                            <textarea name="content" rows="6"
                                      class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Imagem / Anexo</label>
                            <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx">
                            <div class="form-hint">Formatos aceitos: Imagens, PDF, DOC, DOCX (Máx: 5MB)</div>
                            @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- Coluna lateral --}}
            <div class="col-lg-4">

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Configurações</h3></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Prioridade</label>
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="" disabled {{ old('priority') ? '' : 'selected' }}>Selecione...</option>
                                <option value="baixa"   {{ old('priority') === 'baixa'   ? 'selected' : '' }}>Baixa</option>
                                <option value="normal"  {{ old('priority') === 'normal'  ? 'selected' : '' }}>Normal</option>
                                <option value="alta"    {{ old('priority') === 'alta'    ? 'selected' : '' }}>Alta</option>
                                <option value="urgente" {{ old('priority') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                            </select>
                            @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Data de Validade</label>
                            <input type="date" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
                                   value="{{ old('expires_at') }}">
                            @error('expires_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-check form-switch">
                                <input type="hidden" name="is_pinned" value="0">
                                <input class="form-check-input" type="checkbox" name="is_pinned" value="1"
                                       {{ old('is_pinned') ? 'checked' : '' }}>
                                <span class="form-check-label">
                                    <strong>Fixar Aviso</strong><br>
                                    <span class="text-muted small">Fixar no topo da lista</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Destinatários --}}
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Unidades e Destinatários</h3></div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label">Unidades</label>
                            <div class="d-flex gap-1 mb-1">
                                <button type="button" class="btn btn-sm btn-ghost-secondary" id="btnSelectAllClinics">Todas</button>
                                <button type="button" class="btn btn-sm btn-ghost-secondary" id="btnClearClinics">Limpar</button>
                            </div>
                            <select name="clinic_ids[]" id="clinicSelect" class="form-select" multiple size="6">
                                @foreach($clinicas as $clinica)
                                <option value="{{ $clinica->id }}"
                                    {{ in_array($clinica->id, (array) old('clinic_ids', [])) ? 'selected' : '' }}>
                                    {{ $clinica->name }}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-hint">Segure Ctrl/Cmd para selecionar múltiplas unidades ou use os botões acima</div>
                        </div>

                        <div class="mb-0">
                            <label class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="sendAllUsers" checked>
                                <span class="form-check-label">Enviar para todos os usuários das unidades selecionadas</span>
                            </label>

                            <div id="specificUsersWrapper" style="display:none">
                                <label class="form-label">Destinatários Específicos</label>
                                <p class="text-muted small" id="selectClinicsFirst">Selecione as unidades primeiro</p>
                                <select name="user_ids[]" id="userSelect" class="form-select" multiple size="5" style="display:none">
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <button type="submit" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"/>
                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M14 4l0 4l-6 0l0 -4"/>
                    </svg>
                    Salvar Aviso
                </button>
                <a href="{{ route('operacional.avisos.index') }}" class="btn btn-ghost-secondary ms-2">Cancelar</a>
            </div>
        </div>

    </form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const clinicSelect      = document.getElementById('clinicSelect');
    const userSelect        = document.getElementById('userSelect');
    const sendAllUsers      = document.getElementById('sendAllUsers');
    const specificWrapper   = document.getElementById('specificUsersWrapper');
    const selectClinicsHint = document.getElementById('selectClinicsFirst');
    const ajaxUrl           = '{{ route('operacional.avisos.users-by-clinic') }}';

    // Botões selecionar todas / limpar unidades
    document.getElementById('btnSelectAllClinics').addEventListener('click', function () {
        Array.from(clinicSelect.options).forEach(o => o.selected = true);
        loadUsers();
    });
    document.getElementById('btnClearClinics').addEventListener('click', function () {
        Array.from(clinicSelect.options).forEach(o => o.selected = false);
        userSelect.innerHTML = '';
        userSelect.style.display = 'none';
        selectClinicsHint.style.display = '';
    });

    // Toggle destinatários específicos
    sendAllUsers.addEventListener('change', function () {
        specificWrapper.style.display = this.checked ? 'none' : '';
        if (!this.checked) loadUsers();
    });

    // Ao mudar seleção de unidades
    clinicSelect.addEventListener('change', function () {
        if (!sendAllUsers.checked) loadUsers();
    });

    function loadUsers() {
        const ids = Array.from(clinicSelect.selectedOptions).map(o => o.value);
        if (ids.length === 0) {
            userSelect.innerHTML = '';
            userSelect.style.display = 'none';
            selectClinicsHint.style.display = '';
            return;
        }

        const params = ids.map(id => 'clinic_ids[]=' + id).join('&');
        fetch(ajaxUrl + '?' + params)
            .then(r => r.json())
            .then(users => {
                userSelect.innerHTML = '';
                users.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = u.name;
                    userSelect.appendChild(opt);
                });
                selectClinicsHint.style.display = 'none';
                userSelect.style.display = users.length ? '' : 'none';
            });
    }
});
</script>
@endpush

</x-app-layout>
