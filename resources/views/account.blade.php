@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <h2 class="mb-4 text-center text-lg">Здравствуйте, {{ Auth::user()->login }}. Ваши бронирования:</h2>
    <h3 class="mb-4">Активные бронирования</h3>  
    @forelse ($active_seats as $seat) 
        <div class="card">
            <h4>{{ $seat->movie->title }}</h4>
            <div class="flex gap-3">
                <p>{{ $seat->movie->showtime }}</p>
                <p>Место: {{ $seat->seat }} Ряд: {{ $seat->row }}</p>
                <form method="POST" action="{{ route('seats.delete', ['seat' => $seat]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn font-normal">Удалить</button>
                </form>
            </div>  
        </div>
    @empty
        <div class="mb-4">
            <h4>У вас пока нет бронирований</h4>
        </div> 
    @endforelse

    <h3 class="mb-4">Прошлые бронирования</h3>
    @forelse($passed_seats as $seat)
        <div class="card">
            <h4>{{ $seat->movie->title }}</h4>
            <div class="flex gap-3">
                <p>{{ $seat->movie->showtime }}</p>
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
        <button type="submit" class="btn">Выйти</button>
    </form>
@endsection