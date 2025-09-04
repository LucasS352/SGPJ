@extends('layout')

@section('content')
  <h1>Login</h1>
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="E-mail">
    <input type="password" name="password" placeholder="Senha">
    <button type="submit">Entrar</button>
  </form>
@endsection