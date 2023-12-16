@extends('layouts.app')

@section('title', 'Вход в аккаунт')

@section('content')
<div class="form-container">
    <form id="loginForm" method="POST" action="{{ route('users.login') }}">
        @csrf
        <div class="mb-4">
            <label>Имя пользователя</label>
            <input type="text" name="login" id="login">
            <div class="error" id="error_login"></div>
        </div>
        <div class="mb-5">
            <label>Пароль</label>
            <input type="password" name="password" id="password">
            <div class="error" id="error_password"></div>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="btn bg-pink-100">Войти</button>
            <a href="{{ route('users.register') }}" class="btn bg-pink-100">Регистрация</a>
        </div>
    </form>
</div>
<script src="{{ asset('js/login-form.js') }}" defer></script>    
@endsection