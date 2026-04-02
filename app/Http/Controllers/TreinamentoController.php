<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingFolder;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TreinamentoController extends Controller
{
    // ── Pastas ──────────────────────────────────────────────────────────────

    public function index()
    {
        $folders = TrainingFolder::withCount('trainings')
            ->with('clinic')
            ->orderBy('nome')
            ->get();

        return view('operacional.treinamentos.index', compact('folders'));
    }

    public function createFolder()
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('operacional.treinamentos.create-folder', compact('clinics'));
    }

    public function storeFolder(Request $request)
    {
        $data = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'clinic_id' => 'nullable|exists:clinics,id',
        ]);
        $data['user_id'] = Auth::id();
        TrainingFolder::create($data);

        return redirect()->route('operacional.treinamentos.index')
            ->with('success', 'Pasta criada com sucesso.');
    }

    public function destroyFolder(TrainingFolder $pasta)
    {
        foreach ($pasta->trainings as $t) {
            if ($t->arquivo_path) {
                Storage::disk('public')->delete($t->arquivo_path);
            }
        }
        $pasta->delete();

        return redirect()->route('operacional.treinamentos.index')
            ->with('success', 'Pasta excluída com sucesso.');
    }

    // ── Arquivos dentro de pasta ─────────────────────────────────────────────

    public function showFolder(TrainingFolder $pasta)
    {
        $pasta->load(['trainings.user', 'clinic']);
        return view('operacional.treinamentos.show-folder', compact('pasta'));
    }

    public function createFile(TrainingFolder $pasta)
    {
        return view('operacional.treinamentos.create-file', compact('pasta'));
    }

    public function storeFile(Request $request, TrainingFolder $pasta)
    {
        $data = $request->validate([
            'titulo'         => 'required|string|max:255',
            'descricao'      => 'nullable|string',
            'tipo'           => 'required|in:pdf,texto,imagem',
            'arquivo'        => 'nullable|file|max:51200|mimes:pdf,jpg,jpeg,png,gif,webp',
            'conteudo_texto' => 'nullable|string',
        ]);

        if ($request->hasFile('arquivo')) {
            $file = $request->file('arquivo');
            $path = $file->store('treinamentos', 'public');
            $data['arquivo_path']    = $path;
            $data['arquivo_nome']    = $file->getClientOriginalName();
            $data['arquivo_tamanho'] = $file->getSize();
        }

        $data['training_folder_id'] = $pasta->id;
        $data['clinic_id']          = $pasta->clinic_id;
        $data['user_id']            = Auth::id();
        unset($data['arquivo']);

        Training::create($data);

        return redirect()->route('operacional.treinamentos.pasta.show', $pasta)
            ->with('success', 'Arquivo adicionado com sucesso.');
    }

    public function show(Training $treinamento)
    {
        $treinamento->load('folder', 'user');
        return view('operacional.treinamentos.show', compact('treinamento'));
    }

    public function destroy(Training $treinamento)
    {
        $pasta = $treinamento->folder;
        if ($treinamento->arquivo_path) {
            Storage::disk('public')->delete($treinamento->arquivo_path);
        }
        $treinamento->delete();

        return redirect()->route('operacional.treinamentos.pasta.show', $pasta)
            ->with('success', 'Arquivo excluído.');
    }
}
