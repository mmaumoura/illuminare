<x-guest-layout>
    <h2 class="h2 mb-1" style="color:#1a1a1a;">Redefinir senha</h2>
    <p class="text-muted mb-4">Escolha uma nova senha para a sua conta.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- E-mail --}}
        <div class="mb-3">
            <label class="form-label" for="email">E-mail</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $request->email) }}" required autofocus
                   autocomplete="username" placeholder="seu@email.com">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nova senha --}}
        <div class="mb-3">
            <label class="form-label" for="password">Nova senha</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="new-password" placeholder="••••••••">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirmar nova senha --}}
        <div class="mb-4">
            <label class="form-label" for="password_confirmation">Confirmar nova senha</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror"
                   required autocomplete="new-password" placeholder="••••••••">
            @error('password_confirmation')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn w-100 py-2"
                style="background-image: linear-gradient(174deg, #CAA153 0%, #A8851E 100%); color:#fff; border:none; font-weight:600;">
            Redefinir senha
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-decoration-none" style="color:#A8851E;">
            &larr; Voltar para o login
        </a>
    </div>
</x-guest-layout>
