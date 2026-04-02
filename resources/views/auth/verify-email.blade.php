<x-guest-layout>
    <div class="card card-md">
        <div class="card-body text-center py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg mb-3" width="48" height="48"
                 viewBox="0 0 24 24" fill="none" stroke="#A8851E" stroke-width="1.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <rect x="3" y="5" width="18" height="14" rx="2"/>
                <polyline points="3 7 12 13 21 7"/>
            </svg>

            <h2 class="h2 mb-2">Verifique seu e-mail</h2>
            <p class="text-secondary">
                Enviamos um link de verificação para o seu e-mail.<br>
                Por favor, clique no link para ativar sua conta.
            </p>

            @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success mt-3" role="alert">
                Um novo link de verificação foi enviado para o seu e-mail.
            </div>
            @endif

            <div class="d-flex flex-column gap-2 mt-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn w-100" style="background-color:#A8851E; color:#fff;">
                        Reenviar e-mail de verificação
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-ghost-secondary w-100">Sair</button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
