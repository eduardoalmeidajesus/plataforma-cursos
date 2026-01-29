@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #fd7e14">
                    <h4 class="mb-0">{{ isset($venda) ? 'Editar Venda' : 'Nova Venda' }}</h4>
                    <i class="bi bi-cart-plus fs-4"></i>
                </div>
                <div class="card-body">
                    <form action="{{ isset($venda) ? route('vendas.update', $venda->id) : route('vendas.store') }}" method="POST">
                        @csrf
                        @if(isset($venda))
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="curso_id" class="form-label">Curso</label>
                                <select name="curso_id" id="curso_id" class="form-select" required onchange="atualizarPreco()">
                                    <option value="">-- Selecione --</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}"
                                                data-preco="{{ $curso->preco }}"
                                                {{ old('curso_id', $venda->curso_id ?? '') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cliente_id" class="form-label">Cliente</label>
                                <select name="cliente_id" id="cliente_id" class="form-select" required>
                                    <option value="">-- Selecione --</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" {{ old('cliente_id', $venda->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                                            {{ $cliente->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="valor" class="form-label">Valor (R$)</label>
                                <input type="number" step="0.01" name="valor" id="valor" class="form-control" value="{{ old('valor', $venda->valor ?? '') }}" readonly required>
                            </div>

                            <div class="col-md-4">
                                <label for="condicao_pagamento" class="form-label">Condição de Pagamento</label>
                                <select name="condicao_pagamento" id="condicao_pagamento" class="form-select" onchange="mostrarParcelas()" required>
                                    <option value="">-- Selecione --</option>
                                    <option value="PIX à vista" {{ old('condicao_pagamento', $venda->condicao_pagamento ?? '') == 'PIX à vista' ? 'selected' : '' }}>PIX à vista</option>
                                    <option value="Cartão de crédito" {{ old('condicao_pagamento', $venda->condicao_pagamento ?? '') == 'Cartão de crédito' ? 'selected' : '' }}>Cartão de crédito</option>
                                </select>
                            </div>

                            <div class="col-md-4" id="parcelas-section" style="display: none;">
                                <label for="quantidade_parcelas" class="form-label">Parcelas</label>
                                <select id="quantidade_parcelas" name="quantidade_parcelas" class="form-select" onchange="calcularParcelas()">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}x</option>
                                    @endfor
                                </select>
                                <div class="form-text mt-1" id="valor-parcela-texto"></div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            @if(isset($venda))
                                <a href="{{ route('vendas.index') }}" class="btn btn-outline-secondary">
                                    Cancelar
                                </a>
                            @endif
                            <button type="submit" class="btn btn-{{ isset($venda) ? 'primary' : 'success' }}">
                                {{ isset($venda) ? 'Atualizar' : 'Salvar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow mt-5">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-list"></i> Vendas Cadastradas</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Curso</th>
                                <th>Cliente</th>
                                <th>Valor</th>
                                <th>Condição</th>
                                <th>Parcelas</th>
                                <th>Data</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendas as $v)
                                <tr>
                                    <td>{{ $v->curso->titulo }}</td>
                                    <td>{{ $v->cliente->nome }}</td>
                                    <td>R$ {{ number_format($v->valor, 2, ',', '.') }}</td>
                                    <td>{{ $v->condicao_pagamento }}</td>
                                    <td>{{ $v->quantidade_parcelas ?? '—' }}</td>
                                    <td>{{ $v->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('vendas.edit', $v->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('vendas.destroy', $v->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir venda?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Atualiza o valor do curso selecionado e recalcula as parcelas
function atualizarPreco() {
    const select = document.getElementById('curso_id');
    const selectedOption = select.options[select.selectedIndex];
    const preco = selectedOption.getAttribute('data-preco');
    const valorInput = document.getElementById('valor'); // Campo de input onde mostra o valor
    if (preco) {
        valorInput.value = parseFloat(preco).toFixed(2);
    } else {
        valorInput.value = '';
    }
    calcularParcelas(); // Atualiza o valor da parcela com o novo preço
}

// Mostra ou esconde o campo de parcelas, dependendo da forma de pagamento
function mostrarParcelas() {
    const condicao = document.getElementById('condicao_pagamento').value;
    const secaoParcelas = document.getElementById('parcelas-section');
    secaoParcelas.style.display = condicao === 'Cartão de crédito' ? 'block' : 'none';
    if (condicao !== 'Cartão de crédito') {
        document.getElementById('valor-parcela-texto').innerText = '';
    }
}

// Calcula o valor de cada parcela se for cartão de crédito
function calcularParcelas() {
    const condicao = document.getElementById('condicao_pagamento').value;
    if (condicao !== 'Cartão de crédito') return; // Se não for cartão, sai da função
    const valorTotal = parseFloat(document.getElementById('valor').value || 0); // Pega valor total
    const parcelas = parseInt(document.getElementById('quantidade_parcelas').value || 1); // Pega número de parcelas
    const valorParcela = (valorTotal / parcelas).toFixed(2); // Calcula valor por parcela
    document.getElementById('valor-parcela-texto').innerText = `Valor por parcela: R$ ${valorParcela} em ${parcelas}x`;
}

// Quando a página carrega, já atualiza os valores automaticamente
window.addEventListener('DOMContentLoaded', () => {
    atualizarPreco();
    mostrarParcelas();
});
</script>
@endsection
