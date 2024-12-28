<?php

use App\Http\Controllers\movieController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::resource('movies', movieController::class);

Route::get('/', function () {
    return view('welcome');
});
//index

Route::get('/home', [movieController::class, 'index']);
//search
Route::post('/home', function () {
    $validatedAtr = request()->validate([
        'movie' => ['required', 'min:3'],

    ]);
    $apiKey = '1038147-moviesug-6E204011';
    $client = new Client();
    $Url = "https://tastedive.com/api/similar?q={$validatedAtr['movie']}&type=movie&k=$apiKey";

    $response = $client->get($Url);
    $data = json_decode($response->getBody(), true);

    //(image)https://image.tmdb.org/t/p/w400/{bVsx4QXHlf5ppMc5Ezvlu8H9gp8.jpg}

    dd($data['similar']['results']);
    // $results = $data['similar']['results'];
    //1038147-moviesug-6E204011
    //https://tastedive.com/api/similar?q={$moviename}&type=movie&k={$api key}
});
Route::get('movies.show', [movieController::class, 'show']);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
