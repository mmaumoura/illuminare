<?php

namespace App\Http\Controllers;

use App\Models\GalleryImage;
use App\Models\ImageFolder;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BancoImagemController extends Controller
{
    // ── Pastas ──────────────────────────────────────────────────────────────

    public function index()
    {
        $folders = ImageFolder::withCount('images')
            ->with('clinic')
            ->orderBy('nome')
            ->get();

        return view('operacional.banco-imagens.index', compact('folders'));
    }

    public function createFolder()
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('operacional.banco-imagens.create-folder', compact('clinics'));
    }

    public function storeFolder(Request $request)
    {
        $data = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'clinic_id' => 'nullable|exists:clinics,id',
        ]);
        $data['user_id'] = Auth::id();
        ImageFolder::create($data);

        return redirect()->route('operacional.banco-imagens.index')
            ->with('success', 'Pasta criada com sucesso.');
    }

    public function destroyFolder(ImageFolder $pasta)
    {
        foreach ($pasta->images as $img) {
            Storage::disk('public')->delete($img->arquivo_path);
        }
        $pasta->delete();

        return redirect()->route('operacional.banco-imagens.index')
            ->with('success', 'Pasta excluída com sucesso.');
    }

    // ── Imagens dentro de pasta ──────────────────────────────────────────────

    public function showFolder(ImageFolder $pasta)
    {
        $pasta->load(['images.user', 'clinic']);
        return view('operacional.banco-imagens.show-folder', compact('pasta'));
    }

    public function createImage(ImageFolder $pasta)
    {
        return view('operacional.banco-imagens.create-image', compact('pasta'));
    }

    public function storeImage(Request $request, ImageFolder $pasta)
    {
        $data = $request->validate([
            'titulo'    => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'tags'      => 'nullable|string|max:500',
            'arquivo'   => 'required|file|max:20480|mimes:jpg,jpeg,png,gif,webp',
        ]);

        $file = $request->file('arquivo');
        $path = $file->store('banco-imagens', 'public');

        $data['arquivo_path']    = $path;
        $data['arquivo_nome']    = $file->getClientOriginalName();
        $data['arquivo_tamanho'] = $file->getSize();
        $data['mime_type']       = $file->getMimeType();
        $data['image_folder_id'] = $pasta->id;
        $data['clinic_id']       = $pasta->clinic_id;
        $data['user_id']         = Auth::id();
        unset($data['arquivo']);

        GalleryImage::create($data);

        return redirect()->route('operacional.banco-imagens.pasta.show', $pasta)
            ->with('success', 'Imagem adicionada com sucesso.');
    }

    public function show(GalleryImage $imagem)
    {
        $imagem->load('folder', 'user');
        return view('operacional.banco-imagens.show', compact('imagem'));
    }

    public function destroy(GalleryImage $imagem)
    {
        $pasta = $imagem->folder;
        Storage::disk('public')->delete($imagem->arquivo_path);
        $imagem->delete();

        return redirect()->route('operacional.banco-imagens.pasta.show', $pasta)
            ->with('success', 'Imagem excluída.');
    }
}
