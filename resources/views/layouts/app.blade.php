@php
    $userSetting  = auth()->user()?->setting;
    $themeMode    = $userSetting?->theme        ?? 'light';
    $themePrimary = $userSetting?->theme_primary ?? null;
    $themeFont    = $userSetting?->theme_font    ?? 'sans-serif';
    $themeRadius  = $userSetting?->theme_radius  ?? '1';

    $colorMap = [
        'blue'   => ['hex' => '#066fd1', 'rgb' => '6, 111, 209'],
        'azure'  => ['hex' => '#45aaf2', 'rgb' => '69, 170, 242'],
        'indigo' => ['hex' => '#6574cd', 'rgb' => '101, 116, 205'],
        'purple' => ['hex' => '#a55eea', 'rgb' => '165, 94, 234'],
        'pink'   => ['hex' => '#f66d9b', 'rgb' => '246, 109, 155'],
        'red'    => ['hex' => '#cd201f', 'rgb' => '205, 32, 31'],
        'orange' => ['hex' => '#fd9644', 'rgb' => '253, 150, 68'],
        'yellow' => ['hex' => '#f1c40f', 'rgb' => '241, 196, 15'],
        'lime'   => ['hex' => '#7bd235', 'rgb' => '123, 210, 53'],
        'green'  => ['hex' => '#5eba00', 'rgb' => '94, 186, 0'],
        'teal'   => ['hex' => '#2bcbba', 'rgb' => '43, 203, 186'],
        'cyan'   => ['hex' => '#17a2b8', 'rgb' => '23, 162, 184'],
    ];
    $fontMap = [
        // Aspas simples: seguro dentro de style="..." no HTML
        'sans-serif' => "'Inter Var', Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif",
        'serif'      => "Georgia, 'Times New Roman', serif",
        'monospace'  => "Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace",
        'comic'      => "'Comic Sans MS', cursive",
    ];
    // Tabler v1.4 usa px (nao rem) e --tblr-border-radius-xxl (nao 2xl)
    // [base, sm, lg, xl, xxl]
    $radiusMap = [
        '0'   => ['0',     '0',    '0',     '0',       '0'],
        '0.5' => ['3px',   '2px',  '4px',   '0.5rem',  '1rem'],
        '1'   => ['6px',   '4px',  '8px',   '1rem',    '2rem'],
        '1.5' => ['9px',   '6px',  '12px',  '1.5rem',  '3rem'],
        '2'   => ['12px',  '8px',  '16px',  '2rem',    '4rem'],
    ];
    $primaryColor = ($themePrimary && isset($colorMap[$themePrimary])) ? $colorMap[$themePrimary] : null;
    $fontStack    = $fontMap[$themeFont]    ?? null;
    $radius       = $radiusMap[$themeRadius] ?? null;

    // Inline style on <html> — specificity (1,0,0,0) beats all stylesheet rules including
    // Tabler's [data-bs-theme=light] rules applied to child elements.
    $htmlStyle = '';
    if ($primaryColor) {
        $htmlStyle .= "--tblr-primary:{$primaryColor['hex']};";
        $htmlStyle .= "--tblr-primary-rgb:{$primaryColor['rgb']};";
        $htmlStyle .= "--tblr-primary-lt:rgba({$primaryColor['rgb']},0.1);";
        $htmlStyle .= "--tblr-link-color:{$primaryColor['hex']};";
    }
    if ($userSetting && $fontStack && $themeFont !== 'sans-serif') {
        $htmlStyle .= "--tblr-body-font-family:{$fontStack};";
    }
    if ($userSetting && $radius && $themeRadius !== '1') {
        $htmlStyle .= "--tblr-border-radius:{$radius[0]};";
        $htmlStyle .= "--tblr-border-radius-sm:{$radius[1]};";
        $htmlStyle .= "--tblr-border-radius-lg:{$radius[2]};";
        $htmlStyle .= "--tblr-border-radius-xl:{$radius[3]};";
        $htmlStyle .= "--tblr-border-radius-xxl:{$radius[4]};";
    }
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="{{ $themeMode }}"{!! $htmlStyle ? ' style="'.$htmlStyle.'"' : '' !!}>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>@import url('https://rsms.me/inter/inter.css');</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <!-- Select2 + Bootstrap 5 theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
    @stack('styles')
</head>
<body class="antialiased">

