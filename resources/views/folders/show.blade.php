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
                                    {{-- Botão que abre o modal --}}
                                    <button type="button" class="btn btn-sm btn-info" 
                                            data-bs-toggle="modal" data-bs-target="#observationModal"
                                            data-id="{{ $p->id }}" 
                                            data-observation="{{ $p->pivot->observation ?? '' }}">
                                        Observação
                                    </button>
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

{{-- MODAL PARA EDIÇÃO DE OBSERVAÇÃO --}}
<div class="modal fade" id="observationModal" tabindex="-1" aria-labelledby="observationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="observationModalLabel">Editar Observação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="observationForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="observation-text" class="col-form-label">Observação:</label>
                        <textarea class="form-control" id="observation-text" name="observation" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const observationModal = document.getElementById('observationModal');
        const observationForm = document.getElementById('observationForm');
        const observationTextarea = document.getElementById('observation-text');

        observationModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const processId = button.getAttribute('data-id');
            const observation = button.getAttribute('data-observation');
            const folderId = "{{ $folder->id }}";

            // Atualiza a URL do formulário no modal
            observationForm.action = `/pastas/${folderId}/processos/${processId}`;

            // Preenche a textarea com a observação existente
            observationTextarea.value = observation;
        });
    });
</script>

@endsection
