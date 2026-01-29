<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    public function index()
    {
        return response()->json(Venda::with(['curso', 'cliente'])->get());
        return response()->json(Curso::select('id', 'titulo', 'preco')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'valor' => 'required|numeric',
            'condicao_pagamento' => 'required',
            'quantidade_parcelas' => 'nullable|integer|min:1|max:12'
        ]);

        $venda = Venda::create($validated);
        return response()->json($venda, 201);
    }

    public function show(Venda $venda)
    {
        return response()->json($venda->load(['curso', 'cliente']));
    }

    public function update(Request $request, Venda $venda)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'cliente_id' => 'required|exists:clientes,id',
            'valor' => 'required|numeric',
            'condicao_pagamento' => 'required',
            'quantidade_parcelas' => 'nullable|integer|min:1|max:12'
        ]);

        $venda->update($validated);
        return response()->json($venda);
    }

    public function destroy(Venda $venda)
    {
        $venda->delete();
        return response()->json(['mensagem' => 'Venda deletada com sucesso']);
    }
}

