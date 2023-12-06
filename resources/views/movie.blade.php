@extends('layouts.app')

@section('title', $movie->title)

@section('content')
<div class="flex gap-4 mb-4">
    <img src="{{ asset('storage/posters/' . $movie->poster) }}" alt="Постер фильма" class="object-cover h-50 w-80">
    <p class="mb-8">{{ $movie->description }}</p>
    <x-star-rating :rating="$movie->rating" />
    <p>{{ $movie->duration }}</p>
    <p>{{ $movie->showtime }}</p>
</div>

<div class="text-lg text-center">
    <h3 class="mb-4">Бронирование мест:</h3>
    <table>
    <tbody>
    @for ($i = 1; $i <= $movie->max_rows; $i++)
            <tr>
            @for ($j = 1; $j <= $movie->max_seats; $j++)
            @php
                $is_taken = $movie->seats->where('row', $i)->where('seat', $j)->count();
            @endphp
                <td><form method="POST" action={{ route('seats.store', ['movie' => $movie]) }}>
                    @csrf
                    <input type="hidden" name="row" id="row" value="{{ $i }}">
                    <input type="hidden" name="seat" id="seat" value="{{ $j }}">
                    <input type="hidden" name="movie_id" id="movie_id" value="{{ $movie->id }}">
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                    <button type="submit">
                        @if ($is_taken === 0)
                        △
                        @else
                        ▲
                    @endif
                    </button>
                    </form></td>
            @endfor
            </tr>
    @endfor
    </tbody>
    </table>
</div>
    
@endsection