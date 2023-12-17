@extends('layouts.app')

@section('title', $movie->title)

@section('content')
<div id="movie-data" data-movie-url="{{ route('api.movies.show', ['movie' => $movie]) }}">
<div class="flex gap-6 mb-4">
    <img src="{{ asset('storage/posters/' . $movie->poster) }}" alt="Постер фильма" class="object-cover h-50 w-80">

    <div class="flex flex-col m-10">
        <p class="mb-8">{{ $movie->description }}</p>
        
        <div class="flex gap-4">
            <x-star-rating :rating="$movie->rating" />
            <p>Длительность: {{ $movie->duration }} мин.</p>
            <p>Время показа: {{ $movie->showtime }}</p>
        </div>
    </div>
</div>

<div class="text-lg text-center">
    <h3 class="mb-4">Бронирование мест:</h3>
    <table class="rounded-3xl bg-pink-500/25 border-2 border-pink-700/30">
    <tbody>
    @for ($i = 1; $i <= $movie->max_rows; $i++)
            <tr>
            @for ($j = 1; $j <= $movie->max_seats; $j++)
            @php
                $seatId = "seat-" . $i . "-" . $j;
                $is_taken = $movie->seats->where('row', $i)->where('seat', $j)->count();
            @endphp
                <td><form class="seatBookingForm" method="POST" action={{ route('seats.store', ['movie' => $movie]) }}>
                    @csrf
                    <input type="hidden" name="row" id="row" value="{{ $i }}">
                    <input type="hidden" name="seat" id="seat" value="{{ $j }}">
                    <input type="hidden" name="movie_id" id="movie_id" value="{{ $movie->id }}">
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                    <button type="submit" id="{{ $seatId }}" class="{{ $is_taken ? 'taken' : 'available' }} hover:text-pink-700">
                        {{ $is_taken ? '▲' : '△' }}
                    </button>
                    </form></td>
            @endfor
            </tr>
    @endfor
    </tbody>
    </table>
</div>
</div>
<script src="{{ asset('js/movie.js') }}" defer></script>
@endsection