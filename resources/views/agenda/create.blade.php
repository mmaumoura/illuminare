<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Novo Agendamento</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('operacional.agenda.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0"/><path d="M5 12l6 6"/><path d="M5 12l6 -6"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('operacional.agenda.store') }}">
        @csrf

        <div class="row g-3">

            {{-- Coluna principal --}}
            <div class="col-lg-8">

                {{-- 1 - Informacoes Basicas --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="avatar avatar-sm me-2 bg-primary text-white" style="font-size:.85rem">1</span>
                        <h3 class="card-title">Informações Básicas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label required">Tipo de Agendamento</label>
                                <select name="type" id="apt-type"
                                        class="form-select @error('type') is-invalid @enderror">
                                    <option value="">Selecione...</option>
                                    @foreach($types as $t)
                                    <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                                @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label required">Título</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Ex: Consulta, Harmonização Facial...">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descrição</label>
                                <textarea name="description" rows="3"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Descrição opcional...">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2 - Data e Hora --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="avatar avatar-sm me-2 bg-primary text-white" style="font-size:.85rem">2</span>
                        <h3 class="card-title">Data e Hora</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Data/Hora Início</label>
                                <input type="datetime-local" name="starts_at"
                                       value="{{ old('starts_at') }}"
                                       class="form-control @error('starts_at') is-invalid @enderror">
                                @error('starts_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Data/Hora Fim</label>
                                <input type="datetime-local" name="ends_at"
                                       value="{{ old('ends_at') }}"
                                       class="form-control @error('ends_at') is-invalid @enderror">
                                @error('ends_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3 - Paciente (apenas para tipo Paciente) --}}
                <div class="card mb-3" id="section-patient" style="display:none">
                    <div class="card-header">
                        <span class="avatar avatar-sm me-2 bg-primary text-white" style="font-size:.85rem">3</span>
                        <h3 class="card-title">Paciente</h3>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Paciente</label>
                                <select name="patient_id"
                                        class="form-select @error('patient_id') is-invalid @enderror">
                                    <option value="">Selecione...</option>
                                    @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Procedimento(s)</label>
                                <select name="procedures[]" multiple
                                        class="form-select @error('procedures') is-invalid @enderror">
                                    @foreach($procedures as $proc)
                                    <option value="{{ $proc->id }}"
                                        {{ in_array($proc->id, old('procedures', [])) ? 'selected' : '' }}>
                                        {{ $proc->name }} — {{ $proc->category }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="form-hint">Segure Ctrl/Cmd para selecionar mais de um</div>
                                @error('procedures')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Observacoes --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Observações</h3>
                    </div>
                    <div class="card-body">
                        <textarea name="observations" rows="4"
                                  class="form-control @error('observations') is-invalid @enderror"
                                  placeholder="Observações internas sobre este agendamento...">{{ old('observations') }}</textarea>
                        @error('observations')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Profissional e Unidade --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Responsável</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label required">Profissional</label>
                            <select name="professional_id" required
                                    class="form-select @error('professional_id') is-invalid @enderror">
                                <option value="">Selecione...</option>
                                @foreach($professionals as $pro)
                                <option value="{{ $pro->id }}" {{ old('professional_id') == $pro->id ? 'selected' : '' }}>
                                    {{ $pro->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('professional_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label required">Unidade</label>
                            @if($userClinicId && $clinics->isNotEmpty())
                                <input type="hidden" name="clinic_id" value="{{ $userClinicId }}">
                                <p class="form-control-plaintext fw-semibold mb-0">{{ $clinics->first()->name }}</p>
                            @else
                                <select name="clinic_id" required
                                        class="form-select @error('clinic_id') is-invalid @enderror">
                                    <option value="">Selecione...</option>
                                    @foreach($clinics as $clinic)
                                    <option value="{{ $clinic->id }}" {{ old('clinic_id') == $clinic->id ? 'selected' : '' }}>
                                        {{ $clinic->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('clinic_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-0">
                            <label class="form-label required">Status</label>
                            <select name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                @foreach($statuses as $s)
                                <option value="{{ $s }}" {{ old('status', 'Agendado') === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Acoes --}}
                <div class="d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2z"/>
                            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            <path d="M14 4l0 4l-6 0l0 -4"/>
                        </svg>
                        Salvar Agendamento
                    </button>
                    <a href="{{ route('operacional.agenda.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>

            </div>
        </div>
    </form>

    @push('scripts')
    <script>
    (function () {
        var typeSelect   = document.getElementById('apt-type');
        var sectionPat   = document.getElementById('section-patient');

        function toggleSections() {
            var val = typeSelect.value;
            if (val === 'Agendamento de Paciente') {
                sectionPat.style.display = '';
            } else {
                sectionPat.style.display = 'none';
            }
        }

        // Use delegated event so it fires even after Select2 wraps the element
        $(document).on('change', '#apt-type', toggleSections);
        // Also run immediately and after Select2 initialisation settles
        setTimeout(toggleSections, 0);

        // Auto-fill end time (+30min) when start changes
        var startsEl = document.querySelector('input[name="starts_at"]');
        var endsEl   = document.querySelector('input[name="ends_at"]');
        startsEl.addEventListener('change', function () {
            if (!endsEl.value && this.value) {
                var d = new Date(this.value);
                d.setMinutes(d.getMinutes() + 30);
                var pad = n => String(n).padStart(2,'0');
                endsEl.value = d.getFullYear() + '-' + pad(d.getMonth()+1) + '-' + pad(d.getDate()) +
                               'T' + pad(d.getHours()) + ':' + pad(d.getMinutes());
            }
        });
    })();
    </script>
    @endpush

</x-app-layout>
