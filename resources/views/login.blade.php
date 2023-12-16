@extends('layouts.app')

@section('title', 'Вход в аккаунт')

@section('content')

@error('login')
    <p class="error">{{ $message }}</p>
@enderror
<div class="form-container">
    <form method="POST" action="{{ route('users.login') }}">
        @csrf
        <div class="mb-4">
            <label>Имя пользователя</label>
            <input type="text" name="login" id="login">
        </div>
        <div class="mb-5">
            <label>Пароль</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="flex gap-4">
            <button type="submit" class="btn bg-pink-100">Войти</button>
            <a href="{{ route('users.register') }}" class="btn bg-pink-100">Регистрация</a>
        </div>
    </form>
</div>    
@endsection