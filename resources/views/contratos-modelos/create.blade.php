<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">{{ $template ? 'Editar Modelo de Contrato' : 'Novo Modelo de Contrato' }}</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('gestao.contratos-modelos.index') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST"
          action="{{ $template ? route('gestao.contratos-modelos.update', $template) : route('gestao.contratos-modelos.store') }}"
          id="contract-form">
        @csrf
        @if($template) @method('PUT') @endif

        <div class="row g-3">

            {{-- METADADOS --}}
            <div class="col-md-4">

                <div class="card mb-3">
                    <div class="card-header"><h3 class="card-title">Informações do Modelo</h3></div>
                    <div class="card-body row g-3">
                        <div class="col-12">
                            <label class="form-label required">Título</label>
                            <input type="text" name="title" class="form-control"
                                   value="{{ old('title', $template?->title) }}"
                                   placeholder="Ex: Contrato de Tratamento Estético" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label required">Tipo</label>
                            <select name="type" class="form-select" data-no-select2 required>
                                <option value="">Selecione...</option>
                                @foreach($types as $type)
                                <option value="{{ $type }}" @selected(old('type', $template?->type) === $type)>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- VARIÁVEIS --}}
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Variáveis Disponíveis</h3></div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Clique para inserir a variável no texto:</p>

                        <p class="fw-semibold small mb-1 text-blue">Paciente:</p>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach([
                                '{nome_completo}'     => 'Nome completo',
                                '{email}'             => 'E-mail',
                                '{telefone}'          => 'Telefone',
                                '{data_nascimento}'   => 'Data nascimento',
                                '{cpf}'               => 'CPF',
                                '{rg}'                => 'RG',
                                '{cep}'               => 'CEP',
                                '{logradouro}'        => 'Logradouro',
                                '{numero}'            => 'Número',
                                '{complemento}'       => 'Complemento',
                                '{bairro}'            => 'Bairro',
                                '{cidade}'            => 'Cidade',
                                '{estado}'            => 'Estado',
                                '{endereco_completo}' => 'Endereço completo',
                                '{data_hoje}'         => 'Data de hoje',
                            ] as $var => $label)
                            <button type="button"
                                    class="btn btn-sm bg-blue-lt text-blue border-0 var-btn"
                                    data-var="{{ $var }}"
                                    title="{{ $label }}">
                                {{ $var }}
                            </button>
                            @endforeach
                        </div>

                        <p class="fw-semibold small mb-1 text-green">Empresa:</p>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach([
                                '{unidade}'                   => 'Nome fantasia',
                                '{empresa_razao_social}'      => 'Razão Social',
                                '{empresa_cnpj}'              => 'CNPJ',
                                '{empresa_telefone}'          => 'Telefone',
                                '{empresa_email}'             => 'E-mail',
                                '{empresa_logradouro}'        => 'Logradouro',
                                '{empresa_numero}'            => 'Número',
                                '{empresa_complemento}'       => 'Complemento',
                                '{empresa_bairro}'            => 'Bairro',
                                '{empresa_cidade}'            => 'Cidade',
                                '{empresa_estado}'            => 'Estado',
                                '{empresa_cep}'               => 'CEP',
                                '{empresa_endereco_completo}' => 'Endereço completo',
                                '{empresa_responsavel}'       => 'Responsável legal',
                                '{empresa_responsavel_cpf}'   => 'CPF responsável',
                            ] as $var => $label)
                            <button type="button"
                                    class="btn btn-sm bg-green-lt text-green border-0 var-btn"
                                    data-var="{{ $var }}"
                                    title="{{ $label }}">
                                {{ $var }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- EDITOR --}}
            <div class="col-md-8">
                <div class="card h-100">
                    <div class="card-header"><h3 class="card-title">Conteúdo do Contrato</h3></div>
                    <div class="card-body d-flex flex-column" style="min-height:600px">
                        <textarea name="content" id="contract-content" class="form-control d-none">{{ old('content', $template?->content) }}</textarea>
                        <div id="editor-container" class="flex-grow-1"></div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('gestao.contratos-modelos.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary" id="btn-save">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2"/><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/><path d="M14 4l0 4l-6 0l0 -4"/></svg>
                            Salvar Modelo
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>

@push('styles')
<style>
/* CKEditor container fills card */
#editor-container .ck-editor {
    display: flex;
    flex-direction: column;
    height: 100%;
}
#editor-container .ck-editor__main {
    flex: 1;
    overflow-y: auto;
}
#editor-container .ck-editor__editable {
    min-height: 500px;
    font-family: inherit;
    font-size: 0.9rem;
}
/* Highlight variables inside editor */
#editor-container .ck-editor__editable mark {
    background: #dbeafe;
    color: #1d4ed8;
    border-radius: 3px;
    padding: 0 2px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
let editorInstance = null;

ClassicEditor
    .create(document.getElementById('editor-container'), {
        initialData: document.getElementById('contract-content').value,
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                'alignment', '|',
                'bulletedList', 'numberedList', '|',
                'indent', 'outdent', '|',
                'link', 'blockQuote', 'insertTable', 'horizontalLine', '|',
                'undo', 'redo'
            ]
        },
        language: 'pt-br',
    })
    .then(editor => {
        editorInstance = editor;

        // Variable buttons: insert at cursor position
        document.querySelectorAll('.var-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const varText = this.getAttribute('data-var');
                editorInstance.model.change(writer => {
                    const insertPosition = editorInstance.model.document.selection.getFirstPosition();
                    writer.insertText(varText, insertPosition);
                });
                editorInstance.editing.view.focus();
            });
        });
    })
    .catch(err => {
        console.error('CKEditor error:', err);
    });

// Before submit: copy CKEditor HTML to hidden textarea
document.getElementById('contract-form').addEventListener('submit', function () {
    if (editorInstance) {
        document.getElementById('contract-content').value = editorInstance.getData();
    }
});
</script>
@endpush

</x-app-layout>
