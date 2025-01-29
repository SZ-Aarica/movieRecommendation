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
    //https://api.themoviedb.org/3/search/movie?query=blue%20valentine&language=en-US&page=1&api_key=7429882064bd146f8c3147d6ec343807
});

//suggest
Route::get(
    '/taste',
    [movieController::class, 'suggest']
);

Route::post(
    '/taste',
    function () {
        $validatedAtr = request()->validate([
            'movie' => ['required', 'min:3'],
        ]);
        $apiKey = '1038147-moviesug-6E204011';
        $client = new Client();
        $Url = "https://tastedive.com/api/similar?q={$validatedAtr['movie']}&type=movie&k=$apiKey";

        $response = $client->get($Url);
        $data = json_decode($response->getBody(), true);
        //dd($data['similar']['results']);
        return view('movies.taste', ['datas' => $data['similar']['results']]);
    }
);



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
