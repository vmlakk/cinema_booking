@extends('layouts.app')

@section('title', 'Вход в аккаунт')

@section('content')

    <div class="error">
        {{ $errors }}
    </div>
    <form method="POST" action="{{ route('users.login') }}">
        @csrf
        <label>Имя пользователя</label>
        <input type="text" name="login" id="login">
        <label>Пароль</label>
        <input type="password" name="password" id="password">
        <button type="submit" class='btn'>Войти</button>
    </form>
    <a href="{{ route('users.register') }}" class="btn">Регистрация</a>

@endsection