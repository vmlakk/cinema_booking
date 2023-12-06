@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')

<table>
    <thead>
        <tr>
            <th class="font-semibold">ID</th>
            <th class="font-semibold">Название</th>
            <th class="font-semibold">Удалить</th>
            <th class="font-semibold">Статус</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($movies as $movie)  
        <tr>
            <th class="font-normal">{{ $movie->id }}</th>
            <th>
                <a href="{{ route('movies.show', ['movie' => $movie]) }}" class="font-normal">{{ $movie->title }}</a>
            </th>
            <th>
                <form method="POST" action="{{ route('movies.delete', ['movie' => $movie]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn font-normal">Удалить</button>
                </form>
            </th>
            @if ($movie->showtime > now('GMT+3'))
                <th class="text-green-700 font-semibold">✓</th>
            @else
                <th class="text-red-800 font-semibold">✗</th>
            @endif
        </tr>
        @empty
        <tr></tr>
        @endforelse
    </tbody>
</table>

<div class="btn mx-auto">
<a href="{{ route('movies.create') }}">Добавить фильм</a>
</div>

@endsection