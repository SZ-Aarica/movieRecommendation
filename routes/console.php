<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

return function (Illuminate\Console\Scheduling\Schedule $schedule) {
    // Schedule the FetchPopularMovies command to run daily
    $schedule->command('app:fetch-popular-movies')->daily();
};
