@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Professores</h1>

    {{-- FORMULÁRIO --}}
    <div class="card mb-4">
        <div class="card-header">{{ isset($professor) ? 'Editar Professor' : 'Novo Professor' }}</div>
        <div class="card-body">
            <form action="{{ isset($professor) ? route('professores.update', $professor->id) : route('professores.store') }}" method="POST">
                @csrf
                @if(isset($professor))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" value="{{ old('nome', $professor->nome ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $professor->email ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-{{ isset($professor) ? 'primary' : 'success' }}">
                    {{ isset($professor) ? 'Atualizar' : 'Salvar' }}
                </button>
                @if(isset($professor))
                    <a href="{{ route('professores.index') }}" class="btn btn-secondary">Cancelar</a>
                @endif
            </form>
        </div>
    </div>

    {{-- TABELA DE PROFESSORES --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($professores as $prof)
                <tr>
                    <td>{{ $prof->nome }}</td>
                    <td>{{ $prof->email }}</td>
                    <td>
                        <a href="{{ route('professores.edit', $prof->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('professores.destroy', $prof->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Excluir professor?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
