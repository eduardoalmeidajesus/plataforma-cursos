@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Categorias</h1>

    {{-- FORMULÁRIO --}}
    <div class="card mb-4">
        <div class="card-header">{{ isset($categoria) ? 'Editar Categoria' : 'Nova Categoria' }}</div>
        <div class="card-body">
            <form action="{{ isset($categoria) ? route('categorias.update', $categoria->id) : route('categorias.store') }}" method="POST">
                @csrf
                @if(isset($categoria))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" value="{{ old('nome', $categoria->nome ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-{{ isset($categoria) ? 'primary' : 'success' }}">
                    {{ isset($categoria) ? 'Atualizar' : 'Salvar' }}
                </button>
                @if(isset($categoria))
                    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABELA DE CATEGORIAS --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $cat)
                <tr>
                    <td>{{ $cat->nome }}</td>
                    <td>
                        <a href="{{ route('categorias.edit', $cat->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('categorias.destroy', $cat->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir categoria?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
