<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Public portfolio view
Route::get('/portfolios/{slug}', [PortfolioController::class, 'show']);

// Contact form submission (public)
Route::post('/portfolios/{slug}/contact', [ContactController::class, 'submit']);

// Visitor tracking (public)
Route::post('/portfolios/{slug}/visit', [AnalyticsController::class, 'trackVisit']);

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/password', [AuthController::class, 'changePassword']);
    });
});

/*
|--------------------------------------------------------------------------
| Protected Routes (requires JWT authentication)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->prefix('my')->group(function () {
    // Portfolio management
    Route::get('/portfolio', [PortfolioController::class, 'myPortfolio']);
    Route::put('/portfolio', [PortfolioController::class, 'update']);
    Route::patch('/portfolio/theme', [PortfolioController::class, 'updateTheme']);
    Route::patch('/portfolio/sections', [PortfolioController::class, 'updateSections']);
    Route::post('/portfolio/maintenance', [PortfolioController::class, 'toggleMaintenance']);
    Route::put('/portfolio/seo', [PortfolioController::class, 'updateSEO']);

    // Hero section
    Route::get('/portfolio/hero', [ContentController::class, 'getHero']);
    Route::put('/portfolio/hero', [ContentController::class, 'updateHero']);

    // Social links
    Route::post('/portfolio/social-links', [ContentController::class, 'addSocialLink']);
    Route::delete('/portfolio/social-links/{id}', [ContentController::class, 'deleteSocialLink']);

    // About section
    Route::get('/portfolio/about', [ContentController::class, 'getAbout']);
    Route::put('/portfolio/about', [ContentController::class, 'updateAbout']);

    // Skills
    Route::get('/portfolio/skills', [ContentController::class, 'getSkills']);
    Route::post('/portfolio/skills', [ContentController::class, 'addSkill']);
    Route::put('/portfolio/skills/{id}', [ContentController::class, 'updateSkill']);
    Route::delete('/portfolio/skills/{id}', [ContentController::class, 'deleteSkill']);

    // Experience
    Route::get('/portfolio/experience', [ContentController::class, 'getExperience']);
    Route::post('/portfolio/experience', [ContentController::class, 'addExperience']);
    Route::put('/portfolio/experience/{id}', [ContentController::class, 'updateExperience']);
    Route::delete('/portfolio/experience/{id}', [ContentController::class, 'deleteExperience']);

    // Projects
    Route::get('/portfolio/projects', [ContentController::class, 'getProjects']);
    Route::post('/portfolio/projects', [ContentController::class, 'addProject']);
    Route::put('/portfolio/projects/{id}', [ContentController::class, 'updateProject']);
    Route::delete('/portfolio/projects/{id}', [ContentController::class, 'deleteProject']);

    // Education
    Route::get('/portfolio/education', [ContentController::class, 'getEducation']);
    Route::post('/portfolio/education', [ContentController::class, 'addEducation']);
    Route::put('/portfolio/education/{id}', [ContentController::class, 'updateEducation']);
    Route::delete('/portfolio/education/{id}', [ContentController::class, 'deleteEducation']);

    // Testimonials
    Route::get('/portfolio/testimonials', [ContentController::class, 'getTestimonials']);
    Route::post('/portfolio/testimonials', [ContentController::class, 'addTestimonial']);
    Route::put('/portfolio/testimonials/{id}', [ContentController::class, 'updateTestimonial']);
    Route::delete('/portfolio/testimonials/{id}', [ContentController::class, 'deleteTestimonial']);

    // Analytics
    Route::get('/portfolio/analytics', [AnalyticsController::class, 'getStats']);
    Route::get('/portfolio/analytics-config', [AnalyticsController::class, 'getAnalyticsConfig']);
    Route::put('/portfolio/analytics-config', [AnalyticsController::class, 'updateAnalyticsConfig']);

    // Contact messages
    Route::get('/portfolio/messages', [ContactController::class, 'getMessages']);
    Route::post('/portfolio/messages/{id}/read', [ContactController::class, 'markAsRead']);
    Route::delete('/portfolio/messages/{id}', [ContactController::class, 'deleteMessage']);
});
