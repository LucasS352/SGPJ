@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Painel de Processos</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Análise de Processos</h5>
        <div id="profit"></div>
    </div>
    </div>

    {{-- Alerts --}}
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    {{-- Busca --}}
    <form method="GET" action="{{ route('processos.index') }}" class="mb-3">
        <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por Réu ou Nº do Processo"
            class="form-control" />
    </form>

    {{-- Abas --}}
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link {{ $tab=='all'?'active':'' }}" href="?tab=all">Todos</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab=='100-300'?'active':'' }}" href="?tab=100-300">R$ 100k - 300k</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab=='300-500'?'active':'' }}" href="?tab=300-500">R$ 300k - 500k</a></li>
        <li class="nav-item"><a class="nav-link {{ $tab=='500+'?'active':'' }}" href="?tab=500+">Acima de 500k</a></li>
    </ul>

    {{-- Botão de adicionar à pasta --}}
    <form method="POST" id="assignForm">
        @csrf
        <input type="hidden" name="processo_ids" id="processo_ids">
        <div class="mb-3">
            <select id="folderSelect" class="form-select d-inline w-auto">
                <option value="">Selecione uma pasta</option>
                @foreach($folders as $f)
                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                @endforeach
            </select>
            <button type="submit" formaction="" id="assignButton" class="btn btn-primary ms-2" disabled>
                Adicionar selecionados à pasta
            </button>
        </div>
    </form>

    {{-- Tabela --}}
    <form id="processosForm">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>ID</th>
                <th>Nº Processo</th>
                <th>Réu</th>
                <th>CPF/CNPJ</th>
                <th>
                    <a href="?tab={{ $tab }}&search={{ $search }}&sort=valor_causa&direction={{ $direction=='asc'?'desc':'asc' }}">
                        Valor da Causa (R$)
                    </a>
                </th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($processos as $p)
                <tr>
                    <td><input type="checkbox" name="processo_ids[]" value="{{ $p->id }}"></td>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->numero_processo }}</td>
                    <td>{{ $p->nome_reu }}</td>
                    <td>{{ $p->cpf_cnpj_reu }}</td>
                    <td>{{ number_format($p->valor_causa_float, 2, ',', '.') }}</td>
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
                <tr><td colspan="7" class="text-center">Nenhum processo encontrado</td></tr>
            @endforelse
        </tbody>
    </table>
    </form>

    {{ $processos->links() }}
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function(e) {
    document.querySelectorAll('input[name="processo_ids[]"]').forEach(cb => cb.checked = e.target.checked);
    toggleAssignButton();
});
document.querySelectorAll('input[name="processo_ids[]"]').forEach(cb => {
    cb.addEventListener('change', toggleAssignButton);
});
function toggleAssignButton() {
    const selected = Array.from(document.querySelectorAll('input[name="processo_ids[]"]:checked')).map(cb => cb.value);
    const button = document.getElementById('assignButton');
    button.disabled = selected.length === 0 || !document.getElementById('folderSelect').value;
    document.getElementById('processo_ids').value = selected;
}
document.getElementById('folderSelect').addEventListener('change', function(e) {
    const folderId = e.target.value;
    document.getElementById('assignButton').formAction = `/folders/${folderId}/add_processos`;
    toggleAssignButton();
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var options = {
        chart: { type: 'bar', height: 350 },
        series: [{
            name: 'Processos',
            data: [10, 25, 15, 5] // <- futuramente puxa do banco
        }],
        xaxis: {
            categories: ['100k-300k', '300k-500k', '500k+', 'Pendentes']
        }
    };

    var chart = new ApexCharts(document.querySelector("#profit"), options);
    chart.render();
});
</script>

@endsection