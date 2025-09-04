@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Gerenciador de Pastas</h1>

    {{-- Formulário de criação --}}
    <div class="card mb-4">
        <div class="card-header">Criar Nova Pasta</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('pastas.store') }}">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Nome da Nova Pasta" value="{{ old('name') }}" required>
                    <button type="submit" class="btn btn-primary">Criar Pasta</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Lista de pastas existentes --}}
    <div class="card">
        <div class="card-header">Pastas Existentes</div>
        <ul class="list-group list-group-flush">
            @forelse($folders as $folder)
                <a href="{{ route('pastas.show', $folder->id) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>{{ $folder->name }}</span>
                    <small class="text-muted">ID: {{ $folder->id }}</small>
                </a>
            @empty
                <li class="list-group-item text-muted">Nenhuma pasta foi criada ainda.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection