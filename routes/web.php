<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AllMoviesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use \App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;


Route::get('/', function () {
    return view('Users/login');
});



Route::middleware(['auth', 'verified'])->group(function () {
    #Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardMovieController::class, 'index'])->name('movies.dashboard');

    #Todos filmes
    Route::get('/movies', [AllMoviesController::class, 'index'])->name('movies.index');
    Route::delete('/movies/{movie}', [AllMoviesController::class, 'destroy'])->name('movies.destroy');
    Route::post('/movies', [AllMoviesController::class, 'store'])->name('movies.store');
    Route::post('/movies/filter', [AllMoviesController::class, 'filter'])->name('movies.filter');


    Route::get('/movies/populatedMoviesDetailsFromApi', [AllMoviesController::class, 'populatedMoviesDetailsFromApi'])->name('movies.populatedMoviesDetailsFromApi');
});



Route::get('/Register', [UserController::class, 'Register'])->name('user.register');
Route::get('/Login', [UserController::class, 'login'])->name('login');
Route::get('/Alterar_senha', [UserController::class, 'ChangePassword'])->name('user.alterar_senha');
Route::put('/Alterar_senha', [UserController::class, 'Update'])->name('user.update_senha');
Route::post('/Register', [UserController::class, 'Create'])->name('user.create');
Route::post('/Login', [UserController::class, 'Authenticate'])->name('user.login');
Route::post('/logout', [UserController::class, 'Logout'])->name('user.logout');


Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/movies');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/auth/redirect/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback/google', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'password' => Hash::make(Str::random(16)),
        ]
    );

    Auth::login($user);

    return redirect('/movies');
});
