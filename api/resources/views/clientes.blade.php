@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Clientes</h1>

    {{-- FORMULÁRIO --}}
    <div class="card mb-4">
        <div class="card-header">{{ isset($cliente) ? 'Editar Cliente' : 'Novo Cliente' }}</div>
        <div class="card-body">
            <form action="{{ isset($cliente) ? route('clientes.update', $cliente->id) : route('clientes.store') }}" method="POST">
                @csrf
                @if(isset($cliente))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" value="{{ old('nome', $cliente->nome ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-{{ isset($cliente) ? 'primary' : 'success' }}">
                    {{ isset($cliente) ? 'Atualizar' : 'Salvar' }}
                </button>
                @if(isset($cliente))
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABELA DE CLIENTES --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cli)
                <tr>
                    <td>{{ $cli->nome }}</td>
                    <td>{{ $cli->email }}</td>
                    <td>
                        <a href="{{ route('clientes.edit', $cli->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('clientes.destroy', $cli->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir cliente?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
