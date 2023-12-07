@extends('layouts.app')

@section('content')
    @include('movie_form', ['movie' => $movie])
@endsection