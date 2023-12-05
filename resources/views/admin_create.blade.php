@extends('layouts.app')

@section('title', 'Создание фильма')
 @section('content')
<form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data">
    @csrf
    <label>Название</label>
    <input type="text" name="title" id="title" class="mb-4">
    <label>Описание</label>
    <textarea name="description" id="description" rows="5" class="mb-4"></textarea>
    <label>Постер</label>
    <input type="file" name="poster" id="poster" class="mb-4">
    <label>Рейтинг</label>
    <input type="number" name="rating" id="rating" class="mb-4">
    <label>Длительность</label>
    <input type="number" name="duration" id="duration" class="mb-4">
    <label>Время показа</label>
    <input type="datetime-local" name="showtime" id="showtime" class="mb-4">
    <button type="submit" class="btn mb-4">Добавить фильм</button>
</form>

 @endsection