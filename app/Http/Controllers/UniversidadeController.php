<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UniversidadeController extends Controller
{
    // ── Cursos ───────────────────────────────────────────────────────────────

    public function index()
    {
        $cursos = Course::withCount('lessons')
            ->with('user', 'clinic')
            ->orderByDesc('created_at')
            ->get();

        return view('operacional.universidade.index', compact('cursos'));
    }

    public function create()
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('operacional.universidade.create', compact('clinics'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'        => 'required|string|max:255',
            'descricao'     => 'nullable|string',
            'instrutor'     => 'nullable|string|max:255',
            'carga_horaria' => 'nullable|integer|min:1',
            'status'        => 'required|in:rascunho,publicado,arquivado',
            'clinic_id'     => 'nullable|exists:clinics,id',
            'thumbnail'     => 'nullable|file|max:5120|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('cursos/thumbnails', 'public');
        }
        $data['user_id'] = Auth::id();
        unset($data['thumbnail']);

        $curso = Course::create($data);

        return redirect()->route('operacional.universidade.show', $curso)
            ->with('success', 'Curso criado com sucesso.');
    }

    public function show(Course $curso)
    {
        $curso->load(['lessons', 'user', 'clinic']);
        return view('operacional.universidade.show', compact('curso'));
    }

    public function edit(Course $curso)
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('operacional.universidade.edit', compact('curso', 'clinics'));
    }

    public function update(Request $request, Course $curso)
    {
        $data = $request->validate([
            'titulo'        => 'required|string|max:255',
            'descricao'     => 'nullable|string',
            'instrutor'     => 'nullable|string|max:255',
            'carga_horaria' => 'nullable|integer|min:1',
            'status'        => 'required|in:rascunho,publicado,arquivado',
            'clinic_id'     => 'nullable|exists:clinics,id',
            'thumbnail'     => 'nullable|file|max:5120|mimes:jpg,jpeg,png,webp',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($curso->thumbnail_path) {
                Storage::disk('public')->delete($curso->thumbnail_path);
            }
            $data['thumbnail_path'] = $request->file('thumbnail')->store('cursos/thumbnails', 'public');
        }
        unset($data['thumbnail']);

        $curso->update($data);

        return redirect()->route('operacional.universidade.show', $curso)
            ->with('success', 'Curso atualizado.');
    }

    public function destroy(Course $curso)
    {
        foreach ($curso->lessons as $aula) {
            if ($aula->arquivo_path) {
                Storage::disk('public')->delete($aula->arquivo_path);
            }
        }
        if ($curso->thumbnail_path) {
            Storage::disk('public')->delete($curso->thumbnail_path);
        }
        $curso->delete();

        return redirect()->route('operacional.universidade.index')
            ->with('success', 'Curso excluído.');
    }

    // ── Aulas ────────────────────────────────────────────────────────────────

    public function createLesson(Course $curso)
    {
        return view('operacional.universidade.create-lesson', compact('curso'));
    }

    public function storeLesson(Request $request, Course $curso)
    {
        $data = $request->validate([
            'titulo'           => 'required|string|max:255',
            'descricao'        => 'nullable|string',
            'tipo'             => 'required|in:video,link,pdf,texto',
            'arquivo'          => 'nullable|file|max:512000|mimes:pdf,mp4,mov,avi,webm',
            'link_externo'     => 'nullable|url|max:2048',
            'conteudo_texto'   => 'nullable|string',
            'duracao_minutos'  => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('arquivo')) {
            $file = $request->file('arquivo');
            $path = $file->store('cursos/aulas', 'public');
            $data['arquivo_path']    = $path;
            $data['arquivo_nome']    = $file->getClientOriginalName();
            $data['arquivo_tamanho'] = $file->getSize();
        }

        $data['course_id'] = $curso->id;
        $data['ordem']     = $curso->lessons()->count() + 1;
        unset($data['arquivo']);

        CourseLesson::create($data);

        return redirect()->route('operacional.universidade.show', $curso)
            ->with('success', 'Aula adicionada com sucesso.');
    }

    public function showLesson(Course $curso, CourseLesson $aula)
    {
        return view('operacional.universidade.show-lesson', compact('curso', 'aula'));
    }

    public function editLesson(Course $curso, CourseLesson $aula)
    {
        return view('operacional.universidade.edit-lesson', compact('curso', 'aula'));
    }

    public function updateLesson(Request $request, Course $curso, CourseLesson $aula)
    {
        $data = $request->validate([
            'titulo'           => 'required|string|max:255',
            'descricao'        => 'nullable|string',
            'tipo'             => 'required|in:video,link,pdf,texto',
            'arquivo'          => 'nullable|file|max:512000|mimes:pdf,mp4,mov,avi,webm',
            'link_externo'     => 'nullable|url|max:2048',
            'conteudo_texto'   => 'nullable|string',
            'duracao_minutos'  => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('arquivo')) {
            if ($aula->arquivo_path) {
                Storage::disk('public')->delete($aula->arquivo_path);
            }
            $file = $request->file('arquivo');
            $path = $file->store('cursos/aulas', 'public');
            $data['arquivo_path']    = $path;
            $data['arquivo_nome']    = $file->getClientOriginalName();
            $data['arquivo_tamanho'] = $file->getSize();
        }
        unset($data['arquivo']);

        $aula->update($data);

        return redirect()->route('operacional.universidade.show', $curso)
            ->with('success', 'Aula atualizada.');
    }

    public function destroyLesson(Course $curso, CourseLesson $aula)
    {
        if ($aula->arquivo_path) {
            Storage::disk('public')->delete($aula->arquivo_path);
        }
        $aula->delete();

        return redirect()->route('operacional.universidade.show', $curso)
            ->with('success', 'Aula excluída.');
    }

    public function reorderLessons(Request $request, Course $curso)
    {
        $request->validate(['ordem' => 'required|array']);
        foreach ($request->ordem as $index => $id) {
            CourseLesson::where('id', $id)->update(['ordem' => $index + 1]);
        }
        return response()->json(['ok' => true]);
    }
}
