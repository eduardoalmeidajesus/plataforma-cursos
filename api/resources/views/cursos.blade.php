@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Cursos</h1>

    {{-- FORMULÁRIO --}}
    <div class="card mb-4">
        <div class="card-header">{{ isset($curso) ? 'Editar Curso' : 'Novo Curso' }}</div>
        <div class="card-body">
            <form action="{{ isset($curso) ? route('cursos.update', $curso->id) : route('cursos.store') }}" method="POST">
                @csrf
                @if(isset($curso))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $curso->titulo ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" required>{{ old('descricao', $curso->descricao ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="preco" class="form-label">Preço (R$)</label>
                    <input type="number" step="0.01" name="preco" class="form-control" value="{{ old('preco', $curso->preco ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoria</label>
                    <select name="categoria_id" class="form-control" required>
                        <option value="">-- Selecione --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $curso->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="professor_id" class="form-label">Professor</label>
                    <select name="professor_id" class="form-control" required>
                        <option value="">-- Selecione --</option>
                        @foreach($professores as $professor)
                            <option value="{{ $professor->id }}" {{ old('professor_id', $curso->professor_id ?? '') == $professor->id ? 'selected' : '' }}>
                                {{ $professor->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-{{ isset($curso) ? 'primary' : 'success' }}">
                    {{ isset($curso) ? 'Atualizar' : 'Salvar' }}
                </button>
                @if(isset($curso))
                    <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABELA DE CURSOS --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Professor</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
                <tr>
                    <td>{{ $curso->titulo }}</td>
                    <td>{{ $curso->professor->nome }}</td>
                    <td>{{ $curso->categoria->nome }}</td>
                    <td>R$ {{ number_format($curso->preco, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
