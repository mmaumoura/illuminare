<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    private array $types    = ['Agendamento de Paciente', 'Agendamento Interno', 'Bloqueio de Agenda'];
    private array $statuses = ['Agendado', 'Confirmado', 'Realizado', 'Cancelado', 'Falta'];

    // -------------------------------------------------------------------------
    // Index — list with filters
    // -------------------------------------------------------------------------

    public function index(Request $request): View
    {
        $userClinicId = auth()->user()->clinicScope();

        $query = Appointment::with(['patient', 'professional', 'clinic', 'procedures'])
            ->orderBy('starts_at', 'asc')
            ->when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId));

        if ($request->filled('tipo')) {
            $query->where('type', $request->tipo);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('profissional_id')) {
            $query->where('professional_id', $request->profissional_id);
        }

        if ($request->filled('procedimento_id')) {
            $query->whereHas('procedures', fn ($q) => $q->where('procedures.id', $request->procedimento_id));
        }
        if ($request->filled('data')) {
            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $request->data, 'America/Sao_Paulo');
            if ($date) {
                $query->whereDate('starts_at', $date->toDateString());
            }
        }

        $appointments  = $query->paginate(25)->withQueryString();
        $professionals = User::when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))->orderBy('name')->get();
        $procedures    = Procedure::where('status', 'Ativo')->orderBy('name')->get();

        return view('agenda.index', compact('appointments', 'professionals', 'procedures'));
    }

    // -------------------------------------------------------------------------
    // Create
    // -------------------------------------------------------------------------

    public function create(): View
    {
        $userClinicId  = auth()->user()->clinicScope();
        $patients      = Patient::when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))->orderBy('name')->get();
        $professionals = User::when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))->orderBy('name')->get();
        $clinics       = $userClinicId
            ? Clinic::where('id', $userClinicId)->get()
            : Clinic::orderBy('name')->get();
        $procedures    = Procedure::where('status', 'Ativo')->orderBy('name')->get();
        $types         = $this->types;
        $statuses      = $this->statuses;

        return view('agenda.create', compact('patients', 'professionals', 'clinics', 'procedures', 'types', 'statuses', 'userClinicId'));
    }

    // -------------------------------------------------------------------------
    // Store
    // -------------------------------------------------------------------------

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'            => 'required|string',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string|max:1000',
            'starts_at'       => 'required|date',
            'ends_at'         => 'required|date|after_or_equal:starts_at',
            'patient_id'      => 'nullable|exists:patients,id',
            'professional_id' => 'required|exists:users,id',
            'clinic_id'       => 'required|exists:clinics,id',
            'status'          => 'required|string',
            'observations'    => 'nullable|string|max:2000',
            'procedures'      => 'nullable|array',
            'procedures.*'    => 'exists:procedures,id',
        ]);

        $procedureIds = $validated['procedures'] ?? [];
        unset($validated['procedures']);

        // Force clinic for franqueado/colaborador regardless of submitted value
        if ($clinicId = auth()->user()->clinicScope()) {
            $validated['clinic_id'] = $clinicId;
        }

        $validated['color'] = match ($validated['type']) {
            'Bloqueio de Agenda'      => '#EF4444',
            'Agendamento Interno'     => '#10B981',
            default                   => '#3B82F6',
        };

        $appointment = Appointment::create($validated);

        if ($procedureIds) {
            $appointment->procedures()->sync($procedureIds);
        }

        return redirect()->route('operacional.agenda.show', $appointment)
            ->with('success', 'Agendamento criado com sucesso.');
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    public function show(Appointment $agendamento): View
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($agendamento->clinic_id !== $clinicId, 403);
        }

        $agendamento->load(['patient', 'professional', 'clinic', 'procedures']);

        return view('agenda.show', ['appointment' => $agendamento]);
    }

    // -------------------------------------------------------------------------
    // Edit
    // -------------------------------------------------------------------------

    public function edit(Appointment $agendamento): View
    {
        $userClinicId = auth()->user()->clinicScope();

        if ($userClinicId) {
            abort_if($agendamento->clinic_id !== $userClinicId, 403);
        }

        $agendamento->load(['patient', 'professional', 'clinic', 'procedures']);

        $patients      = Patient::when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))->orderBy('name')->get();
        $professionals = User::when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))->orderBy('name')->get();
        $clinics       = $userClinicId
            ? Clinic::where('id', $userClinicId)->get()
            : Clinic::orderBy('name')->get();
        $procedures    = Procedure::where('status', 'Ativo')->orderBy('name')->get();
        $types         = $this->types;
        $statuses      = $this->statuses;

        return view('agenda.edit', [
            'appointment'   => $agendamento,
            'patients'      => $patients,
            'professionals' => $professionals,
            'clinics'       => $clinics,
            'procedures'    => $procedures,
            'types'         => $types,
            'statuses'      => $statuses,
            'userClinicId'  => $userClinicId,
        ]);
    }

    // -------------------------------------------------------------------------
    // Update
    // -------------------------------------------------------------------------

    public function update(Request $request, Appointment $agendamento): RedirectResponse
    {
        $validated = $request->validate([
            'type'            => 'required|string',
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string|max:1000',
            'starts_at'       => 'required|date',
            'ends_at'         => 'required|date|after_or_equal:starts_at',
            'patient_id'      => 'nullable|exists:patients,id',
            'professional_id' => 'required|exists:users,id',
            'clinic_id'       => 'required|exists:clinics,id',
            'status'          => 'required|string',
            'observations'    => 'nullable|string|max:2000',
            'procedures'      => 'nullable|array',
            'procedures.*'    => 'exists:procedures,id',
        ]);

        $procedureIds = $validated['procedures'] ?? [];
        unset($validated['procedures']);

        if ($clinicId = auth()->user()->clinicScope()) {
            $validated['clinic_id'] = $clinicId;
        }

        $validated['color'] = match ($validated['type']) {
            'Bloqueio de Agenda'      => '#EF4444',
            'Agendamento Interno'     => '#10B981',
            default                   => '#3B82F6',
        };

        $agendamento->update($validated);
        $agendamento->procedures()->sync($procedureIds);

        return redirect()->route('operacional.agenda.show', $agendamento)
            ->with('success', 'Agendamento atualizado com sucesso.');
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function destroy(Appointment $agendamento): RedirectResponse
    {
        $agendamento->delete();

        return redirect()->route('operacional.agenda.index')
            ->with('success', 'Agendamento removido com sucesso.');
    }

    // -------------------------------------------------------------------------
    // Calendar data (JSON for FullCalendar)
    // -------------------------------------------------------------------------

    public function calendarData(Request $request): JsonResponse
    {
        $start        = $request->query('start');
        $end          = $request->query('end');
        $userClinicId = auth()->user()->clinicScope();

        $query = Appointment::with(['patient', 'professional', 'clinic'])
            ->when($userClinicId, fn ($q) => $q->where('clinic_id', $userClinicId))
            ->when($start, fn ($q) => $q->where('starts_at', '>=', $start))
            ->when($end,   fn ($q) => $q->where('starts_at', '<=', $end));

        $events = $query->get()->map(function (Appointment $a) {
            return [
                'id'    => $a->id,
                'title' => $a->title,
                'start' => $a->starts_at->toIso8601String(),
                'end'   => $a->ends_at->toIso8601String(),
                'color' => $a->color ?? '#3B82F6',
                'url'   => route('operacional.agenda.show', $a),
                'extendedProps' => [
                    'status'      => $a->status,
                    'type'        => $a->type,
                    'patient'     => $a->patient?->name,
                    'professional'=> $a->professional?->name,
                    'clinic'      => $a->clinic?->name,
                ],
            ];
        });

        return response()->json($events);
    }
}
