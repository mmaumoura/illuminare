{{-- ================================================================
     Sidebar Navigation
     ================================================================ --}}
<ul class="navbar-nav pt-lg-3">

    {{-- ── DASHBOARD ──────────────────────────────────────────────── --}}
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="12" cy="13" r="2"/>
                    <path d="M13.45 11.55l2.05 -2.05"/>
                    <path d="M6.4 20a6 6 0 1 1 11.2 0z"/>
                </svg>
            </span>
            <span class="nav-link-title">Dashboard</span>
        </a>
    </li>

    {{-- ══════════════════════════════════════════════════════════════
         GESTÃO
         ══════════════════════════════════════════════════════════════ --}}
    <li class="nav-item">
        <div class="hr-text hr-text-center my-3">
            <span class="hr-text-body text-muted" style="font-size:.7rem;">GESTÃO</span>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('gestao.clinicas.*') ? 'active' : '' }}" href="{{ route('gestao.clinicas.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 21l18 0"/>
                    <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4"/>
                    <path d="M5 21l0 -10.15"/>
                    <path d="M19 21l0 -10.15"/>
                    <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4"/>
                </svg>
            </span>
            <span class="nav-link-title">Unidades</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('gestao.procedimentos.*') ? 'active' : '' }}" href="{{ route('gestao.procedimentos.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 5a3 3 0 1 0 0 -6 3 3 0 0 0 0 6z" transform="translate(0 4)"/>
                    <path d="M6 3a3 3 0 1 0 0 -6 3 3 0 0 0 0 6z" transform="translate(0 4)"/>
                    <path d="M18 3a3 3 0 1 0 0 -6 3 3 0 0 0 0 6z" transform="translate(0 4)"/>
                    <path d="M6 21v-7" />
                    <path d="M12 21v-7" />
                    <path d="M18 21v-7" />
                    <path d="M4 14h16" />
                </svg>
            </span>
            <span class="nav-link-title">Procedimentos</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('gestao.contratos-modelos.*') ? 'active' : '' }}" href="{{ route('gestao.contratos-modelos.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                    <path d="M9 17l0 -5"/><path d="M12 17v-1"/><path d="M15 17v-3"/>
                </svg>
            </span>
            <span class="nav-link-title">Modelos de Contrato</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}" href="{{ route('admin.usuarios.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                </svg>
            </span>
            <span class="nav-link-title">Usuários</span>
        </a>
    </li>

    {{-- ══════════════════════════════════════════════════════════════
         OPERACIONAL
         ══════════════════════════════════════════════════════════════ --}}
    <li class="nav-item">
        <div class="hr-text hr-text-center my-3">
            <span class="hr-text-body text-muted" style="font-size:.7rem;">OPERACIONAL</span>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('operacional.agenda.*') ? 'active' : '' }}" href="{{ route('operacional.agenda.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="5" width="16" height="16" rx="2"/>
                    <line x1="16" y1="3" x2="16" y2="7"/><line x1="8" y1="3" x2="8" y2="7"/>
                    <line x1="4" y1="11" x2="20" y2="11"/>
                    <rect x="8" y="15" width="2" height="2"/>
                </svg>
            </span>
            <span class="nav-link-title">Agenda</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('operacional.pacientes.*') ? 'active' : '' }}" href="{{ route('operacional.pacientes.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                    <path d="M16 11h6m-3 -3v6"/>
                </svg>
            </span>
            <span class="nav-link-title">Pacientes</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('operacional.avisos.*') ? 'active' : '' }}" href="{{ route('operacional.avisos.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 9v2m0 4v.01"/>
                    <path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"/>
                </svg>
            </span>
            <span class="nav-link-title">Avisos</span>
        </a>
    </li>

    {{-- ══════════════════════════════════════════════════════════════
         COMERCIAL
         ══════════════════════════════════════════════════════════════ --}}
    <li class="nav-item">
        <div class="hr-text hr-text-center my-3">
            <span class="hr-text-body text-muted" style="font-size:.7rem;">COMERCIAL</span>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('comercial.produtos.*') ? 'active' : '' }}" href="{{ route('comercial.produtos.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3"/>
                    <line x1="12" y1="12" x2="20" y2="7.5"/>
                    <line x1="12" y1="12" x2="12" y2="21"/>
                    <line x1="12" y1="12" x2="4" y2="7.5"/>
                </svg>
            </span>
            <span class="nav-link-title">Produtos</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('comercial.estoque.*') ? 'active' : '' }}" href="{{ route('comercial.estoque.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="3" y="8" width="18" height="4" rx="1"/>
                    <line x1="12" y1="8" x2="12" y2="21"/>
                    <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-7"/>
                    <path d="M7.5 8a2.5 2.5 0 0 1 0 -5a4.8 8 0 0 1 4.5 5a4.8 8 0 0 1 4.5 -5a2.5 2.5 0 0 1 0 5"/>
                </svg>
            </span>
            <span class="nav-link-title">Estoque</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('comercial.metas.*') ? 'active' : '' }}" href="{{ route('comercial.metas.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0"/>
                    <path d="M12 12m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0"/>
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                    <path d="M15 15l3.35 3.35"/>
                </svg>
            </span>
            <span class="nav-link-title">Metas de Venda</span>
        </a>
    </li>

    {{-- ══════════════════════════════════════════════════════════════
         CRM
         ══════════════════════════════════════════════════════════════ --}}
    <li class="nav-item">
        <div class="hr-text hr-text-center my-3">
            <span class="hr-text-body text-muted" style="font-size:.7rem;">CRM</span>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('crm.leads.*') && !request()->routeIs('crm.leads.kanban') && !request()->routeIs('crm.leads.funnel') ? 'active' : '' }}"
           href="{{ route('crm.leads.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                    <path d="M16 11h6m-3 -3v6"/>
                </svg>
            </span>
            <span class="nav-link-title">Leads</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('crm.leads.kanban') ? 'active' : '' }}" href="{{ route('crm.leads.kanban') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="4" y="4" width="6" height="16" rx="1"/><rect x="14" y="4" width="6" height="10" rx="1"/>
                </svg>
            </span>
            <span class="nav-link-title">Kanban de Leads</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('crm.leads.funnel') ? 'active' : '' }}" href="{{ route('crm.leads.funnel') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-9l-4.414 -4.414a2 2 0 0 1 -.586 -1.414v-2.172z"/>
                </svg>
            </span>
            <span class="nav-link-title">Funil de Vendas</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('crm.oportunidades.*') ? 'active' : '' }}" href="{{ route('crm.oportunidades.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                    <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1"/>
                    <path d="M12 6l0 2m0 8l0 2"/>
                </svg>
            </span>
            <span class="nav-link-title">Oportunidades</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('crm.clientes.*') ? 'active' : '' }}" href="{{ route('crm.clientes.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <circle cx="9" cy="7" r="4"/><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/><path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                </svg>
            </span>
            <span class="nav-link-title">Clientes</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('crm.tarefas.*') ? 'active' : '' }}" href="{{ route('crm.tarefas.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="2"/>
                    <path d="M9 12l2 2l4 -4"/>
                </svg>
            </span>
            <span class="nav-link-title">Tarefas CRM</span>
        </a>
    </li>

    {{-- ══════════════════════════════════════════════════════════════
         TREINAMENTO
         ══════════════════════════════════════════════════════════════ --}}
    <li class="nav-item">
        <div class="hr-text hr-text-center my-3">
            <span class="hr-text-body text-muted" style="font-size:.7rem;">TREINAMENTO</span>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('operacional.treinamentos.*') ? 'active' : '' }}" href="{{ route('operacional.treinamentos.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0"/>
                    <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0"/>
                    <line x1="3" y1="6" x2="3" y2="19"/>
                    <line x1="12" y1="6" x2="12" y2="19"/>
                    <line x1="21" y1="6" x2="21" y2="19"/>
                </svg>
            </span>
            <span class="nav-link-title">Treinamentos</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('operacional.banco-imagens.*') ? 'active' : '' }}" href="{{ route('operacional.banco-imagens.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <path d="M4 16l4 -4c.928 -.893 2.072 -.893 3 0l5 5"/>
                    <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l2 2"/>
                </svg>
            </span>
            <span class="nav-link-title">Banco de Imagens</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('operacional.universidade.*') ? 'active' : '' }}" href="{{ route('operacional.universidade.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6"/>
                    <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"/>
                </svg>
            </span>
            <span class="nav-link-title">Universidade Corporativa</span>
        </a>
    </li>

</ul>