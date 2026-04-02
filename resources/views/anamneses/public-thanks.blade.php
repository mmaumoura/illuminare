<x-public-layout>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="text-center py-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-lg text-success mb-3" width="64" height="64" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10"/>
                </svg>
                <h2>Obrigado!</h2>
                <p class="text-muted fs-3">Sua ficha de anamnese foi enviada com sucesso.</p>

                @if($anamnese->status === 'pendente_assinatura')
                <div class="alert alert-info d-inline-block mt-3">
                    A clínica poderá solicitar sua assinatura por outro link.
                </div>
                @endif
            </div>
        </div>
    </div>

</x-public-layout>
