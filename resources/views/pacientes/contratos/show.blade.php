<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $contrato->title }} — {{ $paciente->name }}</title>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            color: #1a1a1a;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .page {
            background: #fff;
            max-width: 794px; /* A4 */
            margin: 0 auto;
            padding: 60px 70px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.12);
        }

        /* Action bar */
        .action-bar {
            max-width: 794px;
            margin: 0 auto 16px;
            display: flex;
            gap: 8px;
            align-items: center;
        }
    </style>
</head>
<body>

    {{-- Action bar (hidden on print) --}}
    <div class="action-bar no-print">
        <button onclick="window.print()" class="btn" style="background:#206bc4;color:#fff;padding:6px 16px;border:none;border-radius:4px;cursor:pointer;font-size:13px">
            🖨 Imprimir / Salvar PDF
        </button>
        <a href="{{ route('operacional.pacientes.show', $paciente) }}"
           style="background:#6c757d;color:#fff;padding:6px 16px;border:none;border-radius:4px;cursor:pointer;font-size:13px;text-decoration:none">
            ← Voltar ao Paciente
        </a>
        <span style="color:#888;font-size:12px;margin-left:auto">{{ $contrato->created_at->format('d/m/Y H:i') }}</span>
    </div>

    <div class="page">
        {!! $contrato->content !!}
    </div>

</body>
</html>
