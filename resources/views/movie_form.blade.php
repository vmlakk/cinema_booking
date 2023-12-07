@extends('layouts.app')

@section('title', @isset($movie) ? 'Редактирование фильма' : 'Создание фильма')
 @section('content')
<form method="POST" action="{{ isset($movie) ? route('movies.update', ['movie' => $movie]) : route('movies.store') }}" enctype="multipart/form-data">
    @csrf
    @isset($movie)
        @method('PUT')
    @endisset
    <label>Название</label>
    <input type="text" name="title" id="title" class="mb-4"
    value="{{ $movie->title ?? ""}}">
    <label>Описание</label>
    <textarea name="description" id="description" rows="5" class="mb-4">{{ $movie->description ?? ""}}</textarea>
    <label>Постер</label>
    <input type="file" name="poster" id="poster" class="mb-4">
    <label>Рейтинг</label>
    <input type="number" name="rating" id="rating" class="mb-4" value="{{ $movie->rating ?? ""}}">
    <label>Длительность</label>
    <input type="number" name="duration" id="duration" class="mb-4" value="{{ $movie->duration ?? ""}}">
    <label>Время показа</label>
    <input type="datetime-local" name="showtime" id="showtime" class="mb-4" value="{{ $movie->showtime ?? ""}}">
    <button type="submit" class="btn mb-4">{{ isset($movie) ? 'Обновить фильм' : 'Добавить фильм' }}</button>
</form>

 @endsection