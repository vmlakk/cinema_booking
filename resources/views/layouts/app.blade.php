<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cinema Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- blade-formatter-disable --}}
    <style type="text/tailwindcss">
        .btn {
            @apply rounded-md px-2 py-1 text-center  text-slate-700 shadow-sm ring-1 ring-slate-700/20 hover:bg-slate-50
        }

        .card {
            @apply mb-4
        }

        .error {
            @apply mb-4
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
    </style>
    {{-- blade-formatter-enable --}}

</head>
<body>
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
        <h1 class="mb-10 text-2xl font-medium text-center">@yield('title')</h1>
        @yield('content')
    </div>
</body>
</html>