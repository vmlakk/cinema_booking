@extends('layouts.app')

@section('title', @isset($movie) ? 'Редактирование фильма' : 'Создание фильма')
 @section('content')
<div class="mb-4 w-4/5 rounded-3xl border bg-pink-500/50 container mx-auto px-2 py-6 ">
<form method="POST" action="{{ isset($movie) ? route('movies.update', ['movie' => $movie]) : route('movies.store') }}" enctype="multipart/form-data">
    @csrf
    @isset($movie)
        @method('PUT')
    @endisset
    <div class="mb-3">
        <label>Название</label>
        <input type="text" name="title" id="title"
        value="{{ $movie->title ?? ""}}">
        @error('title')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label>Описание</label>
        <textarea name="description" id="description" rows="5">{{ $movie->description ?? ""}}</textarea>
        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label>Постер</label>
        <input type="file" name="poster" id="poster">
        @error('poster')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label>Рейтинг</label>
        <input type="number" name="rating" id="rating" value="{{ $movie->rating ?? ""}}">
        @error('rating')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label>Длительность</label>
        <input type="number" name="duration" id="duration" value="{{ $movie->duration ?? ""}}">
        @error('duration')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-5">
        <label>Время показа</label>
        <input type="datetime-local" name="showtime" id="showtime" value="{{ $movie->showtime ?? ""}}">
        @error('showtime')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="btn mb-4 bg-pink-100">{{ isset($movie) ? 'Обновить фильм' : 'Добавить фильм' }}</button>
</form>
<div>

 @endsection