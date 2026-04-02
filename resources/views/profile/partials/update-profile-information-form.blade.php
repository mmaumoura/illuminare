<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    {{-- Nome --}}
    <div class="mb-3">
        <label class="form-label" for="name">Nome completo</label>
        <input id="name" type="text" name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- E-mail --}}
    <div class="mb-3">
        <label class="form-label" for="email">E-mail</label>
        <input id="email" type="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2">
            <p class="text-muted">
                Seu e-mail não está verificado.
                <button form="send-verification"
                        class="btn btn-link p-0 text-decoration-none"
                        style="color:var(--tblr-primary);">
                    Clique aqui para reenviar o e-mail de verificação.
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success mt-2">
                Um novo link de verificação foi enviado para o seu e-mail.
            </div>
            @endif
        </div>
        @endif
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-primary">Salvar</button>

        @if (session('status') === 'profile-updated')
        <span class="text-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 12l5 5l10 -10"/>
            </svg>
            Salvo com sucesso!
        </span>
        @endif
    </div>
</form>
