@extends('layouts.app')

@section('content')
<div class="container mt-2"> {{-- ALTERADO AQUI: Reduz a margem superior para subir o conteúdo --}}

    {{-- Alerts --}}
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    {{-- Busca --}}
    <form method="GET" action="{{ route('processos.index') }}" class="mb-3">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por Réu ou Nº do Processo"
            class="form-control" />
    </form>

    {{-- Abas --}}
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link {{ ($tab ?? 'all')=='all'?'active':'' }}" href="?tab=all">Todos</a></li>
    </ul>

    {{-- Botão de adicionar à pasta --}}
    <form method="POST" id="assignForm" action="">
        @csrf
        {{-- NOTE: inputs dinamicamente criados com name="processos[]" no submit --}}
        <div class="mb-3 d-flex align-items-center gap-2">
            {{-- ALTERADO AQUI: Adiciona o atributo data-url com um placeholder --}}
            <select id="folderSelect" class="form-select d-inline w-auto" data-url="{{ route('pastas.addProcessos', ['folder' => '__folderId__']) }}">
                <option value="">Selecione uma pasta</option>
                @foreach($folders as $f)
                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                @endforeach
            </select>
            <button type="submit" id="assignButton" class="btn btn-primary ms-2" disabled>
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
                        <a href="?tab={{ $tab ?? 'all' }}&search={{ $search ?? '' }}&sort=valor_causa&direction={{ ($direction ?? 'desc')=='asc'?'desc':'asc' }}">
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
                        <td>{{ number_format($p->valor_causa_float ?? 0, 2, ',', '.') }}</td>
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
    function getSelectedIds() {
        return Array.from(document.querySelectorAll('input[name="processo_ids[]"]:checked')).map(cb => cb.value);
    }

    function toggleAssignButton() {
        const selected = getSelectedIds();
        const button = document.getElementById('assignButton');
        const folderSelected = document.getElementById('folderSelect').value;
        button.disabled = selected.length === 0 || !folderSelected;
    }

    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function(e) {
            document.querySelectorAll('input[name="processo_ids[]"]').forEach(cb => cb.checked = e.target.checked);
            toggleAssignButton();
        });
    }

    document.querySelectorAll('input[name="processo_ids[]"]').forEach(cb => {
        cb.addEventListener('change', toggleAssignButton);
    });

    const folderSelect = document.getElementById('folderSelect');
    if (folderSelect) {
        folderSelect.addEventListener('change', function(e) {
            const folderId = e.target.value;
            const form = document.getElementById('assignForm');
            // ALTERADO AQUI: Pega a URL do data attribute com o placeholder
            const urlTemplate = folderSelect.dataset.url;
            if (folderId) {
                // ALTERADO AQUI: Substitui o placeholder pelo ID real da pasta
                form.action = urlTemplate.replace('__folderId__', folderId);
            } else {
                form.action = "";
            }
            toggleAssignButton();
        });
    }

    const assignForm = document.getElementById('assignForm');
    if (assignForm) {
        assignForm.addEventListener('submit', function(e) {
            const selected = getSelectedIds();
            const folderId = document.getElementById('folderSelect').value;

            if (selected.length === 0 || !folderId) {
                e.preventDefault();
                alert('Selecione ao menos um processo e uma pasta.');
                return false;
            }

            // Remove inputs dinâmicos antigos
            this.querySelectorAll('input[name="processos[]"]').forEach(n => n.remove());

            // Cria novos inputs ocultos para cada processo selecionado
            selected.forEach(id => {
                const inp = document.createElement('input');
                inp.type = 'hidden';
                inp.name = 'processos[]';
                inp.value = id;
                this.appendChild(inp);
            });
        });
    }
</script>


@endsection