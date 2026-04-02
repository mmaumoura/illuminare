<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientDocumentController extends Controller
{
    public function store(Request $request, Patient $paciente): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'file'        => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'description' => 'nullable|string|max:1000',
        ]);

        $path = $request->file('file')->store(
            "patients/{$paciente->id}/documents",
            'public'
        );

        $paciente->documents()->create([
            'name'        => $validated['name'],
            'type'        => $validated['type'],
            'file_path'   => $path,
            'description' => $validated['description'] ?? null,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Documento enviado com sucesso.')
            ->with('active_tab', 'documentos');
    }

    public function destroy(Patient $paciente, PatientDocument $documento): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        abort_if($documento->patient_id !== $paciente->id, 404);

        Storage::disk('public')->delete($documento->file_path);
        $documento->delete();

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Documento excluído.')
            ->with('active_tab', 'documentos');
    }
}
