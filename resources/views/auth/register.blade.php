<x-guest-layout>
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Criar conta</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nome --}}
                <div class="mb-3">
                    <label class="form-label" for="name">Nome completo</label>
                    <input id="name" type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required autofocus autocomplete="name"
                           placeholder="Seu nome">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- E-mail --}}
                <div class="mb-3">
                    <label class="form-label" for="email">E-mail</label>
                    <input id="email" type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autocomplete="username"
                           placeholder="seu@email.com">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Senha --}}
                <div class="mb-3">
                    <label class="form-label" for="password">Senha</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="new-password" placeholder="••••••••">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmar Senha --}}
                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">Confirmar senha</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           required autocomplete="new-password" placeholder="••••••••">
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn w-100" style="background-color:#A8851E; color:#fff;">
                        Criar conta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center text-secondary mt-3">
        Já tem conta? <a href="{{ route('login') }}" class="text-decoration-none" style="color:#A8851E;">Entrar</a>
    </div>
</x-guest-layout>
