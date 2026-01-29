<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        return response()->json(Curso::with(['professor', 'categoria'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required',
            'descricao' => 'required',
            'preco' => 'required|numeric',
            'professor_id' => 'required|exists:professors,id',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $curso = Curso::create($validated);
        return response()->json($curso, 201);
    }

    public function show(Curso $curso)
    {
        return response()->json($curso->load(['professor', 'categoria']));
    }

    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'titulo' => 'required',
            'descricao' => 'required',
            'preco' => 'required|numeric',
            'professor_id' => 'required|exists:professors,id',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $curso->update($validated);
        return response()->json($curso);
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();
        return response()->json(['mensagem' => 'Curso deletado com sucesso']);
    }
}