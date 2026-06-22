<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{project:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin routes - using Filament
// (already registered via filament:install)

// Auth routes (provided by Breeze)
// require __DIR__.'/auth.php';
