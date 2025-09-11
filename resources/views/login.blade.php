@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card shadow-sm border-0 overflow-hidden">
    <div class="card-body">
        <div class="card-header text-center p-4 mb-2" style="background: linear-gradient(to bottom, #111c2d, #1f2a3d);">
        <a href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logos/icon-logo.png') }}" alt="Logo" height="50">
        </a>
        </div>

        {{-- Exibe erros de validação --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required autofocus
                    placeholder="Insira seu email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required placeholder="Digite sua senha">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label">Lembrar-me</label>
                </div>
            </div>

            <button type="submit" class="btn w-100 text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #111c2d;">
                <span class="iconify" data-icon="mdi:login" data-width="20"></span> Entrar
            </button>

        </form>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var cpfInput = document.getElementById('cpf');
    if (cpfInput) {
      IMask(cpfInput, {
        mask: '000.000.000-00'
      });
    }
  });
</script>

@endsection