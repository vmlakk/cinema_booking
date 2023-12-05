@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')

    <div>
        {{ $errors }}
    </div>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <label>Имя пользователя</label>
        <input type="text" name="login" id="login">
        @csrf
        <label>Пароль</label>
        <input type="password" name="password" id="password">
        @csrf
        <label>Повторите пароль</label>
        <input type="password" name="confirm_password" id="confirm_password">
        <button type="submit" class="btn">Зарегистрироваться</button>
    </form>
    <a href="{{ route('users.login') }}" class="btn">Войти в аккаунт</a>

@endsection