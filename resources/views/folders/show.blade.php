@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Pasta: {{ $folder->name }}</h1>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header">Processos nesta pasta</div>
        <div class="card-body p-0">
            @if($processos->count())
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nº Processo</th>
                            <th>Réu</th>
                            <th>CPF/CNPJ</th>
                            <th>Valor da Causa</th>
                            <th>Status</th>
                            <th>Observação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($processos as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->numero_processo }}</td>
                                <td>{{ $p->nome_reu }}</td>
                                <td>{{ $p->cpf_cnpj_reu }}</td>
                                <td>{{ $p->valor_causa }}</td>
                                <td>{{ $p->status }}</td>
                                <td>
                                    {{-- Form para editar observação --}}
                                    <form method="POST" action="{{ route('pastas.updateProcesso', [$folder, $p]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="observation" class="form-control"
                                               value="{{ $p->pivot->observation ?? '' }}" placeholder="Observação">
                                        <button type="submit" class="btn btn-sm btn-primary mt-1">Salvar</button>
                                    </form>
                                </td>
                                <td>
                                    {{-- Form para remover processo --}}
                                    <form method="POST" action="{{ route('pastas.removeProcesso', [$folder, $p]) }}" onsubmit="return confirm('Remover este processo da pasta?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted m-3">Nenhum processo foi adicionado a esta pasta ainda.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('pastas.index') }}" class="btn btn-secondary mt-3">← Voltar</a>
</div>
@endsection