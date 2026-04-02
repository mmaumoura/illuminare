<?php

namespace App\Http\Controllers;

use App\Models\CrmClient;
use App\Models\Clinic;
use Illuminate\Http\Request;

class CrmClientController extends Controller
{
    public function index(Request $request)
    {
        $query = CrmClient::with('clinic')->withCount(['opportunities', 'tasks']);

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome_completo', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf', 'like', "%{$search}%")
                  ->orWhere('telefone', 'like', "%{$search}%");
            });
        }

        if ($tipo = $request->tipo) {
            $query->where('tipo', $tipo);
        }

        $clients = $query->orderBy('nome_completo')->paginate(20)->withQueryString();

        return view('crm.clientes.index', compact('clients'));
    }

    public function create()
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('crm.clientes.create', compact('clinics'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome_completo'   => 'required|string|max:255',
            'email'           => 'nullable|email|unique:crm_clients,email',
            'telefone'        => 'required|string|max:20',
            'data_nascimento' => 'nullable|date',
            'cpf'             => 'nullable|string|max:14|unique:crm_clients,cpf',
            'tipo'            => 'required|in:cliente,lead',
            'clinic_id'       => 'nullable|exists:clinics,id',
            'cep'             => 'nullable|string|max:9',
            'logradouro'      => 'nullable|string|max:255',
            'numero'          => 'nullable|string|max:20',
            'complemento'     => 'nullable|string|max:255',
            'bairro'          => 'nullable|string|max:100',
            'cidade'          => 'nullable|string|max:100',
            'estado'          => 'nullable|string|max:2',
            'observacoes'     => 'nullable|string',
        ]);

        CrmClient::create($data);

        return redirect()->route('crm.clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(CrmClient $cliente)
    {
        $cliente->load(['clinic', 'leads', 'opportunities.user', 'tasks.user']);
        return view('crm.clientes.show', compact('cliente'));
    }

    public function edit(CrmClient $cliente)
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('crm.clientes.edit', compact('cliente', 'clinics'));
    }

    public function update(Request $request, CrmClient $cliente)
    {
        $data = $request->validate([
            'nome_completo'   => 'required|string|max:255',
            'email'           => 'nullable|email|unique:crm_clients,email,' . $cliente->id,
            'telefone'        => 'required|string|max:20',
            'data_nascimento' => 'nullable|date',
            'cpf'             => 'nullable|string|max:14|unique:crm_clients,cpf,' . $cliente->id,
            'tipo'            => 'required|in:cliente,lead',
            'clinic_id'       => 'nullable|exists:clinics,id',
            'cep'             => 'nullable|string|max:9',
            'logradouro'      => 'nullable|string|max:255',
            'numero'          => 'nullable|string|max:20',
            'complemento'     => 'nullable|string|max:255',
            'bairro'          => 'nullable|string|max:100',
            'cidade'          => 'nullable|string|max:100',
            'estado'          => 'nullable|string|max:2',
            'observacoes'     => 'nullable|string',
        ]);

        $cliente->update($data);

        return redirect()->route('crm.clientes.show', $cliente)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(CrmClient $cliente)
    {
        $cliente->delete();
        return redirect()->route('crm.clientes.index')
            ->with('success', 'Cliente removido com sucesso!');
    }
}
