<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnalysisArticleController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard/pdf', [DashboardController::class, 'exportPdf']);

    Route::get('/countries', [CountryController::class, 'index']);
    Route::get('/countries/{country}', [CountryController::class, 'show']);

    Route::get('/comparison', [ComparisonController::class, 'index']);
    Route::get('/comparison/pdf', [ComparisonController::class, 'exportPdf']);

    Route::get('/ports', [PortController::class, 'index']);

    Route::get('/weather', [WeatherController::class, 'index']);

    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::get('/favorites/add/{country}', [FavoriteController::class, 'store']);
    Route::get('/favorites/delete/{id}', [FavoriteController::class, 'destroy']);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

        Route::get(
    '/analysis-articles',
    [AnalysisArticleController::class, 'index']
);

Route::get(
    '/analysis-articles/create',
    [AnalysisArticleController::class, 'create']
);

Route::post(
    '/analysis-articles/store',
    [AnalysisArticleController::class, 'store']
);

Route::get(
    '/analysis-articles/{id}',
    [AnalysisArticleController::class, 'show']
);

Route::get('/analysis-articles/{id}/edit',
    [AnalysisArticleController::class,'edit']);

Route::put('/analysis-articles/{id}',
    [AnalysisArticleController::class,'update']);

Route::delete('/analysis-articles/{id}',
    [AnalysisArticleController::class,'destroy']);

});

require __DIR__.'/auth.php';