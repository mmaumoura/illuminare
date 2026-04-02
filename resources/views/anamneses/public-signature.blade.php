<x-public-layout>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="text-center mb-4">
                <h2>Assinatura da Anamnese</h2>
                <p class="text-muted">Paciente: <strong>{{ $anamnese->patient->name }}</strong></p>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Resumo da Anamnese --}}
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Resumo da Anamnese</h3></div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6"><span class="text-muted">Data:</span> {{ $anamnese->anamnesis_date->format('d/m/Y') }}</div>
                        @if($anamnese->chief_complaint)<div class="col-12"><span class="text-muted">Queixa Principal:</span> {{ $anamnese->chief_complaint }}</div>@endif
                        @if($anamnese->treatment_objective)<div class="col-12"><span class="text-muted">Objetivo:</span> {{ $anamnese->treatment_objective }}</div>@endif
                    </div>
                </div>
            </div>

            @if($anamnese->signature_data)
            {{-- Assinatura já registrada --}}
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Assinatura Registrada</h3></div>
                <div class="card-body text-center">
                    <img src="{{ $anamnese->signature_data }}" alt="Assinatura" style="max-width:400px;border:1px solid #e6e7e9;border-radius:4px">
                    <div class="text-muted mt-2 small">Assinada em: {{ $anamnese->signed_at?->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            @else
            {{-- Formulário de Assinatura --}}
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Assine Abaixo</h3></div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Use o dedo (celular) ou o mouse para assinar.</p>

                    @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('anamnese.assinatura.submit', $anamnese->signature_token) }}" id="signatureForm">
                        @csrf
                        <div style="border:1px solid #e6e7e9;border-radius:4px;max-width:500px;margin:0 auto">
                            <canvas id="signaturePad" width="500" height="200"></canvas>
                        </div>
                        <div class="text-center mt-2 mb-3">
                            <button type="button" class="btn btn-ghost-secondary btn-sm" id="clearSignature">Limpar</button>
                        </div>
                        <input type="hidden" name="signature_data" id="signatureData">
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">Confirmar Assinatura</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var canvas = document.getElementById('signaturePad');
    if (!canvas) return;

    var pad = new SignaturePad(canvas, { backgroundColor: 'rgb(255,255,255)' });

    document.getElementById('clearSignature').addEventListener('click', function () { pad.clear(); });

    document.getElementById('signatureForm').addEventListener('submit', function (e) {
        if (pad.isEmpty()) {
            e.preventDefault();
            alert('Por favor, assine antes de confirmar.');
            return;
        }
        document.getElementById('signatureData').value = pad.toDataURL();
    });

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        var wrapper = canvas.parentElement;
        var data = pad.toData();
        canvas.width = wrapper.offsetWidth * ratio;
        canvas.height = 200 * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        canvas.style.width = wrapper.offsetWidth + 'px';
        canvas.style.height = '200px';
        pad.clear();
        pad.fromData(data);
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();
});
</script>
@endpush
</x-public-layout>
