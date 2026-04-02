<!doctype html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    <style>@import url('https://rsms.me/inter/inter.css');</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased d-flex flex-column">

<header class="navbar navbar-expand-md d-print-none" data-bs-theme="dark">
    <div class="container-xl">
        <h1 class="navbar-brand d-none-navbar-btn">
            {{ config('app.name') }}
        </h1>
    </div>
</header>

<div class="page-body mt-4">
    <div class="container-xl">
        {{ $slot }}
    </div>
</div>

<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
        <div class="text-center text-muted">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.2.0/dist/signature_pad.umd.min.js"></script>
@stack('scripts')
</body>
</html>
