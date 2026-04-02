<x-app-layout>

    <div class="row mb-3 align-items-center">
        <div class="col">
            <h2 class="page-title">Modelos de Contrato</h2>
            <p class="text-muted mt-1">Crie e gerencie os modelos usados para gerar contratos com pacientes</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('gestao.contratos-modelos.create') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14"/><path d="M5 12l14 0"/>
                </svg>
                Novo Modelo
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Variáveis disponíveis --}}
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">Variáveis disponíveis para sincronização</h3>
            <div class="card-options">
                <a href="#" class="card-options-collapse" data-bs-toggle="collapse" data-bs-target="#card-variaveis">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6"/></svg>
                </a>
            </div>
        </div>
        <div class="collapse" id="card-variaveis">
            <div class="card-body">
                <p class="text-muted small mb-3">Use as variáveis abaixo no conteúdo do modelo. Ao sincronizar com um paciente, elas serão substituídas pelos dados reais.</p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <h5 class="mb-2">Paciente</h5>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach(['{nome_completo}' => 'Nome completo', '{email}' => 'E-mail', '{telefone}' => 'Telefone', '{data_nascimento}' => 'Data de nascimento', '{cpf}' => 'CPF', '{rg}' => 'RG', '{cep}' => 'CEP', '{logradouro}' => 'Logradouro', '{numero}' => 'Número', '{complemento}' => 'Complemento', '{bairro}' => 'Bairro', '{cidade}' => 'Cidade', '{estado}' => 'Estado (UF)', '{endereco_completo}' => 'Endereço completo', '{data_hoje}' => 'Data de hoje'] as $var => $desc)
                            <span class="badge bg-blue-lt text-blue" title="{{ $desc }}">{{ $var }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-2">Empresa / Unidade</h5>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach(['{unidade}' => 'Nome fantasia', '{empresa_razao_social}' => 'Razão Social', '{empresa_cnpj}' => 'CNPJ', '{empresa_telefone}' => 'Telefone', '{empresa_email}' => 'E-mail', '{empresa_logradouro}' => 'Logradouro', '{empresa_numero}' => 'Número', '{empresa_complemento}' => 'Complemento', '{empresa_bairro}' => 'Bairro', '{empresa_cidade}' => 'Cidade', '{empresa_estado}' => 'Estado (UF)', '{empresa_cep}' => 'CEP', '{empresa_endereco_completo}' => 'Endereço completo', '{empresa_responsavel}' => 'Representante legal', '{empresa_responsavel_cpf}' => 'CPF do representante'] as $var => $desc)
                            <span class="badge bg-green-lt text-green" title="{{ $desc }}">{{ $var }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body border-bottom py-3">
            <div class="d-flex align-items-center">
                <div class="text-secondary">
                    {{ $templates->total() }} modelo(s) cadastrado(s)
                </div>
                <div class="ms-auto text-secondary">
                    Pesquisar:
                    <div class="ms-2 d-inline-block">
                        <form method="GET" action="{{ route('gestao.contratos-modelos.index') }}">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="form-control form-control-sm" placeholder="Buscar por título ou tipo">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Prévia do Conteúdo</th>
                        <th class="w-1">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $template)
                    <tr>
                        <td class="fw-semibold">{{ $template->title }}</td>
                        <td><span class="badge bg-purple-lt">{{ $template->type }}</span></td>
                        <td class="text-muted" style="max-width:400px">
                            <span class="text-truncate d-block" style="overflow:hidden;white-space:nowrap;max-width:400px">
                                {{ Str::limit(strip_tags($template->content), 80) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('gestao.contratos-modelos.edit', $template) }}"
                                   class="btn btn-sm btn-ghost-primary" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"/><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('gestao.contratos-modelos.destroy', $template) }}"
                                      onsubmit="return confirm('Excluir o modelo \'{{ addslashes($template->title) }}\'?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-ghost-danger" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-2" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"/></svg>
                            <p class="mb-0">Nenhum modelo de contrato cadastrado</p>
                            <a href="{{ route('gestao.contratos-modelos.create') }}" class="btn btn-primary mt-3">Criar Primeiro Modelo</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($templates->hasPages())
        <div class="card-footer d-flex align-items-center">
            {{ $templates->links() }}
        </div>
        @endif
    </div>

</x-app-layout>
