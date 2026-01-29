<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index()
    {
        return response()->json(Professor::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:professors,email'
        ]);

        $professor = Professor::create($validated);
        return response()->json($professor, 201);
    }

    public function show(Professor $professor)
    {
        return response()->json($professor);
    }

    public function update(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:professors,email,' . $professor->id
        ]);

        $professor->update($validated);
        return response()->json($professor);
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return response()->json(['mensagem' => 'Professor deletado com sucesso']);
    }
}
