<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiRecordsController;
use App\Http\Controllers\StatisticsController;

Route::get('/', function () {
    return view('welcome');
});

// API маршрут для получения записей 
Route::get('/api/records', [ApiRecordsController::class, 'index']);

// Маршруты для счётчика посещений 
Route::post('/api/statistics', [StatisticsController::class, 'store']);

Route::middleware(['auth.statistics'])->group(function () {
    Route::get('/statistics', [StatisticsController::class, 'index']);
    Route::get('/statistics/data', [StatisticsController::class, 'getChartData']);
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [StatisticsController::class, 'login']);
Route::get('/logout', [StatisticsController::class, 'logout']);