<div class="page">

    {{-- ============================================================
         SIDEBAR
         ============================================================ --}}
    <aside class="navbar navbar-vertical navbar-expand-lg">
        <div class="container-fluid">
            {{-- Mobile toggle --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Logotipo --}}
            <a href="{{ route('dashboard') }}" class="navbar-brand navbar-brand-autodark">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                     style="color:var(--tblr-primary)">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M12 3l8 4.5v9l-8 4.5l-8 -4.5v-9l8 -4.5" />
                    <path d="M12 12l8 -4.5" />
                    <path d="M12 12v9" />
                    <path d="M12 12l-8 -4.5" />
                </svg>
                <span class="ms-2 fw-bold" style="color:var(--tblr-primary);">{{ config('app.name') }}</span>
            </a>

            {{-- Usuário (mobile) --}}
            <div class="navbar-nav flex-row d-lg-none">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                        <x-user-avatar :user="auth()->user()" size="sm" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">Meu Perfil</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Sair</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Menu recolhível --}}
            <div class="collapse navbar-collapse" id="sidebar-menu">
                @include('layouts.navigation')
            </div>
        </div>
    </aside>

    {{-- ============================================================
         ÁREA PRINCIPAL
         ============================================================ --}}
    <div class="page-wrapper">

        {{-- Topbar --}}
        <div class="navbar-expand-md">
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="navbar">
                    <div class="container-xl">
                        <div class="row flex-fill align-items-center">
                            <div class="col ms-auto d-flex align-items-center gap-3 justify-content-end">

                                {{-- Seletor global de Unidade --}}
                                @if(!empty($canSwitchClinic) && !empty($navClinics) && $navClinics->count())
                                <form method="POST" action="{{ route('clinic.switch') }}" id="clinic-switch-form">
                                    @csrf
                                    <select name="clinic_id" class="form-select form-select-sm" data-no-select2
                                            style="min-width:180px" onchange="this.form.submit()">
                                        <option value="">Todas as unidades</option>
                                        @foreach($navClinics as $c)
                                        <option value="{{ $c->id }}" {{ ($activeClinicId ?? null) == $c->id ? 'selected' : '' }}>
                                            {{ $c->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </form>
                                @endif

                                {{-- Nome e role --}}
                                <div class="d-none d-md-flex flex-column align-items-end">
                                    <span class="fw-semibold lh-1">{{ auth()->user()->name }}</span>
                                    @if(auth()->user()->role)
                                    <small class="text-muted">{{ auth()->user()->role->name }}</small>
                                    @endif
                                </div>

                                {{-- Avatar dropdown --}}
                                <div class="nav-item dropdown d-none d-md-block">
                                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                                        <x-user-avatar :user="auth()->user()" size="sm" :rounded="true" />
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="7" r="4"/><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/></svg>
                                            Meu Perfil
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/><path d="M9 12h12l-3 -3m0 6l3 -3"/></svg>
                                                Sair
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Page header --}}
        @isset($header)
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            {{ $header }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        @endisset

        {{-- Page body --}}
        <div class="page-body">
            <div class="container-xl">
                {{ $slot }}
            </div>
        </div>

        {{-- Footer --}}
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                &copy; {{ date('Y') }}
                                <a href="#" class="link-secondary">{{ config('app.name') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

@include('layouts.partials.theme-settings')
<!-- jQuery (required by DataTables & Select2) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables + Bootstrap 5 integration -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    // ── DataTables ────────────────────────────────────────────────────
    $('table.card-table').each(function () {
        // Skip tables whose tbody has only a colspan "empty state" row
        var $tbody    = $(this).find('tbody');
        var $realRows = $tbody.find('tr').filter(function () {
            return $(this).find('td[colspan]').length === 0;
        });
        if ($realRows.length === 0) return;
        $(this).DataTable({
            paging:    false,
            info:      false,
            searching: true,
            ordering:  true,
            language: {
                search:            '',
                searchPlaceholder: 'Buscar na tabela…',
                zeroRecords:       'Nenhum resultado encontrado.',
                emptyTable:        'Nenhum dado disponível.',
            },
        });
    });

    // ── Select2 ───────────────────────────────────────────────────────
    // Convert inline onchange="this.form.submit()" to jQuery handlers
    // so Select2's .trigger('change') correctly fires them.
    $('select[onchange]').each(function () {
        var fn = $(this).attr('onchange');
        if (fn && fn.indexOf('form.submit') !== -1) {
            $(this).removeAttr('onchange');
            $(this).on('change', function () { $(this).closest('form').submit(); });
        }
    });

    $('select.form-select, select.form-select-sm').not('[data-no-select2]').each(function () {
        var $el      = $(this);
        var isReq    = $el.prop('required');
        var ph       = $el.find('option[value=""]').first().text() || 'Selecione…';
        $el.select2({
            theme:      'bootstrap-5',
            width:      '100%',
            placeholder: ph,
            allowClear: !isReq,
        });
    });
});
</script>
@stack('scripts')
</body>
</html>
