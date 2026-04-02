<x-guest-layout>
    <h2 class="h2 mb-1" style="color:#1a1a1a;">Bem-vindo(a) de volta</h2>
    <p class="text-muted mb-4">Entre com suas credenciais para acessar o sistema.</p>

    {{-- Status da sessão --}}
    @if (session('status'))
    <div class="alert alert-success alert-dismissible mb-4" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- E-mail --}}
        <div class="mb-3">
            <label class="form-label" for="email">E-mail</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="seu@email.com">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Senha --}}
        <div class="mb-2">
            <label class="form-label" for="password">
                Senha
                @if (Route::has('password.request'))
                <span class="form-label-description">
                    <a href="{{ route('password.request') }}" class="text-decoration-none"
                       style="color:#A8851E;">Esqueceu a senha?</a>
                </span>
                @endif
            </label>
            <div class="input-group input-group-flat">
                <input id="password" type="password" name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       required autocomplete="current-password" placeholder="••••••••">
                <span class="input-group-text">
                    <a href="#" id="toggle-password" class="link-secondary" title="Mostrar/ocultar senha">
                        {{-- olho fechado (estado inicial: senha oculta) --}}
                        <svg id="eye-show" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="12" cy="12" r="2"/>
                            <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/>
                        </svg>
                        {{-- olho riscado (senha visível) --}}
                        <svg id="eye-hide" xmlns="http://www.w3.org/2000/svg" class="icon d-none" width="24" height="24"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 3l18 18"/>
                            <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83"/>
                            <path d="M9.363 5.365A9.466 9.466 0 0 1 12 5c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341"/>
                        </svg>
                    </a>
                </span>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Lembrar-me --}}
        <div class="mb-4">
            <label class="form-check">
                <input type="checkbox" name="remember" class="form-check-input">
                <span class="form-check-label">Lembrar-me neste dispositivo</span>
            </label>
        </div>

        <button id="btn-login" type="submit" class="btn w-100 py-2"
                style="background-image: linear-gradient(174deg, #CAA153 0%, #A8851E 100%); color:#fff; border:none; font-weight:600;">
            Entrar
        </button>
    </form>
</x-guest-layout>

<script>
document.querySelector('form').addEventListener('submit', function() {
    var btn = document.getElementById('btn-login');
    btn.disabled = true;
    btn.textContent = 'Entrando...';
});

document.getElementById('toggle-password').addEventListener('click', function(e) {
    e.preventDefault();
    var input = document.getElementById('password');
    var eyeShow = document.getElementById('eye-show');
    var eyeHide = document.getElementById('eye-hide');
    if (input.type === 'password') {
        input.type = 'text';
        eyeShow.classList.add('d-none');
        eyeHide.classList.remove('d-none');
    } else {
        input.type = 'password';
        eyeShow.classList.remove('d-none');
        eyeHide.classList.add('d-none');
    }
});
</script>
