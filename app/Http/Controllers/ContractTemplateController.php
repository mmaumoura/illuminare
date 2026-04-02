<?php

namespace App\Http\Controllers;

use App\Models\ContractTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractTemplateController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContractTemplate::orderBy('title');

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
        }

        $templates = $query->paginate(20)->withQueryString();

        return view('contratos-modelos.index', compact('templates'));
    }

    public function create(): View
    {
        return view('contratos-modelos.create', [
            'template' => null,
            'types'    => ContractTemplate::$types,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'type'    => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        $template = ContractTemplate::create($data);

        return redirect()->route('gestao.contratos-modelos.edit', $template)
            ->with('success', 'Modelo de contrato criado com sucesso.');
    }

    public function edit(ContractTemplate $contratos_modelo): View
    {
        return view('contratos-modelos.create', [
            'template' => $contratos_modelo,
            'types'    => ContractTemplate::$types,
        ]);
    }

    public function update(Request $request, ContractTemplate $contratos_modelo): RedirectResponse
    {
        $data = $request->validate([
            'title'   => 'required|string|max:255',
            'type'    => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        $contratos_modelo->update($data);

        return redirect()->route('gestao.contratos-modelos.edit', $contratos_modelo)
            ->with('success', 'Modelo atualizado com sucesso.');
    }

    public function destroy(ContractTemplate $contratos_modelo): RedirectResponse
    {
        $contratos_modelo->delete();

        return redirect()->route('gestao.contratos-modelos.index')
            ->with('success', 'Modelo excluído com sucesso.');
    }
}
