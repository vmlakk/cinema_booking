@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div id="account-data" 
data-fetch-url="{{ route('api.account.seats') }}" 
data-delete-url="{{ url('/api/account/seats/') }}"
data-poster-base-url="{{ asset('storage/posters/') }}"
data-csrf-token="{{ csrf_token() }}"
>
    <h2 class="mb-4 text-center text-lg">Здравствуйте, {{ Auth::user()->login }}. Ваши бронирования:</h2>
    <h3 class="mb-4 text-lg">Активные бронирования:</h3>  
    <div class="list mb-4 active-seats">
    @forelse ($active_seats as $seat) 
        <div class="card">
            <div class="flex justify-center">
                <img src="{{ asset('storage/posters/' . $seat->movie->poster) }}" alt="Постер фильма" class="object-fill h-80 w-50 rounded-lg">
            </div>
            <div class="flex justify-center">
                <h4>{{ $seat->movie->title }}</h4>
            </div>
                <div class="flex gap-3 justify-center">
                <p>{{ $seat->movie->showtime }}</p>
            </div>
            <div class="flex gap-1 justify-center">
                <p>Место: {{ $seat->seat }} Ряд: {{ $seat->row }}</p>
            </div>
                <form method="POST" action="{{ route('seats.delete', ['seat' => $seat]) }}" class="px-2 p-0 m-0 delete-seat-form" data-seat-id="{{ $seat->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn bg-pink-400/25 mt-3">Удалить</button>
            </form>
        </div>
    @empty
        <div class="mb-4">
            <h4>У вас пока нет бронирований</h4>
        </div> 
    @endforelse
    </div>

    <h3 class="mb-4 text-lg">Прошлые бронирования:</h3>
    <div class="list mb-4 passed-seats">
    @forelse($passed_seats as $seat)
        <div class="card">
            <div class="flex justify-center">
                <img src="{{ asset('storage/posters/' . $seat->movie->poster) }}" alt="Постер фильма" class="object-fill h-80 w-50 rounded-lg">
            </div>
            <div class="flex justify-center">
                <h4>{{ $seat->movie->title }}</h4>
            </div>
            <div class="flex gap-3 justify-center">
                <p>{{ $seat->movie->showtime }}</p>
            </div>
            <div class="flex gap-3 justify-center">
                <p>Место: {{ $seat->seat }} Ряд: {{ $seat->row }}</p>
            </div>
        </div>
    @empty
        <div class="mb-4">
            <h4>У вас пока нет бронирований</h4>
        </div> 
    @endforelse
    </div>

    <form method="POST" action="{{ route('users.logout') }}">
        @csrf
        <button type="submit" class="btn mb-4 bg-pink-400/25">Выйти</button>
    </form>
</div>
<script src="{{ asset('js/account.js') }}" defer></script>
@endsection