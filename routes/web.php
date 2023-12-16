<?php

use App\Models\Movie;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return redirect()->route('movies.index');
});

Route::get('/movies', function () {
    return view('index', [
        'movies' => getActiveMovies()
    ]);
})->name('movies.index')->middleware('auth');

Route::get('/api/movies', function() {
    return response()->json([
        'movies' => getActiveMovies()
    ]);
})->middleware('auth');

function getActiveMovies() {
    $currentTime = now('GMT+3');
    return Movie::all()->where('showtime', '>', $currentTime)->sortBy('showtime');
}

Route::get('/login', function () {
    return view('login');
})->name('users.login')->middleware('guest');

Route::get('/register', function () {
    return view('register');
})->name('users.register')->middleware('guest');

Route::get('/movies/{movie}', function(Movie $movie) {
    if ($movie->showtime < now('GMT+3') && !Auth::user()->is_admin){
        return redirect()->route('movies.index');
    }
    return view('movie', ['movie' => $movie]);
})->name('movies.show')->middleware('auth');

Route::get('/api/movies/{movie}', function(Movie $movie) {
    if ($movie->showtime < now('GMT+3') && !Auth::user()->is_admin) {
        return response()->json(['error' => 'Фильм не активен'], 403);
    }

    $movie->load('seats');
    return response()->json($movie);
})->name('api.movies.show')->middleware('auth');

Route::get('/cinema', function () {
    return view('cinema');
})->name('cinema.show')->middleware('auth');

Route::get('/account', function () {
    $currentTime = now('GMT+3');
    $userSeats = Seat::all()->where('user_id', Auth::user()->id)->sortBy('movie.showtime');

    return view('account', [
        'active_seats' => $userSeats
        ->where('movie.showtime', '>', $currentTime),
        'passed_seats' => $userSeats
        ->where('movie.showtime', '<', $currentTime)
    ]);
})->name('users.account')->middleware('auth');

Route::get('/api/account/seats', function() {
    $currentTime = now('GMT+3');
    $userSeats = Seat::with('movie')
                     ->where('user_id', Auth::user()->id)
                     ->get()
                     ->sortBy('movie.showtime');

    $activeSeats = $userSeats->where('movie.showtime', '>', $currentTime)->load("movie");
    $passedSeats = $userSeats->where('movie.showtime', '<', $currentTime)->load("movie");

    return response()->json(['active_seats' => $activeSeats, 'passed_seats' => $passedSeats]);
})->name('api.account.seats')->middleware('auth');

Route::get('/admin', function () {
    return view('admin', [
        'movies' => Movie::all()
    ]);
})->name('admin.account')->middleware('auth')->middleware('admin');

Route::get('/api/admin', function () {
    $movies = Movie::all();

    return response()->json(['movies' => $movies]);
})->middleware('auth')->middleware('admin');

Route::get('/admin/create', function () {
    return view('admin_create');
})->name('movies.create')->middleware('auth')->middleware('admin');

Route::get('/admin/edit/{movie}', function (Movie $movie) {
    return view('admin_edit', ['movie' => $movie]);
})->name('movies.edit')->middleware('auth')->middleware('admin');

Route::post('/admin/create', function(Request $request){
    $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'poster' => 'required|image|mimes:jpeg,png,jpg|max:8192',
        'rating' => 'required|integer|between:0,5',
        'duration' => 'required|integer|min:1',
        'showtime' => 'required|date|after:now',
    ]);

    if ($request->hasFile('poster')) {
        $imagePath = $request->file('poster')->store('public/posters');
        $data['poster'] = basename($imagePath);
    } else {
        return redirect()->back()->withErrors(['poster' => 'Необходимо загрузить постер фильма.']);
    }

    $movie = new Movie($data);
    $movie->save();
    return redirect()->route('movies.index');
})->name('movies.store');

Route::put('/admin/edit/{movie}', function (Request $request, Movie $movie){ 
    $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'poster' => 'image|mimes:jpeg,png,jpg|max:8192',
        'rating' => 'required|integer|between:0,5',
        'duration' => 'required|integer|min:1',
        'showtime' => 'required|date|after:now',
    ]);

    if ($request->hasFile('poster')) {
        $imagePath = $request->file('poster')->store('public/posters');
        $data['poster'] = basename($imagePath);
    }

    $movie->update($data);
    return redirect()->route('admin.account');
    })->name('movies.update');

Route::post('/movies/{movie}', function(Request $request, Movie $movie) {
    $data = $request->validate([
        'row' => 'required',
        'seat' => 'required',
        'movie_id' => 'required',
        'user_id' => 'required'
    ]);

    if ($movie->showtime > now('GMT+3')){
        if (Auth::user()->seats->where('movie_id', $movie->id)->count() === 0){
            if (Seat::all()
                ->where('movie_id', $data['movie_id'])
                ->where('seat', $data['seat'])
                ->where('row', $data['row'])
                ->count() === 0) {
                $seat = new Seat($data);
                $seat->save();
                return response()->json(['success' => 'Место успешно забронировано']);
            }
            return response()->json(['error' => 'Данное место уже занято'], 422);
        }
        return response()->json(['error' => 'Вы уже забронировали билет на этот фильм'], 422);
    } 
    return response()->json(['error' => 'Билеты на этот фильм больше недоступны для бронирования'], 422);
})->name('seats.store');

Route::post('/register', function(Request $request) {
    $validator = Validator::make($request->all(), [
        'login' => 'required|max:255|unique:users',
        'password' => 'required|min:5',
        'confirm_password' => 'required|same:password',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $data = $validator->validated();

    $user = new User($data);
    $user->save();
    Auth::login($user);
    return response()->json(['redirect' => route('movies.index')]);
})->name('users.store');

Route::post('/login', function(Request $request) {
    $validator = Validator::make($request->all(), [
        'login' => 'required',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $data = $validator->validated();

    if (Auth::attempt(['login' => $data["login"], 'password' => $data["password"]])) {
        $request->session()->regenerate();
        return response()->json(['redirect' => route('movies.index')]);
    } 

    return response()->json(['errors' => [
        'login' => ['Неправильный логин или пароль.'],
        'password' => ['Неправильный пароль или пароль.'],
    ]], 422);
})->name('users.login');

Route::post('/account', function(Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('users.login');
})->name('users.logout');

Route::delete('/admin/{movie}', function(Movie $movie){
    $movie->delete();

    return redirect()->route('admin.account');
})->name('movies.delete');

Route::delete('/account/{seat}', function(Seat $seat){
    $seat->delete();

    return redirect()->route('users.account');
})->name('seats.delete');

Route::delete('/api/account/seats/{seat}', function(Seat $seat) {
    $seat->delete();

    return response()->json(['success' => 'Бронирование успешно удалено']);
})->middleware('auth');