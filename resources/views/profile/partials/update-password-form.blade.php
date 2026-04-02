<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label class="form-label" for="update_password_current_password">Senha atual</label>
        <input id="update_password_current_password" type="password" name="current_password"
               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
               autocomplete="current-password" placeholder="••••••••">
        @error('current_password', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="update_password_password">Nova senha</label>
        <input id="update_password_password" type="password" name="password"
               class="form-control @error('password', 'updatePassword') is-invalid @enderror"
               autocomplete="new-password" placeholder="••••••••">
        @error('password', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label" for="update_password_password_confirmation">Confirmar nova senha</label>
        <input id="update_password_password_confirmation" type="password" name="password_confirmation"
               class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
               autocomplete="new-password" placeholder="••••••••">
        @error('password_confirmation', 'updatePassword')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">Alterar senha</button>

        @if (session('status') === 'password-updated')
        <span class="text-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 12l5 5l10 -10"/>
            </svg>
            Senha alterada!
        </span>
        @endif
    </div>
</form>
