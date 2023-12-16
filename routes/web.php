<?php

use App\Models\Movie;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    $currentTime = now('GMT+3');
    return view('index', [
        'movies' => Movie::where('showtime', '>', $currentTime)->orderBy('showtime', 'asc')->paginate()
    ]);
})->name('movies.index')->middleware('auth');

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

Route::get('/admin', function () {
    return view('admin', [
        'movies' => Movie::all()
    ]);
})->name('admin.account')->middleware('auth')->middleware('admin');

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
            if (Seat::all()->where('movie_id', $data['movie_id'])
            ->where('seat', $data['seat'])->where('row', $data['row'])->count() === 0){
                $seat = new Seat($data);
                $seat->save();
                return redirect()->route('movies.show', ['movie' => $movie]);
            }
            return redirect()->back()->withErrors(['seat' => 'Данное место уже занято.']);
        }
        return redirect()->back()->withErrors(['movie_id' => 'Вы уже забронировали билет на этот фильм.']);
    } return redirect()->back()->withErrors(['showtime' => 'Билеты на этот фильм больше недоступны для бронирования.']);
})->name('seats.store');

Route::post('/register', function(Request $request) {
    $data = $request->validate([
        'login' => 'required|max:255|unique:users',
        'password' => 'required|min:5',
        'confirm_password' => 'required|same:password'
    ]);
    $user = new User($data);
    $user->save();
    Auth::login($user);
    return redirect()->route('movies.index');
})->name('users.store');

Route::post('/login', function(Request $request) {
    $data = $request->validate([
        'login' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt(['login' => $request->login, 'password' => $request->password])) {
        $request->session()->regenerate();
        return redirect()->route('movies.index');
    } 

    return back()->withErrors([
        'login' => 'Неправильный логин или пароль.',
        'password' => 'Неправильный пароль или пароль.',
    ]);
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