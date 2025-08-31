<?php

use App\Http\Controllers\DashboardMovieController;
use App\Http\Controllers\MyListMoviesController;
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
    Route::controller(DashboardMovieController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('movies.dashboard');

    });

    #Todos filmes
    Route::controller(AllMoviesController::class)->group(function () {
        Route::get('/movies', 'index')->name('movies.index');
        Route::post('/movies/filter', 'filter')->name('movies.filter');
    });

    #Filmes na lista
    Route::controller(MyListMoviesController::class)->group(function () {
        Route::get('/movies/my-favorite-movies',  'index')->name('movies.my-list-movies');
        Route::post('/save-favorite-movie', 'saveFavoriteMovie')
            ->middleware('auth')
            ->name('save-favorite-movie');
    });
});


    #Criação de usuário / Login
    Route::controller(UserController::class)->group(function () {
        Route::get('/Register',  'Register')->name('user.register');
        Route::get('/Login',  'login')->name('login');
        Route::get('/Alterar_senha',  'ChangePassword')->name('user.alterar_senha');
        Route::put('/Alterar_senha',  'Update')->name('user.update_senha');
        Route::post('/Register',  'Create')->name('user.create');
        Route::post('/Login',  'Authenticate')->name('user.login');
        Route::post('/logout',  'Logout')->name('user.logout');
    });



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
