<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\CrmClient;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['user', 'clinic', 'assignedBy']);

        if ($search = $request->search) {
            $query->where('titulo', 'like', "%{$search}%");
        }

        if ($status = $request->status) {
            $query->where('status', $status);
        }

        if ($prioridade = $request->prioridade) {
            $query->where('prioridade', $prioridade);
        }

        if ($tipo = $request->tipo) {
            $query->where('tipo', $tipo);
        }

        if ($user_id = $request->user_id) {
            $query->where('user_id', $user_id);
        }

        $tasks = $query->orderBy('data_vencimento')->paginate(20)->withQueryString();
        $users = User::orderBy('name')->get();

        return view('crm.tarefas.index', compact('tasks', 'users'));
    }

    public function kanban()
    {
        $tasks = Task::with(['user', 'taskable'])->get()->groupBy('status');
        return view('crm.tarefas.kanban', compact('tasks'));
    }

    public function create(Request $request)
    {
        $clinics     = Clinic::orderBy('name')->get();
        $users       = User::orderBy('name')->get();
        $clients     = CrmClient::orderBy('nome_completo')->get();
        $leads       = Lead::orderBy('nome_completo')->get();
        $oporti      = Opportunity::orderBy('titulo')->get();

        // Allow pre-linking via query string
        $taskableType = $request->taskable_type;
        $taskableId   = $request->taskable_id;

        return view('crm.tarefas.create', compact('clinics', 'users', 'clients', 'leads', 'oporti', 'taskableType', 'taskableId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'         => 'required|string|max:255',
            'descricao'      => 'nullable|string',
            'tipo'           => 'required|in:ligacao,email,reuniao,follow_up,outro',
            'prioridade'     => 'required|in:baixa,media,alta,urgente',
            'status'         => 'required|in:pendente,em_andamento,concluida,cancelada',
            'data_vencimento'=> 'nullable|date',
            'user_id'        => 'required|exists:users,id',
            'clinic_id'      => 'nullable|exists:clinics,id',
            'taskable_type'  => 'nullable|string',
            'taskable_id'    => 'nullable|integer',
        ]);

        $data['assigned_by_id'] = auth()->id();

        Task::create($data);

        return redirect()->route('crm.tarefas.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    public function show(Task $tarefa)
    {
        $tarefa->load(['user', 'assignedBy', 'clinic', 'taskable']);
        return view('crm.tarefas.show', compact('tarefa'));
    }

    public function edit(Task $tarefa)
    {
        $clinics = Clinic::orderBy('name')->get();
        $users   = User::orderBy('name')->get();
        $clients = CrmClient::orderBy('nome_completo')->get();
        $leads   = Lead::orderBy('nome_completo')->get();
        $oporti  = Opportunity::orderBy('titulo')->get();
        return view('crm.tarefas.edit', compact('tarefa', 'clinics', 'users', 'clients', 'leads', 'oporti'));
    }

    public function update(Request $request, Task $tarefa)
    {
        $data = $request->validate([
            'titulo'         => 'required|string|max:255',
            'descricao'      => 'nullable|string',
            'tipo'           => 'required|in:ligacao,email,reuniao,follow_up,outro',
            'prioridade'     => 'required|in:baixa,media,alta,urgente',
            'status'         => 'required|in:pendente,em_andamento,concluida,cancelada',
            'data_vencimento'=> 'nullable|date',
            'user_id'        => 'required|exists:users,id',
            'clinic_id'      => 'nullable|exists:clinics,id',
            'taskable_type'  => 'nullable|string',
            'taskable_id'    => 'nullable|integer',
        ]);

        if ($data['status'] === 'concluida' && ! $tarefa->concluida_em) {
            $data['concluida_em'] = now();
        }

        $tarefa->update($data);

        return redirect()->route('crm.tarefas.show', $tarefa)
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $tarefa)
    {
        $tarefa->delete();
        return redirect()->route('crm.tarefas.index')
            ->with('success', 'Tarefa removida com sucesso!');
    }

    public function concluir(Task $tarefa)
    {
        $tarefa->update([
            'status'      => 'concluida',
            'concluida_em'=> now(),
        ]);

        return back()->with('success', 'Tarefa marcada como concluída!');
    }

    public function updateStatus(Request $request, Task $tarefa)
    {
        $data = $request->validate(['status' => 'required|in:pendente,em_andamento,concluida,cancelada']);

        $update = ['status' => $data['status']];

        if ($data['status'] === 'concluida' && ! $tarefa->concluida_em) {
            $update['concluida_em'] = now();
        }

        $tarefa->update($update);

        return response()->json(['message' => 'Status atualizado!']);
    }
}
