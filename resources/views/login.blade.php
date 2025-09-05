@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <a href="{{ url('/') }}" class="d-block text-center mb-3">
            <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="Logo" height="50">
        </a>

        <h5 class="text-center mb-4">Login</h5>

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
                <label for="email" class="form-label">Usuário</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label for="remember" class="form-check-label">Lembrar-me</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none">Esqueci minha senha</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</div>
@endsection