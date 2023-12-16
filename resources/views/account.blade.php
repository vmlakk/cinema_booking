@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <h2 class="mb-4 text-center text-lg">Здравствуйте, {{ Auth::user()->login }}. Ваши бронирования:</h2>
    <h3 class="mb-4 text-lg">Активные бронирования</h3>  
    <div class="list mb-4">
    @forelse ($active_seats as $seat) 
        <div class="card">
            <img src="{{ asset('storage/posters/' . $seat->movie->poster) }}" alt="Постер фильма" class="object-fill h-80 w-50">
            <h4>{{ $seat->movie->title }}</h4>
            <div class="flex gap-3">
                <p>{{ $seat->movie->showtime }}</p>
            </div>
            <div class="flex gap-1">
                <p>Место: {{ $seat->seat }} Ряд: {{ $seat->row }}</p>
            </div>
                <form method="POST" action="{{ route('seats.delete', ['seat' => $seat]) }}" class="flex justify-start p-0 m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn mt-3">Удалить</button>
                </form>
        </div>
    @empty
        <div class="mb-4">
            <h4>У вас пока нет бронирований</h4>
        </div> 
    @endforelse
    </div>

    <h3 class="mb-4 text-lg">Прошлые бронирования</h3>
    @forelse($passed_seats as $seat)
        <div class="card">
            <h4>{{ $seat->movie->title }}</h4>
            <div class="flex gap-3">
                <p>{{ $seat->movie->showtime }}</p>
            </div>
            <div class="flex gap-3">
                <p>Место: {{ $seat->seat }} Ряд: {{ $seat->row }}</p>
            </div>
        </div>
    @empty
        <div class="mb-4">
            <h4>У вас пока нет бронирований</h4>
        </div> 
    @endforelse

    <form method="POST" action="{{ route('users.logout') }}">
        @csrf
        <button type="submit" class="btn mb-4">Выйти</button>
    </form>
@endsection