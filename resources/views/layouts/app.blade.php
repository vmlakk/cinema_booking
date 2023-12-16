<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinema Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- blade-formatter-disable --}}
    <style type="text/tailwindcss">
        .btn {
            @apply rounded-md px-2 py-1 text-center  text-slate-700 shadow-sm ring-1 ring-slate-700/20 hover:bg-pink-100/50
        }

        .list {
            @apply flex flex-wrap -mx-1
        }

        .card {
            @apply mb-4 my-1 px-1 w-full md:w-1/4 rounded-lg border container mx-auto
        }

        .error {
            @apply mb-4
        }

        .form-container {
            @apply mb-4 w-1/2 rounded-3xl border bg-pink-500/50 container mx-auto px-2 py-6 
        }

        table {
            @apply mb-6 border-separate border-spacing-4 table-fixed border w-full py-2 py-3 text-slate-800
        }

        label {
            @apply block text-slate-700 mb-2
        }

        input, textarea {
            @apply shadow-sm appearance-none border w-full py-2 px-3 text-slate-700 leading-tight focus:outline-none
        }

        form {
            @apply w-3/4 mx-auto
        }
    </style>
    {{-- blade-formatter-enable --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-pink-100/50">
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