@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
<div id="admin-data" data-fetch-url="{{ url('/api/movies') }}">
<table>
    <thead>
        <tr>
            <th class="font-semibold">ID</th>
            <th class="font-semibold">Название</th>
            <th class="font-semibold">Редактирование</th>
            <th class="font-semibold">Удаление</th>
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
                <a href="{{ route('movies.edit', ['movie' => $movie]) }}" class="btn font-normal">Редактировать</a>
            </th>
            <th>
                <form method="POST" action="{{ route('movies.delete', ['movie' => $movie]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn font-normal">Удалить</button>
                </form>
            </th>
            <th id="movie-status-{{ $movie->id }}">
                @php
                    $isActive = $movie->showtime > now('GMT+3');
                    if($isActive){
                        echo '<span class="text-green-700 font-semibold">✓</span>';
                    } else {
                        echo '<span class="text-red-800 font-semibold">✗</span>';
                    }
                @endphp
            </th>
        </tr>
        @empty
        <tr></tr>
        @endforelse
    </tbody>
</table>

<div class="btn mx-auto">
<a href="{{ route('movies.create') }}">Добавить фильм</a>
</div>
</div>
<script src="{{ asset('js/admin.js') }}" defer></script>
@endsection