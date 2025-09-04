@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Painel de Processos</h1>

    {{-- Busca --}}
    <form method="GET" action="{{ route('processos.index') }}" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por Réu ou Nº do Processo"
            class="form-control" />
    </form>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link {{ $tab=='all'?'active':'' }}" href="?tab=all">Todos</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab=='100-300'?'active':'' }}" href="?tab=100-300">R$ 100k - 300k</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab=='300-500'?'active':'' }}" href="?tab=300-500">R$ 300k - 500k</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab=='500+'?'active':'' }}" href="?tab=500+">Acima de 500k</a></li>
    </ul>

    {{-- Tabela --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nº Processo</th>
                <th>Réu</th>
                <th>CPF/CNPJ</th>
                <th>Valor da Causa (R$)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($processos as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->numero_processo }}</td>
                    <td>{{ $p->nome_reu }}</td>
                    <td>{{ $p->cpf_cnpj_reu }}</td>
                    <td>{{ number_format($p->valor_causa, 2, ',', '.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('processos.updateStatus', $p) }}">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="form-select">
                                <option value="PENDENTE" {{ $p->status=='PENDENTE'?'selected':'' }}>❓ Pendente</option>
                                <option value="APROVADO" {{ $p->status=='APROVADO'?'selected':'' }}>✅ Aprovado</option>
                                <option value="REJEITADO" {{ $p->status=='REJEITADO'?'selected':'' }}>❌ Rejeitado</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Nenhum processo encontrado</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $processos->links() }}
</div>
@endsection