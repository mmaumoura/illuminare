<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\CrmClient;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with(['user', 'clinic'])->withCount('tasks');

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome_completo', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('empresa', 'like', "%{$search}%");
            });
        }

        if ($status = $request->status) {
            $query->where('status', $status);
        }

        if ($origem = $request->origem) {
            $query->where('origem', $origem);
        }

        if ($user_id = $request->user_id) {
            $query->where('user_id', $user_id);
        }

        $leads = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get();

        return view('crm.leads.index', compact('leads', 'users'));
    }

    public function kanban()
    {
        $leads = Lead::with('user')->get()->groupBy('status');
        return view('crm.leads.kanban', compact('leads'));
    }

    public function funnel()
    {
        $statuses = ['novo', 'contatado', 'qualificado', 'convertido', 'perdido'];
        $counts = Lead::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $data = collect($statuses)->map(fn($s) => [
            'status' => $s,
            'total'  => $counts->get($s, 0),
        ]);

        return view('crm.leads.funnel', compact('data'));
    }

    public function create()
    {
        $clinics = Clinic::orderBy('name')->get();
        $users   = User::orderBy('name')->get();
        return view('crm.leads.create', compact('clinics', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome_completo'  => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'telefone'       => 'nullable|string|max:20',
            'empresa'        => 'nullable|string|max:255',
            'cargo'          => 'nullable|string|max:100',
            'status'         => 'required|in:novo,contatado,qualificado,convertido,perdido',
            'origem'         => 'required|in:site,indicacao,redes_sociais,evento,ligacao,email,outro',
            'observacoes'    => 'nullable|string',
            'valor_estimado' => 'nullable|numeric|min:0',
            'user_id'        => 'required|exists:users,id',
            'clinic_id'      => 'nullable|exists:clinics,id',
            'data_contato'   => 'nullable|date',
        ]);

        Lead::create($data);

        return redirect()->route('crm.leads.index')
            ->with('success', 'Lead cadastrado com sucesso!');
    }

    public function show(Lead $lead)
    {
        $lead->load(['user', 'clinic', 'crmClient', 'opportunities', 'tasks.user']);
        return view('crm.leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $clinics = Clinic::orderBy('name')->get();
        $users   = User::orderBy('name')->get();
        return view('crm.leads.edit', compact('lead', 'clinics', 'users'));
    }

    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'nome_completo'  => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'telefone'       => 'nullable|string|max:20',
            'empresa'        => 'nullable|string|max:255',
            'cargo'          => 'nullable|string|max:100',
            'status'         => 'required|in:novo,contatado,qualificado,convertido,perdido',
            'origem'         => 'required|in:site,indicacao,redes_sociais,evento,ligacao,email,outro',
            'observacoes'    => 'nullable|string',
            'valor_estimado' => 'nullable|numeric|min:0',
            'user_id'        => 'required|exists:users,id',
            'clinic_id'      => 'nullable|exists:clinics,id',
            'data_contato'   => 'nullable|date',
        ]);

        // Auto-convert when status = convertido
        if ($data['status'] === 'convertido' && ! $lead->crm_client_id) {
            $client = CrmClient::create([
                'nome_completo' => $lead->nome_completo,
                'email'         => $lead->email,
                'telefone'      => $lead->telefone ?? '',
                'tipo'          => 'cliente',
                'clinic_id'     => $lead->clinic_id,
            ]);
            $data['crm_client_id'] = $client->id;
            $data['convertido_em'] = now();
        }

        $lead->update($data);

        return redirect()->route('crm.leads.show', $lead)
            ->with('success', 'Lead atualizado com sucesso!');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('crm.leads.index')
            ->with('success', 'Lead removido com sucesso!');
    }

    public function converter(Lead $lead)
    {
        if ($lead->crm_client_id) {
            return redirect()->route('crm.leads.show', $lead)
                ->with('info', 'Lead já foi convertido em cliente.');
        }

        $client = CrmClient::create([
            'nome_completo' => $lead->nome_completo,
            'email'         => $lead->email,
            'telefone'      => $lead->telefone ?? '',
            'tipo'          => 'cliente',
            'clinic_id'     => $lead->clinic_id,
        ]);

        $lead->update([
            'status'         => 'convertido',
            'crm_client_id'  => $client->id,
            'convertido_em'  => now(),
        ]);

        return redirect()->route('crm.clientes.show', $client)
            ->with('success', 'Lead convertido em cliente com sucesso!');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate(['status' => 'required|in:novo,contatado,qualificado,convertido,perdido']);

        $clientCreated = false;

        if ($request->status === 'convertido' && ! $lead->crm_client_id) {
            $client = CrmClient::create([
                'nome_completo' => $lead->nome_completo,
                'email'         => $lead->email,
                'telefone'      => $lead->telefone ?? '',
                'tipo'          => 'cliente',
                'clinic_id'     => $lead->clinic_id,
            ]);
            $lead->update([
                'status'        => 'convertido',
                'crm_client_id' => $client->id,
                'convertido_em' => now(),
            ]);
            $clientCreated = true;
        } else {
            $lead->update(['status' => $request->status]);
        }

        return response()->json([
            'success'        => true,
            'client_created' => $clientCreated,
            'message'        => $clientCreated
                ? 'Lead convertido e cliente criado com sucesso!'
                : 'Status atualizado com sucesso!',
        ]);
    }
}
