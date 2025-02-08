<?php

use App\Http\Controllers\movieController;
use App\Http\Controllers\ProfileController;
use App\Models\Movie;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::resource('movies', movieController::class);

Route::get('/', function () {
    return view('welcome');
});
//index

Route::get('/home', [movieController::class, 'index']);

//suggest
Route::get(
    '/taste',
    [movieController::class, 'suggest']
);
//similar
Route::post(
    '/taste',
    [movieController::class, 'similar']
);

//favourite
Route::post('/add-favorite', [movieController::class, 'addFavorite']);
Route::post('/remove-favorite', [movieController::class, 'removeFavorite']);



//show
Route::get('movies.show', [movieController::class, 'show']);

Route::post('/movies/{movie}', [movieController::class, 'addComment'])->name('movies.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
