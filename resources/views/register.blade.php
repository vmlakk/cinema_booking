@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="form-container">
    <form id="registerForm" method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="mb-4">
            <label>Имя пользователя</label>
            <input type="text" name="login" id="login">
            <div class="error" id="error_login"></div>
        </div>
        <div class="mb-4">
            <label>Пароль</label>
            <input type="password" name="password" id="password">
            <div class="error" id="error_password"></div>
        </div>
        <div class="mb-5">
            <label>Повторите пароль</label>
            <input type="password" name="confirm_password" id="confirm_password">
            <div class="error" id="error_confirm_password"></div>
        </div>
        <div class="flex gap-4">
            <button type="submit" class="btn bg-pink-100">Зарегистрироваться</button>
            <a href="{{ route('users.login') }}" class="btn bg-pink-100">Войти в аккаунт</a>
        </div>
    </form>
</div>
<script src="{{ asset('js/register-form.js') }}" defer></script>

@endsection