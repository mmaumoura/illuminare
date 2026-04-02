<x-guest-layout>
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Confirmar senha</h2>

            <p class="text-secondary mb-4">
                Esta é uma área segura. Por favor, confirme sua senha para continuar.
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="password">Senha atual</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="current-password" placeholder="••••••••">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn w-100" style="background-color:#A8851E; color:#fff;">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
