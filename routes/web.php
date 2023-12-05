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
    return view('movie', ['movie' => $movie]);
})->name('movies.show')->middleware('auth');

Route::get('/cinema', function () {
    return view('cinema');
})->name('cinema.show')->middleware('auth');

Route::get('/account', function () {
    return view('account', ['seats' => Seat::all()]);
})->name('users.account')->middleware('auth');

Route::get('/admin', function () {
    return view('admin', [
        'movies' => Movie::all()
    ]);
})->name('admin.account')->middleware('auth')->middleware('admin');

Route::get('/admin/create', function () {
    return view('admin_create');
})->name('movies.create')->middleware('auth')->middleware('admin');

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

Route::post('/movies/{movie}', function(Request $request, Movie $movie) {
    $data = $request->validate([
        'row' => 'required',
        'seat' => 'required',
        'movie_id' => 'required',
        'user_id' => 'required'
    ]);
    if (Auth::user()->seats->where('movie_id', $movie->id)->count() === 0){
        $seat = new Seat($data);
        $seat->save();
        return redirect()->route('movies.show', ['movie' => $movie]);
    }
    return redirect()->back()->withErrors(['movie_id' => 'Вы уже забронировали билет на этот фильм. ']);
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
        'password' => 'Неправильный логин или пароль.',
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