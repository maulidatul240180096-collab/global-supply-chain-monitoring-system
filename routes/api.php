<?php

use Illuminate\Support\Facades\Route;

Route::get('/countries', function () {
    return response()->json([
        'message' => 'Countries API'
    ]);
});

Route::get('/risk', function () {
    return response()->json([
        'message' => 'Risk API'
    ]);
});

Route::get('/ports', function () {
    return response()->json([
        'message' => 'Ports API'
    ]);
});

Route::get('/news', function () {
    return response()->json([
        'message' => 'News API'
    ]);
});

Route::get('/currency', function () {
    return response()->json([
        'message' => 'Currency API'
    ]);
});