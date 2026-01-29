<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Cliente;
use App\Models\Curso;
use App\Models\Categoria;
use App\Models\Professor;
use Illuminate\Support\Carbon;
use PDF;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorios', [
            'dados' => collect(),
            'inicio' => now()->startOfMonth(),
            'fim' => now()->endOfMonth(),
            'tipo' => null
        ]);
    }

    public function apiRelatorio(Request $request, $tipo)
    {
        $inicio = $request->input('inicio') 
            ? Carbon::parse($request->input('inicio'))->startOfDay() 
            : now()->startOfMonth();
        
        $fim = $request->input('fim') 
            ? Carbon::parse($request->input('fim'))->endOfDay() 
            : now()->endOfMonth();

        switch ($tipo) {
            case 'vendas':
                $dados = Venda::with(['curso', 'cliente'])
                    ->whereBetween('created_at', [$inicio, $fim])
                    ->get();
                break;
            case 'clientes':
                $dados = Cliente::whereBetween('created_at', [$inicio, $fim])->get();
                break;
            case 'cursos':
                $dados = Curso::with(['professor', 'categoria'])
                    ->whereBetween('created_at', [$inicio, $fim])
                    ->get();
                break;
            case 'categorias':
                $dados = Categoria::whereBetween('created_at', [$inicio, $fim])->get();
                break;
            case 'professores':
                $dados = Professor::whereBetween('created_at', [$inicio, $fim])->get();
                break;
            default:
                return response()->json(['error' => 'Tipo de relatório inválido'], 400);
        }

        return response()->json($dados);
    }

    public function exportarPdf(Request $request)
{
    $request->validate([
        'inicio' => 'required|date',
        'fim' => 'required|date',
        'tipo' => 'required|in:vendas,clientes,cursos,categorias,professores'
    ]);

    $inicio = Carbon::parse($request->inicio)->startOfDay();
    $fim = Carbon::parse($request->fim)->endOfDay();
    $tipo = $request->tipo;

    switch ($tipo) {
        case 'vendas':
            $dados = Venda::with(['curso', 'cliente'])
                ->whereBetween('created_at', [$inicio, $fim])
                ->get();
            break;
        case 'clientes':
            $dados = Cliente::whereBetween('created_at', [$inicio, $fim])->get();
            break;
        case 'cursos':
            $dados = Curso::with(['professor', 'categoria'])
                ->whereBetween('created_at', [$inicio, $fim])
                ->get();
            break;
        case 'categorias':
            $dados = Categoria::whereBetween('created_at', [$inicio, $fim])->get();
            break;
        case 'professores':
            $dados = Professor::whereBetween('created_at', [$inicio, $fim])->get();
            break;
    }

    $pdf = PDF::loadView('relatorios_pdf', [
        'dados' => $dados,
        'inicio' => $inicio,
        'fim' => $fim,
        'tipo' => $tipo
    ]);

    return $pdf->download("relatorio-{$tipo}.pdf");
}

    public function exportarCsv(Request $request)
    {
        $request->validate([
            'inicio' => 'required|date',
            'fim' => 'required|date',
            'tipo' => 'required|in:vendas,clientes,cursos,categorias,professores'
        ]);

        $inicio = Carbon::parse($request->inicio)->startOfDay();
        $fim = Carbon::parse($request->fim)->endOfDay();
        $tipo = $request->tipo;

        switch ($tipo) {
            case 'vendas':
                $dados = Venda::with(['curso', 'cliente'])
                    ->whereBetween('created_at', [$inicio, $fim])
                    ->get();
                break;
            case 'clientes':
                $dados = Cliente::whereBetween('created_at', [$inicio, $fim])->get();
                break;
            case 'cursos':
                $dados = Curso::with(['professor', 'categoria'])
                    ->whereBetween('created_at', [$inicio, $fim])
                    ->get();
                break;
            case 'categorias':
                $dados = Categoria::whereBetween('created_at', [$inicio, $fim])->get();
                break;
            case 'professores':
                $dados = Professor::whereBetween('created_at', [$inicio, $fim])->get();
                break;
        }

        $filename = "relatorio-{$tipo}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}"
        ];

        $callback = function () use ($dados, $tipo) {
            $handle = fopen('php://output', 'w');

            switch ($tipo) {
                case 'vendas':
                    fputcsv($handle, ['Curso', 'Cliente', 'Valor', 'Condição', 'Parcelas', 'Data']);
                    foreach ($dados as $v) {
                        fputcsv($handle, [
                            $v->curso->titulo,
                            $v->cliente->nome,
                            number_format($v->valor, 2, ',', '.'),
                            $v->condicao_pagamento,
                            $v->quantidade_parcelas ? "{$v->quantidade_parcelas}x de R$" . number_format($v->valor / $v->quantidade_parcelas, 2, ',', '.') : '—',
                            $v->created_at->format('d/m/Y H:i')
                        ]);
                    }
                    break;
                case 'clientes':
                    fputcsv($handle, ['Nome', 'Email', 'Data']);
                    foreach ($dados as $c) {
                        fputcsv($handle, [$c->nome, $c->email, $c->created_at->format('d/m/Y H:i')]);
                    }
                    break;
                case 'cursos':
                    fputcsv($handle, ['Título', 'Professor', 'Categoria', 'Preço', 'Data']);
                    foreach ($dados as $c) {
                        fputcsv($handle, [
                            $c->titulo,
                            $c->professor->nome,
                            $c->categoria->nome,
                            number_format($c->preco, 2, ',', '.'),
                            $c->created_at->format('d/m/Y H:i')
                        ]);
                    }
                    break;
                case 'categorias':
                    fputcsv($handle, ['Nome', 'Data']);
                    foreach ($dados as $cat) {
                        fputcsv($handle, [$cat->nome, $cat->created_at->format('d/m/Y H:i')]);
                    }
                    break;
                case 'professores':
                    fputcsv($handle, ['Nome', 'Email', 'Data']);
                    foreach ($dados as $p) {
                        fputcsv($handle, [$p->nome, $p->email, $p->created_at->format('d/m/Y H:i')]);
                    }
                    break;
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}