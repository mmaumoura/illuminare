<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Criar Nova Tarefa</h2>
            <p class="text-muted mt-1">Preencha os dados da nova tarefa</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('crm.tarefas.index') }}" class="btn btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

    <form method="POST" action="{{ route('crm.tarefas.store') }}">
        @csrf

        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label required">Título *</label>
                        <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ old('titulo') }}" placeholder="Digite o título da tarefa" required>
                        @error('titulo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">Responsável *</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('user_id') ? '' : 'selected' }}>Selecione...</option>
                            @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('user_id', auth()->id()) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">Tipo *</label>
                        <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                            <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>Selecione...</option>
                            <option value="ligacao"  {{ old('tipo') === 'ligacao'  ? 'selected' : '' }}>Ligação</option>
                            <option value="email"    {{ old('tipo') === 'email'    ? 'selected' : '' }}>E-mail</option>
                            <option value="reuniao"  {{ old('tipo') === 'reuniao'  ? 'selected' : '' }}>Reunião</option>
                            <option value="follow_up"{{ old('tipo') === 'follow_up'? 'selected' : '' }}>Follow-up</option>
                            <option value="outro"    {{ old('tipo') === 'outro'    ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('tipo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label required">Prioridade *</label>
                        <select name="prioridade" class="form-select @error('prioridade') is-invalid @enderror" required>
                            <option value="" disabled {{ old('prioridade') ? '' : 'selected' }}>Selecione...</option>
                            <option value="baixa"   {{ old('prioridade') === 'baixa'   ? 'selected' : '' }}>Baixa</option>
                            <option value="media"   {{ old('prioridade') === 'media'   ? 'selected' : '' }}>Média</option>
                            <option value="alta"    {{ old('prioridade') === 'alta'    ? 'selected' : '' }}>Alta</option>
                            <option value="urgente" {{ old('prioridade') === 'urgente' ? 'selected' : '' }}>Urgente</option>
                        </select>
                        @error('prioridade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label required">Status *</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pendente"     {{ old('status', 'pendente') === 'pendente'     ? 'selected' : '' }}>Pendente</option>
                            <option value="em_andamento" {{ old('status') === 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="concluida"    {{ old('status') === 'concluida'    ? 'selected' : '' }}>Concluída</option>
                            <option value="cancelada"    {{ old('status') === 'cancelada'    ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Data de Vencimento</label>
                        <input type="datetime-local" name="data_vencimento"
                               class="form-control @error('data_vencimento') is-invalid @enderror"
                               value="{{ old('data_vencimento') }}">
                        @error('data_vencimento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Relacionado a --}}
                    <div class="col-12">
                        <label class="form-label">Relacionado a</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <select name="taskable_type" id="taskableType" class="form-select">
                                    <option value="">Nenhum</option>
                                    <option value="App\Models\CrmClient"  {{ old('taskable_type', $taskableType) === 'App\Models\CrmClient'  ? 'selected' : '' }}>Cliente</option>
                                    <option value="App\Models\Lead"       {{ old('taskable_type', $taskableType) === 'App\Models\Lead'       ? 'selected' : '' }}>Lead</option>
                                    <option value="App\Models\Opportunity"{{ old('taskable_type', $taskableType) === 'App\Models\Opportunity'? 'selected' : '' }}>Oportunidade</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <select name="taskable_id" id="taskableId" class="form-select">
                                    <option value="">Selecione primeiro o tipo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror"
                                  placeholder="Descreva detalhes da tarefa...">{{ old('descricao') }}</textarea>
                        @error('descricao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M6 4h10l4 4v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2"/>
                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0-4 0"/><path d="M14 4l0 4l-6 0l0-4"/>
                </svg>
                Salvar Tarefa
            </button>
            <a href="{{ route('crm.tarefas.index') }}" class="btn btn-ghost-secondary">Cancelar</a>
        </div>

    </form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('taskableType');
    const idSelect   = document.getElementById('taskableId');

    const options = {
        'App\\Models\\CrmClient': @json($clients->map(fn($c) => ['id' => $c->id, 'label' => $c->nome_completo])),
        'App\\Models\\Lead':      @json($leads->map(fn($l) => ['id' => $l->id, 'label' => $l->nome_completo])),
        'App\\Models\\Opportunity': @json($oporti->map(fn($o) => ['id' => $o->id, 'label' => $o->titulo])),
    };

    const selectedId = '{{ old('taskable_id', $taskableId) }}';

    function populateIds(type) {
        idSelect.innerHTML = '<option value="">Selecione</option>';
        if (!type || !options[type]) {
            idSelect.innerHTML = '<option value="">Selecione primeiro o tipo</option>';
            return;
        }
        options[type].forEach(item => {
            const opt = document.createElement('option');
            opt.value = item.id;
            opt.textContent = item.label;
            if (selectedId && String(item.id) === String(selectedId)) opt.selected = true;
            idSelect.appendChild(opt);
        });
    }

    typeSelect.addEventListener('change', function () { populateIds(this.value); });

    // Init on load if pre-filled
    if (typeSelect.value) populateIds(typeSelect.value);
});
</script>
@endpush

</x-app-layout>
