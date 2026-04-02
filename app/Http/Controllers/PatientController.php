<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PatientController extends Controller
{
    public function index(Request $request): View
    {
        $userClinicId = auth()->user()->clinicScope();

        $query = Patient::with('clinic')
            ->when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))
            ->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->paginate(20)->withQueryString();

        return view('pacientes.index', compact('patients'));
    }

    public function create(): View
    {
        $userClinicId = auth()->user()->clinicScope();
        $clinics = $userClinicId
            ? Clinic::where('id', $userClinicId)->get()
            : Clinic::where('active', true)->orderBy('name')->get();
        return view('pacientes.create', compact('clinics', 'userClinicId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                    => 'required|string|max:255',
            'cpf'                     => 'nullable|string|max:14|unique:patients,cpf',
            'birth_date'              => 'nullable|date',
            'email'                   => 'nullable|email|max:255',
            'phone'                   => 'required|string|max:20',
            'clinic_id'               => 'required|exists:clinics,id',
            'cep'                     => 'nullable|string|max:9',
            'street'                  => 'nullable|string|max:255',
            'number'                  => 'nullable|string|max:20',
            'complement'              => 'nullable|string|max:100',
            'neighborhood'            => 'nullable|string|max:100',
            'city'                    => 'nullable|string|max:100',
            'state'                   => 'nullable|string|max:2',
            'medical_history'         => 'nullable|string',
            'allergies'               => 'nullable|string',
            'current_medications'     => 'nullable|string',
            'emergency_contact_name'  => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ]);

        if ($clinicId = auth()->user()->clinicScope()) {
            $validated['clinic_id'] = $clinicId;
        }

        $patient = Patient::create($validated);

        return redirect()->route('operacional.pacientes.show', $patient)
            ->with('success', 'Paciente cadastrado com sucesso.');
    }

    public function show(Patient $paciente): View
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }
        $paciente->load([
            'clinic',
            'documents',
            'anamneses',
            'medicalRecords.professional',
            'medicalRecords.procedure',
            'photos',
            'appointments.procedures',
            'contracts',
        ]);
        $contractTemplates = \App\Models\ContractTemplate::orderBy('title')->get(['id', 'title', 'type']);
        return view('pacientes.show', compact('paciente', 'contractTemplates'));
    }

    public function edit(Patient $paciente): View
    {
        $userClinicId = auth()->user()->clinicScope();
        if ($userClinicId) {
            abort_if($paciente->clinic_id !== $userClinicId, 403);
        }
        $clinics = $userClinicId
            ? Clinic::where('id', $userClinicId)->get()
            : Clinic::where('active', true)->orderBy('name')->get();
        return view('pacientes.edit', ['paciente' => $paciente, 'clinics' => $clinics, 'userClinicId' => $userClinicId]);
    }

    public function update(Request $request, Patient $paciente): RedirectResponse
    {
        $validated = $request->validate([
            'name'                    => 'required|string|max:255',
            'cpf'                     => 'nullable|string|max:14|unique:patients,cpf,' . $paciente->id,
            'birth_date'              => 'nullable|date',
            'email'                   => 'nullable|email|max:255',
            'phone'                   => 'required|string|max:20',
            'clinic_id'               => 'required|exists:clinics,id',
            'cep'                     => 'nullable|string|max:9',
            'street'                  => 'nullable|string|max:255',
            'number'                  => 'nullable|string|max:20',
            'complement'              => 'nullable|string|max:100',
            'neighborhood'            => 'nullable|string|max:100',
            'city'                    => 'nullable|string|max:100',
            'state'                   => 'nullable|string|max:2',
            'medical_history'         => 'nullable|string',
            'allergies'               => 'nullable|string',
            'current_medications'     => 'nullable|string',
            'emergency_contact_name'  => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ]);

        if ($clinicId = auth()->user()->clinicScope()) {
            $validated['clinic_id'] = $clinicId;
        }

        $paciente->update($validated);

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Paciente atualizado com sucesso.');
    }

    public function destroy(Patient $paciente): RedirectResponse
    {
        $paciente->delete();

        return redirect()->route('operacional.pacientes.index')
            ->with('success', 'Paciente excluído com sucesso.');
    }

    public function export(Request $request): StreamedResponse
    {
        $userClinicId = auth()->user()->clinicScope();

        $query = Patient::with('clinic')
            ->when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))
            ->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!$userClinicId && $clinicId = $request->input('clinic_id')) {
            $query->where('clinic_id', $clinicId);
        }

        $patients = $query->get();

        return response()->streamDownload(function () use ($patients) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['Nome', 'CPF', 'Data de Nascimento', 'Telefone', 'E-mail', 'Unidade', 'CEP', 'Logradouro', 'Número', 'Complemento', 'Bairro', 'Cidade', 'Estado', 'Histórico Médico', 'Alergias', 'Medicamentos', 'Contato Emergência - Nome', 'Contato Emergência - Telefone'], ';');
            foreach ($patients as $p) {
                fputcsv($handle, [
                    $p->name,
                    $p->cpf,
                    $p->birth_date?->format('d/m/Y'),
                    $p->phone,
                    $p->email,
                    $p->clinic?->name,
                    $p->cep,
                    $p->street,
                    $p->number,
                    $p->complement,
                    $p->neighborhood,
                    $p->city,
                    $p->state,
                    $p->medical_history,
                    $p->allergies,
                    $p->current_medications,
                    $p->emergency_contact_name,
                    $p->emergency_contact_phone,
                ], ';');
            }
            fclose($handle);
        }, 'pacientes_' . now()->format('Ymd_His') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function importTemplate(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($handle, ['Nome *', 'Telefone *', 'CPF', 'Data de Nascimento (dd/mm/aaaa)', 'E-mail', 'Unidade (nome exato - obrigatório para Admin)', 'CEP', 'Logradouro', 'Número', 'Complemento', 'Bairro', 'Cidade', 'Estado (UF)'], ';');
            fputcsv($handle, ['João da Silva', '(11) 99999-9999', '123.456.789-00', '01/01/1990', 'joao@email.com', 'Nome da Unidade', '01310-100', 'Av. Paulista', '1000', 'Ap 10', 'Bela Vista', 'São Paulo', 'SP'], ';');
            fclose($handle);
        }, 'modelo_importacao_pacientes.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $userClinicId = auth()->user()->clinicScope();
        $isAdmin      = auth()->user()->isAdministrador() || auth()->user()->isGestor();

        $file     = $request->file('file');
        $handle   = fopen($file->getRealPath(), 'r');
        $imported = 0;
        $errors   = [];
        $row      = 0;

        // Skip BOM if present
        $bom = fread($handle, 3);
        if ($bom !== chr(0xEF) . chr(0xBB) . chr(0xBF)) {
            rewind($handle);
        }

        $header = fgetcsv($handle, 0, ';'); // skip header row

        while (($data = fgetcsv($handle, 0, ';')) !== false) {
            $row++;
            if (empty(array_filter($data))) {
                continue;
            }

            $name    = trim($data[0] ?? '');
            $phone   = trim($data[1] ?? '');
            $cpf     = trim($data[2] ?? '') ?: null;
            $bdate   = trim($data[3] ?? '') ?: null;
            $email   = trim($data[4] ?? '') ?: null;
            $clinic  = trim($data[5] ?? '') ?: null;

            if (!$name) {
                $errors[] = "Linha {$row}: Nome é obrigatório.";
                continue;
            }
            if (!$phone) {
                $errors[] = "Linha {$row}: Telefone é obrigatório.";
                continue;
            }

            $clinicId = $userClinicId;

            if (!$clinicId) {
                if (!$clinic) {
                    $errors[] = "Linha {$row}: Unidade é obrigatória para administradores.";
                    continue;
                }
                $clinicModel = Clinic::where('name', 'like', "%{$clinic}%")->first();
                if (!$clinicModel) {
                    $errors[] = "Linha {$row}: Unidade \"{$clinic}\" não encontrada.";
                    continue;
                }
                $clinicId = $clinicModel->id;
            }

            $birthDate = null;
            if ($bdate) {
                try {
                    $birthDate = \Carbon\Carbon::createFromFormat('d/m/Y', $bdate)->format('Y-m-d');
                } catch (\Exception $e) {
                    $birthDate = null;
                }
            }

            Patient::create([
                'name'         => $name,
                'phone'        => $phone,
                'cpf'          => $cpf,
                'birth_date'   => $birthDate,
                'email'        => $email,
                'clinic_id'    => $clinicId,
                'street'       => trim($data[7] ?? '') ?: null,
                'number'       => trim($data[8] ?? '') ?: null,
                'complement'   => trim($data[9] ?? '') ?: null,
                'neighborhood' => trim($data[10] ?? '') ?: null,
                'city'         => trim($data[11] ?? '') ?: null,
                'state'        => trim($data[12] ?? '') ?: null,
                'cep'          => trim($data[6] ?? '') ?: null,
            ]);
            $imported++;
        }

        fclose($handle);

        $message = "{$imported} paciente(s) importado(s) com sucesso.";
        if ($errors) {
            $message .= ' Erros: ' . implode(' | ', array_slice($errors, 0, 5));
            if (count($errors) > 5) {
                $message .= ' e mais ' . (count($errors) - 5) . ' erros.';
            }
        }

        return redirect()->route('operacional.pacientes.index')->with('success', $message);
    }
}

