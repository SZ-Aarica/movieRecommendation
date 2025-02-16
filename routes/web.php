<?php

use App\Http\Controllers\movieController;
use App\Http\Controllers\ProfileController;
use App\Models\favourite;
use App\Models\Movie;
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
Route::get('/add-favorite', function () {
    return view('movies.add-favorite');
});


Route::post('/add-favorite', [movieController::class, 'addFavorite'])->name('add.favorite');
Route::post('/remove-favorite', [movieController::class, 'removeFavorite'])->name('remove.favorite');

//reviews
Route::get('/movies/comments/{movie}', [movieController::class, 'displayAllReviews'])->name('movies.comments');
//show
Route::get('movies.show', [movieController::class, 'show']);

Route::post('/movies/{movie}', [movieController::class, 'addComment'])->name('movies.show');

//dashboard
Route::get('/dashboard', [movieController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
