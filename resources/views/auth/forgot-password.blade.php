<x-guest-layout>
    <h2 class="h2 mb-1" style="color:#1a1a1a;">Esqueci minha senha</h2>
    <p class="text-muted mb-4">
        Informe seu e-mail e enviaremos um link para você redefinir sua senha.
    </p>

    {{-- Status --}}
    @if (session('status'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" autocomplete="off" novalidate>
        @csrf

        {{-- E-mail --}}
        <div class="mb-4">
            <label class="form-label" for="email">E-mail</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus
                   placeholder="seu@email.com">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn w-100 py-2 mb-3"
                style="background-image: linear-gradient(174deg, #CAA153 0%, #A8851E 100%); color:#fff; border:none; font-weight:600;">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <rect x="3" y="5" width="18" height="14" rx="2"/>
                <polyline points="3 7 12 13 21 7"/>
            </svg>
            Enviar link de redefinição
        </button>
    </form>

    <div class="text-center">
        <a href="{{ route('login') }}" class="text-decoration-none" style="color:#A8851E;">
            &larr; Voltar para o login
        </a>
    </div>
</x-guest-layout>
