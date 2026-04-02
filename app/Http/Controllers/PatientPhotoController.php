<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientPhotoController extends Controller
{
    public function store(Request $request, Patient $paciente): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'photo_date'         => 'required|date',
            'type'               => 'required|string|max:100',
            'region'             => 'nullable|string|max:100',
            'visible_to_patient' => 'nullable|boolean',
            'file'               => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'description'        => 'nullable|string|max:1000',
        ]);

        $path = $request->file('file')->store(
            "patients/{$paciente->id}/photos",
            'public'
        );

        $paciente->photos()->create([
            'title'              => $validated['title'],
            'photo_date'         => $validated['photo_date'],
            'type'               => $validated['type'],
            'region'             => $validated['region'] ?? null,
            'visible_to_patient' => $validated['visible_to_patient'] ?? false,
            'file_path'          => $path,
            'description'        => $validated['description'] ?? null,
            'uploaded_by'        => auth()->id(),
        ]);

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Foto enviada com sucesso.')
            ->with('active_tab', 'fotos');
    }

    public function destroy(Patient $paciente, PatientPhoto $foto): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        abort_if($foto->patient_id !== $paciente->id, 404);

        Storage::disk('public')->delete($foto->file_path);
        $foto->delete();

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Foto excluída.')
            ->with('active_tab', 'fotos');
    }
}
