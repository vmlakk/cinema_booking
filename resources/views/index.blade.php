@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="list" 
data-poster-url="{{ asset('storage/posters/') }}"
data-movie-url="{{ url('/movies/') }}"
data-api-url="{{ url('/api/movies') }}">
@forelse ($movies as $movie)
    <div class="card">
        <div class="flex justify-center">
            <img src="{{ asset('storage/posters/' . $movie->poster) }}" alt="Постер фильма" class="object-fill h-80 w-46 rounded-lg">
        </div>
        <div class="flex justify-center">
            <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="hover:text-pink-700/75">{{ $movie->title }}</a>
        </div>
        <div class="flex gap-3 justify-center">
            <p>{{ $movie->showtime }}</p>
            <x-star-rating :rating="$movie->rating" />
        </div>
    </div>
@empty
    Фильмов нет
@endforelse
</div>
<script src="{{ asset('js/index.js') }}" defer></script>
@endsection
