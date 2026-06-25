<?php

use Illuminate\Support\Facades\Route;

// Welcome / API Status
Route::get('/', function () {
    return response()->json([
        'message' => 'Portfolio Builder API is running.',
        'version' => '1.0'
    ]);
});

// Admin routes - using Filament
// (already registered via filament:install)

// Auth routes (provided by Breeze)
// require __DIR__.'/auth.php';
