<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinema Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- blade-formatter-disable --}}
    <style type="text/tailwindcss">
        .btn {
            @apply rounded-md px-2 py-1 text-center  text-slate-800 shadow-sm ring-1 ring-slate-700/20 hover:bg-pink-100/50
        }

        .list {
            @apply flex flex-wrap -mx-1 gap-1
        }

        .card {
            @apply mb-4 my-1 px-1 py-3 w-full md:w-1/4 container mx-auto rounded-lg bg-pink-300/25 ring-1 ring-pink-500/20 hover:bg-pink-100/50
        }

        .error {
            @apply mb-4 mt-4 bg-white/75 rounded-2xl text-center text-pink-700
        }

        .form-container {
            @apply mb-4 w-1/2 rounded-3xl border bg-pink-500/50 container mx-auto px-2 py-6 
        }

        table {
            @apply mb-6 border-separate border-spacing-4 table-fixed border w-full py-2 py-3 text-slate-800
        }

        label {
            @apply block text-slate-900 mb-2
        }

        input, textarea {
            @apply shadow-sm rounded-xl appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
        }

        form {
            @apply w-3/4 mx-auto
        }
    </style>
    {{-- blade-formatter-enable --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-pink-200/50">
    @if (Auth::check())
    <header class="mt-2 mb-6 flex">
        <a href="{{ route('movies.index') }}" class="text-center grow">Главная</a>
        <a href="{{ route('cinema.show') }}" class="text-center grow">О кинотеатре</a>
        <a href="{{ route('users.account') }}" class="text-center grow">Личный кабинет</a>
        @if (Auth::user()->is_admin)
            <a href="{{ route('admin.account') }}" class="text-center grow">Админ панель</a>
        @endif
    </header>
    @endif
    <div class="px-14">
        <h1 class="mb-10 mt-5 text-2xl font-medium text-center">@yield('title')</h1>
        @yield('content')
    </div>
</body>
</html>