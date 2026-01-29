@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Relatórios</h1>

    <form action="{{ route('relatorios.filtrar') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label for="data_inicio">Data Início</label>
                <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="{{ old('data_inicio', $inicio->format('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label for="data_fim">Data Fim</label>
                <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{ old('data_fim', $fim->format('Y-m-d')) }}">
            </div>
            <div class="col-md-3">
                <label for="tipo">Tipo</label>
                <select name="tipo" id="tipo" class="form-control">
                    <option value="vendas" {{ old('tipo', $tipo) == 'vendas' ? 'selected' : '' }}>Vendas</option>
                    <option value="clientes" {{ old('tipo', $tipo) == 'clientes' ? 'selected' : '' }}>Clientes</option>
                    <option value="cursos" {{ old('tipo', $tipo) == 'cursos' ? 'selected' : '' }}>Cursos</option>
                    <option value="categorias" {{ old('tipo', $tipo) == 'categorias' ? 'selected' : '' }}>Categorias</option>
                    <option value="professores" {{ old('tipo', $tipo) == 'professores' ? 'selected' : '' }}>Professores</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary" style="background-color: #fd7e14">Filtrar</button>
            </div>
        </div>
    </form>

    @if (!empty($tipo))
        <h3>Resultados para: {{ ucfirst($tipo) }}</h3>

        <table class="table table-bordered">
            <thead>
                @switch($tipo)
                    @case('vendas')
                        <tr>
                            <th>Curso</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Condição</th>
                            <th>Parcelas</th>
                            <th>Data</th>
                        </tr>
                        @break
                    @case('clientes')
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data</th>
                        </tr>
                        @break
                    @case('cursos')
                        <tr>
                            <th>Título</th>
                            <th>Professor</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th>Data</th>
                        </tr>
                        @break
                    @case('categorias')
                        <tr>
                            <th>Nome</th>
                            <th>Data</th>
                        </tr>
                        @break
                    @case('professores')
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data</th>
                        </tr>
                        @break
                @endswitch
            </thead>
            <tbody>
                @forelse ($dados as $dado)
                    @switch($tipo)
                        @case('vendas')
                            <tr>
                                <td>{{ $dado->curso->titulo }}</td>
                                <td>{{ $dado->cliente->nome }}</td>
                                <td>R$ {{ number_format($dado->valor, 2, ',', '.') }}</td>
                                <td>{{ $dado->condicao_pagamento }}</td>
                                <td>
                                    {{ $dado->quantidade_parcelas
                                        ? $dado->quantidade_parcelas . 'x de R$' . number_format($dado->valor / $dado->quantidade_parcelas, 2, ',', '.')
                                        : '—' }}
                                </td>
                                <td>{{ $dado->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @break
                        @case('clientes')
                            <tr>
                                <td>{{ $dado->nome }}</td>
                                <td>{{ $dado->email }}</td>
                                <td>{{ $dado->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @break
                        @case('cursos')
                            <tr>
                                <td>{{ $dado->titulo }}</td>
                                <td>{{ $dado->professor->nome }}</td>
                                <td>{{ $dado->categoria->nome }}</td>
                                <td>R$ {{ number_format($dado->preco, 2, ',', '.') }}</td>
                                <td>{{ $dado->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @break
                        @case('categorias')
                            <tr>
                                <td>{{ $dado->nome }}</td>
                                <td>{{ $dado->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @break
                        @case('professores')
                            <tr>
                                <td>{{ $dado->nome }}</td>
                                <td>{{ $dado->email }}</td>
                                <td>{{ $dado->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @break
                    @endswitch
                @empty
                    <tr>
                        <td colspan="10">Nenhum dado encontrado no período.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <form action="{{ route('relatorios.pdf') }}" method="POST" target="_blank" style="display: inline-block; margin-right: 10px;">
                @csrf
                <input type="hidden" name="data_inicio" value="{{ $inicio->format('Y-m-d') }}">
                <input type="hidden" name="data_fim" value="{{ $fim->format('Y-m-d') }}">
                <input type="hidden" name="tipo" value="{{ $tipo }}">
                <button type="submit" class="btn btn-danger">Exportar PDF</button>
            </form>

            <form action="{{ route('relatorios.csv') }}" method="POST" style="display: inline-block;">
                @csrf
                <input type="hidden" name="data_inicio" value="{{ $inicio->format('Y-m-d') }}">
                <input type="hidden" name="data_fim" value="{{ $fim->format('Y-m-d') }}">
                <input type="hidden" name="tipo" value="{{ $tipo }}">
                <button type="submit" class="btn btn-success">Exportar CSV</button>
            </form>
        </div>
    @endif
</div>
@endsection
