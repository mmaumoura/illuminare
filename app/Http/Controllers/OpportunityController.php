<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use App\Models\CrmClient;
use App\Models\Lead;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $query = Opportunity::with(['crmClient', 'lead', 'user', 'clinic']);

        if ($search = $request->search) {
            $query->where('titulo', 'like', "%{$search}%");
        }

        if ($estagio = $request->estagio) {
            $query->where('estagio', $estagio);
        }

        if ($user_id = $request->user_id) {
            $query->where('user_id', $user_id);
        }

        $opportunities = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get();

        return view('crm.oportunidades.index', compact('opportunities', 'users'));
    }

    public function kanban()
    {
        $opportunities = Opportunity::with(['crmClient', 'lead', 'user'])->get()->groupBy('estagio');
        return view('crm.oportunidades.kanban', compact('opportunities'));
    }

    public function create()
    {
        $clinics = Clinic::orderBy('name')->get();
        $users   = User::orderBy('name')->get();
        $clients = CrmClient::orderBy('nome_completo')->get();
        $leads   = Lead::where('status', '!=', 'perdido')->orderBy('nome_completo')->get();
        return view('crm.oportunidades.create', compact('clinics', 'users', 'clients', 'leads'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'                  => 'required|string|max:255',
            'descricao'               => 'nullable|string',
            'valor'                   => 'nullable|numeric|min:0',
            'estagio'                 => 'required|in:prospeccao,qualificacao,proposta,negociacao,fechamento,ganho,perdido',
            'probabilidade'           => 'nullable|integer|min:0|max:100',
            'data_fechamento_previsto'=> 'nullable|date',
            'crm_client_id'           => 'nullable|exists:crm_clients,id',
            'lead_id'                 => 'nullable|exists:leads,id',
            'user_id'                 => 'required|exists:users,id',
            'clinic_id'               => 'nullable|exists:clinics,id',
            'motivo_perda'            => 'nullable|string',
        ]);

        Opportunity::create($data);

        return redirect()->route('crm.oportunidades.index')
            ->with('success', 'Oportunidade criada com sucesso!');
    }

    public function show(Opportunity $oportunidade)
    {
        $oportunidade->load(['crmClient', 'lead', 'user', 'clinic', 'tasks.user']);
        return view('crm.oportunidades.show', compact('oportunidade'));
    }

    public function edit(Opportunity $oportunidade)
    {
        $clinics = Clinic::orderBy('name')->get();
        $users   = User::orderBy('name')->get();
        $clients = CrmClient::orderBy('nome_completo')->get();
        $leads   = Lead::orderBy('nome_completo')->get();
        return view('crm.oportunidades.edit', compact('oportunidade', 'clinics', 'users', 'clients', 'leads'));
    }

    public function update(Request $request, Opportunity $oportunidade)
    {
        $data = $request->validate([
            'titulo'                  => 'required|string|max:255',
            'descricao'               => 'nullable|string',
            'valor'                   => 'nullable|numeric|min:0',
            'estagio'                 => 'required|in:prospeccao,qualificacao,proposta,negociacao,fechamento,ganho,perdido',
            'probabilidade'           => 'nullable|integer|min:0|max:100',
            'data_fechamento_previsto'=> 'nullable|date',
            'data_fechamento_real'    => 'nullable|date',
            'crm_client_id'           => 'nullable|exists:crm_clients,id',
            'lead_id'                 => 'nullable|exists:leads,id',
            'user_id'                 => 'required|exists:users,id',
            'clinic_id'               => 'nullable|exists:clinics,id',
            'motivo_perda'            => 'nullable|string',
        ]);

        if (in_array($data['estagio'], ['ganho', 'perdido']) && ! $oportunidade->data_fechamento_real) {
            $data['data_fechamento_real'] = now()->toDateString();
        }

        $oportunidade->update($data);

        return redirect()->route('crm.oportunidades.show', $oportunidade)
            ->with('success', 'Oportunidade atualizada com sucesso!');
    }

    public function destroy(Opportunity $oportunidade)
    {
        $oportunidade->delete();
        return redirect()->route('crm.oportunidades.index')
            ->with('success', 'Oportunidade removida com sucesso!');
    }
}
