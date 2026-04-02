<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    {{-- ══════════════════════════════════════════════════════════════
         BOAS-VINDAS
         ══════════════════════════════════════════════════════════════ --}}
    <div class="row mb-3 align-items-center">
        <div class="col">
            <div class="card" style="border-left:4px solid var(--tblr-primary); background: linear-gradient(135deg, var(--tblr-card-bg, #fff) 60%, rgba(var(--tblr-primary-rgb),.06) 100%);">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <x-user-avatar :user="auth()->user()" size="lg" :rounded="true" />
                        </div>
                        <div class="col">
                            <h3 class="mb-0">Olá, {{ auth()->user()->name }}! 👋</h3>
                            <div class="text-secondary">
                                {{ now()->format('l, d \d\e F \d\e Y') }} ·
                                <span class="badge ms-1" style="background-color:var(--tblr-primary);color:#fff;">{{ auth()->user()->role?->name ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="col-auto d-none d-md-flex gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4"/><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg>
                                Meu Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         KPIs — LINHA 1 (FINANCEIRO + AGENDA)
         ══════════════════════════════════════════════════════════════ --}}
    <div class="row row-deck row-cards mb-3">

        {{-- Vendas do Mês --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="subheader">Vendas este Mês</div>
                        <div class="ms-auto">
                            <span class="badge bg-green-lt text-green">+25 vendas</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <div class="h1 mb-0 me-2">R$ 27.040,30</div>
                    </div>
                    <div class="d-flex mt-3">
                        <div class="text-muted">26 vendas no total</div>
                        <div class="ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon text-green" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="3 17 9 11 13 15 21 7"/><polyline points="14 7 21 7 21 14"/></svg>
                        </div>
                    </div>
                    <div class="progress progress-sm mt-2">
                        <div class="progress-bar bg-green" style="width:80%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Saldo Financeiro --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="subheader">Saldo Financeiro</div>
                        <div class="ms-auto">
                            <span class="badge bg-primary-lt text-primary">Mês atual</span>
                        </div>
                    </div>
                    <div class="h1 mb-0">R$ 17.428,55</div>
                    <div class="mt-3 d-flex gap-3">
                        <div>
                            <span class="text-green fw-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
                                +R$ 27.040,28
                            </span>
                            <div class="text-muted" style="font-size:.75rem;">Receitas</div>
                        </div>
                        <div>
                            <span class="text-red fw-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                -R$ 9.711,73
                            </span>
                            <div class="text-muted" style="font-size:.75rem;">Despesas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Agendamentos Hoje --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="subheader">Agendamentos Hoje</div>
                        <div class="ms-auto">
                            <span class="badge bg-azure-lt text-azure">66 próximos</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <div class="h1 mb-0 me-2">13</div>
                        <div class="text-muted">de 180 total</div>
                    </div>
                    <div class="progress progress-sm mt-3">
                        <div class="progress-bar bg-azure" style="width:7%"></div>
                    </div>
                    <div class="mt-2 text-muted" style="font-size:.8rem;">7% do total de agendamentos</div>
                </div>
            </div>
        </div>

        {{-- Tarefas Pendentes --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="subheader">Tarefas Pendentes</div>
                        <div class="ms-auto">
                            <span class="badge bg-yellow-lt text-yellow">4 total</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                        <div class="h1 mb-0 me-2">1</div>
                        <div class="text-muted">3 concluídas</div>
                    </div>
                    <div class="progress progress-sm mt-3">
                        <div class="progress-bar bg-yellow" style="width:75%"></div>
                    </div>
                    <div class="mt-2 text-muted" style="font-size:.8rem;">75% das tarefas concluídas</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════
         KPIs — LINHA 2 (OPERACIONAL)
         ══════════════════════════════════════════════════════════════ --}}
    <div class="row row-deck row-cards mb-3">

        {{-- Pacientes --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar rounded" style="background-color:rgba(var(--tblr-primary-rgb),.15);color:var(--tblr-primary);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M16 11h6m-3-3v6"/></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">2.716</div>
                            <div class="text-secondary">Pacientes Cadastrados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Avisos Ativos --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar rounded" style="background-color:rgba(var(--tblr-warning-rgb),.15);color:var(--tblr-warning);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01"/><path d="M5 19h14a2 2 0 0 0 1.84-2.75l-7.1-12.25a2 2 0 0 0-3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"/></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">2 <span class="text-muted fw-normal" style="font-size:.8rem;">/ 4 total</span></div>
                            <div class="text-secondary">Avisos Ativos</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Banco de Imagens --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar rounded" style="background-color:rgba(var(--tblr-purple-rgb),.15);color:var(--tblr-purple);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M4 16l4-4c.928-.893 2.072-.893 3 0l5 5"/><path d="M14 14l1-1c.928-.893 2.072-.893 3 0l2 2"/></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">16</div>
                            <div class="text-secondary">Banco de Imagens</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Usuários --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar rounded" style="background-color:rgba(var(--tblr-cyan-rgb),.15);color:var(--tblr-cyan);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0-3-3.85"/></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">23 <span class="text-muted fw-normal" style="font-size:.8rem;">usuários</span></div>
                            <div class="text-secondary">7 Unidades ativas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════
         GRÁFICOS — RECEITAS/DESPESAS + UNIDADES POR STATUS
         ══════════════════════════════════════════════════════════════ --}}
    <div class="row row-deck row-cards mb-3">

        {{-- Receitas e Despesas --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="19" x2="20" y2="19"/><polyline points="4 15 8 9 12 11 16 6 20 10"/></svg>
                        Receitas e Despesas
                    </h3>
                    <div class="card-options">
                        <span class="text-muted" style="font-size:.8rem;">Últimos 6 meses</span>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chart-receitas-despesas" style="height:260px;"></div>
                </div>
                <div class="card-footer">
                    <div class="row text-center">
                        <div class="col">
                            <div class="fw-bold text-green">R$ 27.040,28</div>
                            <div class="text-muted" style="font-size:.75rem;">Total Receitas</div>
                        </div>
                        <div class="col border-start">
                            <div class="fw-bold text-red">R$ 9.711,73</div>
                            <div class="text-muted" style="font-size:.75rem;">Total Despesas</div>
                        </div>
                        <div class="col border-start">
                            <div class="fw-bold text-primary">R$ 17.428,55</div>
                            <div class="text-muted" style="font-size:.75rem;">Saldo</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Unidades por Status --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21l18 0"/><path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2-4h14l2 4"/><path d="M5 21l0-10.15"/><path d="M19 21l0-10.15"/><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"/></svg>
                        Unidades por Status
                    </h3>
                </div>
                <div class="card-body d-flex flex-column align-items-center py-4">
                    <div id="chart-unidades" style="height:200px;width:200px;"></div>
                    <div class="mt-3 w-100">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge me-2" style="background:var(--tblr-primary);width:10px;height:10px;border-radius:50%;padding:0;">&nbsp;</span>
                            <span class="flex-fill">Ativas</span>
                            <strong>7</strong>
                            <span class="text-muted ms-2">100%</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge me-2" style="background:#dee2e6;width:10px;height:10px;border-radius:50%;padding:0;">&nbsp;</span>
                            <span class="flex-fill">Outras</span>
                            <strong>0</strong>
                            <span class="text-muted ms-2">0%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════
         CURSOS + TREINAMENTOS + RESUMO OPERACIONAL
         ══════════════════════════════════════════════════════════════ --}}
    <div class="row row-deck row-cards mb-3">

        {{-- Estatísticas de Cursos --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 9l-10-4l-10 4l10 4l10-4v6"/><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"/></svg>
                        Estatísticas de Cursos
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="p-3 rounded text-center" style="background:rgba(var(--tblr-primary-rgb),.07);">
                                <div class="h2 mb-0 text-primary">0</div>
                                <div class="text-muted" style="font-size:.75rem;">Total de Cursos</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded text-center" style="background:rgba(var(--tblr-success-rgb),.07);">
                                <div class="h2 mb-0 text-success">0</div>
                                <div class="text-muted" style="font-size:.75rem;">Cursos Ativos</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded text-center" style="background:rgba(var(--tblr-azure-rgb),.07);">
                                <div class="h2 mb-0 text-azure">4</div>
                                <div class="text-muted" style="font-size:.75rem;">Matrículas Ativas</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded text-center" style="background:rgba(var(--tblr-warning-rgb),.07);">
                                <div class="h2 mb-0 text-yellow">0</div>
                                <div class="text-muted" style="font-size:.75rem;">Concluídas</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted" style="font-size:.8rem;">Taxa de Conclusão</span>
                            <span class="fw-semibold">0%</span>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted" style="font-size:.8rem;">Treinamentos Disponíveis</span>
                            <span class="fw-semibold text-primary">107</span>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-purple" style="width:100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resumo Operacional --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="4" y="4" width="6" height="6" rx="1"/><rect x="14" y="4" width="6" height="6" rx="1"/><rect x="4" y="14" width="6" height="6" rx="1"/><rect x="14" y="14" width="6" height="6" rx="1"/></svg>
                        Resumo Operacional
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center py-3 border-bottom">
                        <span class="avatar avatar-sm rounded me-3" style="background:rgba(var(--tblr-primary-rgb),.12);color:var(--tblr-primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg>
                        </span>
                        <div class="flex-fill">
                            <div class="fw-medium">Usuários</div>
                            <div class="text-muted" style="font-size:.8rem;">Total de usuários no sistema</div>
                        </div>
                        <span class="h3 mb-0 text-primary">23</span>
                    </div>
                    <div class="d-flex align-items-center py-3 border-bottom">
                        <span class="avatar avatar-sm rounded me-3" style="background:rgba(var(--tblr-success-rgb),.12);color:var(--tblr-success);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21l18 0"/><path d="M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"/></svg>
                        </span>
                        <div class="flex-fill">
                            <div class="fw-medium">Unidades Ativas</div>
                            <div class="text-muted" style="font-size:.8rem;">100% operacionais</div>
                        </div>
                        <span class="h3 mb-0 text-success">7</span>
                    </div>
                    <div class="d-flex align-items-center py-3 border-bottom">
                        <span class="avatar avatar-sm rounded me-3" style="background:rgba(var(--tblr-purple-rgb),.12);color:var(--tblr-purple);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M17 21h-10a2 2 0 0 1-2-2v-14a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z"/></svg>
                        </span>
                        <div class="flex-fill">
                            <div class="fw-medium">Documentos</div>
                            <div class="text-muted" style="font-size:.8rem;">Cadastrados no sistema</div>
                        </div>
                        <span class="h3 mb-0 text-purple">0</span>
                    </div>
                    <div class="d-flex align-items-center py-3">
                        <span class="avatar avatar-sm rounded me-3" style="background:rgba(var(--tblr-warning-rgb),.12);color:var(--tblr-warning);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M4 16l4-4c.928-.893 2.072-.893 3 0l5 5"/></svg>
                        </span>
                        <div class="flex-fill">
                            <div class="fw-medium">Banco de Imagens</div>
                            <div class="text-muted" style="font-size:.8rem;">Imagens disponíveis</div>
                        </div>
                        <span class="h3 mb-0 text-yellow">16</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Atividades Recentes --}}
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/></svg>
                        Atividades Recentes
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @php
                            $atividades = [
                                ['nome' => 'Pollyanna Niedja dos Santos', 'hora' => '11:07', 'acao' => 'Realizou atendimento'],
                                ['nome' => 'Pollyanna Niedja dos Santos', 'hora' => '11:07', 'acao' => 'Atualizou cadastro'],
                                ['nome' => 'Pollyanna Niedja dos Santos', 'hora' => '11:07', 'acao' => 'Cadastrou paciente'],
                                ['nome' => 'Pollyanna Niedja dos Santos', 'hora' => '11:07', 'acao' => 'Registrou venda'],
                                ['nome' => 'Pollyanna Niedja dos Santos', 'hora' => '11:07', 'acao' => 'Adicionou imagem'],
                            ];
                        @endphp
                        @foreach($atividades as $i => $a)
                        <div class="list-group-item px-3 py-2">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-sm rounded-circle" style="background:rgba(var(--tblr-primary-rgb),.12);color:var(--tblr-primary);font-weight:700;font-size:.75rem;">
                                        {{ strtoupper(substr($a['nome'],0,1)) }}
                                    </span>
                                </div>
                                <div class="col text-truncate">
                                    <div class="fw-medium text-truncate" style="font-size:.85rem;">{{ $a['nome'] }}</div>
                                    <div class="text-muted" style="font-size:.75rem;">{{ $a['acao'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <span class="text-muted" style="font-size:.75rem;">{{ $a['hora'] }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════
         ÚLTIMAS VENDAS
         ══════════════════════════════════════════════════════════════ --}}
    <div class="row row-deck row-cards mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="6" cy="19" r="2"/><circle cx="17" cy="19" r="2"/><path d="M17 17h-11v-14h-2"/><path d="M6 5l14 1l-1 7h-13"/></svg>
                        Últimas Vendas
                    </h3>
                    <div class="card-options">
                        <a href="#" class="btn btn-sm btn-primary">Ver todas</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Data</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Vendedor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $vendas = [
                                ['paciente'=>'Nirailma de Souza Jesus',       'data'=>'09/03/2026', 'valor'=>'R$ 636,00',   'status'=>'Pago', 'vendedor'=>'Milena Simões de Jesus'],
                                ['paciente'=>'Edileia Costa Muniz Silva',      'data'=>'07/03/2026', 'valor'=>'R$ 246,00',   'status'=>'Pago', 'vendedor'=>'Selma Lima Silva Gomes'],
                                ['paciente'=>'Jeferson Pereira da Silva',      'data'=>'07/03/2026', 'valor'=>'R$ 1.797,00', 'status'=>'Pago', 'vendedor'=>'Jacilene Borges Vitório'],
                                ['paciente'=>'Maria José de Souza Quaresma',   'data'=>'06/03/2026', 'valor'=>'R$ 599,00',   'status'=>'Pago', 'vendedor'=>'Selma Lima Silva Gomes'],
                                ['paciente'=>'Lucideia Pacheco Dias',          'data'=>'06/03/2026', 'valor'=>'R$ 1.272,00', 'status'=>'Pago', 'vendedor'=>'Selma Lima Silva Gomes'],
                            ];
                            @endphp
                            @foreach($vendas as $v)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm rounded-circle me-2" style="background:rgba(var(--tblr-primary-rgb),.1);color:var(--tblr-primary);font-weight:700;font-size:.7rem;">
                                            {{ strtoupper(substr($v['paciente'],0,1)) }}
                                        </span>
                                        {{ $v['paciente'] }}
                                    </div>
                                </td>
                                <td class="text-muted">{{ $v['data'] }}</td>
                                <td class="fw-semibold">{{ $v['valor'] }}</td>
                                <td><span class="badge bg-success-lt text-success">{{ $v['status'] }}</span></td>
                                <td class="text-muted">{{ $v['vendedor'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>
    <script>
    (function () {
        var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
        var textColor = isDark ? '#adb5bd' : '#616876';
        var gridColor = isDark ? 'rgba(255,255,255,.06)' : 'rgba(0,0,0,.06)';

        // Pega a cor primária do CSS custom property
        var primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--tblr-primary').trim() || '#066fd1';

        // ── Receitas e Despesas (bar chart) ──
        var chartRD = new ApexCharts(document.getElementById('chart-receitas-despesas'), {
            chart: { type: 'bar', height: 260, toolbar: { show: false }, fontFamily: 'inherit' },
            series: [
                { name: 'Receitas', data: [18200, 21500, 15800, 24300, 19700, 27040] },
                { name: 'Despesas', data: [7200,  9100,  6400,  11200, 8300,  9712]  },
            ],
            xaxis: {
                categories: ['Out', 'Nov', 'Dez', 'Jan', 'Fev', 'Mar'],
                labels: { style: { colors: textColor } },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    style: { colors: textColor },
                    formatter: v => 'R$ ' + (v/1000).toFixed(0) + 'k'
                }
            },
            colors: [primaryColor, '#d63939'],
            plotOptions: { bar: { borderRadius: 4, columnWidth: '60%' } },
            dataLabels: { enabled: false },
            grid: { borderColor: gridColor, strokeDashArray: 4 },
            legend: { position: 'top', labels: { colors: textColor } },
            tooltip: {
                y: { formatter: v => 'R$ ' + v.toLocaleString('pt-BR', {minimumFractionDigits:2}) }
            },
        });
        chartRD.render();

        // ── Unidades por Status (donut) ──
        var chartU = new ApexCharts(document.getElementById('chart-unidades'), {
            chart: { type: 'donut', height: 200, fontFamily: 'inherit' },
            series: [7, 0.01],
            labels: ['Ativas', 'Outras'],
            colors: [primaryColor, '#dee2e6'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: { pie: { donut: { size: '70%', labels: { show: true,
                total: { show: true, label: 'Total', color: textColor,
                    formatter: () => '7'
                }
            }}}},
            tooltip: { y: { formatter: v => Math.round(v) + ' unidades' } },
        });
        chartU.render();
    })();
    </script>
    @endpush

</x-app-layout>

