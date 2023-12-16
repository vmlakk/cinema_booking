@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="list">
@forelse ($movies as $movie)
    <div class="card">
        <img src="{{ asset('storage/posters/' . $movie->poster) }}" alt="Постер фильма" class="object-fill h-80 w-46">
        <a href="{{ route('movies.show', ['movie' => $movie]) }}">{{ $movie->title }}</a>
        <div class="flex gap-3">
            <p>{{ $movie->showtime }}</p>
            <x-star-rating :rating="$movie->rating" />
        </div>
    </div>
@empty
    Фильмов нет
@endforelse
</div>

@endsection
