<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de {{ ucfirst($tipo) }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #333; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { margin-bottom: 20px; }
        .periodo { font-size: 16px; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de {{ ucfirst($tipo) }}</h1>
        <div class="periodo">
            Período: {{ \Carbon\Carbon::parse($inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($fim)->format('d/m/Y') }}
        </div>
    </div>

    <table>
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
            @foreach($dados as $dado)
                @switch($tipo)
                    @case('vendas')
                        <tr>
                            <td>{{ $dado->curso->titulo }}</td>
                            <td>{{ $dado->cliente->nome }}</td>
                            <td>R$ {{ number_format($dado->valor, 2, ',', '.') }}</td>
                            <td>{{ $dado->condicao_pagamento }}</td>
                            <td>
                                @if($dado->quantidade_parcelas)
                                    {{ $dado->quantidade_parcelas }}x de R${{ number_format($dado->valor / $dado->quantidade_parcelas, 2, ',', '.') }}
                                @else
                                    À vista
                                @endif
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
            @endforeach
        </tbody>
    </table>
</body>
</html>