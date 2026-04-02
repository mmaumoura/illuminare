<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>@import url('https://rsms.me/inter/inter.css');</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { height: 100%; margin: 0; }

        .auth-split {
            display: flex;
            min-height: 100vh;
        }

        /* Painel esquerdo — identidade visual */
        .auth-brand {
            flex: 0 0 45%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2.5rem;
            background-image: linear-gradient(174deg, #CAA153 0%, #A8851E 100%);
            gap: 1.5rem;
        }

        .auth-brand__logo img {
            filter: drop-shadow(0 4px 16px rgba(0,0,0,.18));
        }

        .auth-brand__name {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            text-align: center;
            line-height: 1.15;
        }

        .auth-brand__tagline {
            font-size: .95rem;
            color: rgba(255,255,255,.82);
            text-align: center;
            max-width: 280px;
            line-height: 1.5;
        }

        /* Painel direito — formulário */
        .auth-form-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            background: #fff;
        }

        .auth-form-inner {
            width: 100%;
            max-width: 420px;
        }

        /* Mobile: painel esquerdo vira topo compacto */
        @media (max-width: 767.98px) {
            .auth-split { flex-direction: column; }
            .auth-brand {
                flex: 0 0 auto;
                padding: 2rem 1.5rem 1.5rem;
                gap: 0.75rem;
            }
            .auth-brand__name  { font-size: 1.5rem; }
            .auth-brand__tagline { display: none; }
            .auth-form-panel { padding: 2rem 1.25rem; }
        }
    </style>
</head>
<body>

<div class="auth-split">

    {{-- ── Painel esquerdo: identidade visual ── --}}
    <div class="auth-brand">
        <div class="auth-brand__logo">
            <img src="{{ asset('logo-lluminare.png') }}" alt="{{ config('app.name') }}" style="max-width:300px; width:100%; filter: drop-shadow(0 4px 16px rgba(0,0,0,.18));">
        </div>
        {{-- <div class="auth-brand__name">{{ config('app.name') }}</div> --}}
        <div class="auth-brand__tagline">
            Sistema de gestão integrado para clínicas e pacientes.
        </div>
    </div>

    {{-- ── Painel direito: slot (formulário) ── --}}
    <div class="auth-form-panel">
        <div class="auth-form-inner">
            {{ $slot }}
        </div>
    </div>

</div>

</body>
</html>
