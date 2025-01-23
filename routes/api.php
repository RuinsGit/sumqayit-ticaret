<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;   
use App\Http\Controllers\Api\TranslationManageController;
use App\Http\Controllers\Api\LogoApiController;
use App\Http\Controllers\Api\SeoController;
use App\Http\Controllers\Api\GalleryVideoController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\StoreApiController;
use App\Http\Controllers\Api\StoreTypeApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\StoreHeroApiController;
use App\Http\Controllers\Api\SocialMediaApiController;
use App\Http\Controllers\Api\SocialshareApiController;
use App\Http\Controllers\Api\SocialfooterApiController;
use App\Http\Controllers\Api\HomeAboutApiController;
use App\Http\Controllers\Api\HomeCardController;
use App\Http\Controllers\Api\ContactRentApiController;
use App\Http\Controllers\Api\ContactfooterApiController;
use App\Http\Controllers\Api\ServiceApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Logo Routes
Route::get('/logos', [LogoApiController::class, 'index']);
Route::get('/logos/{id}', [LogoApiController::class, 'show']);
Route::get('/logos/key/{key}', [LogoApiController::class, 'getByKey']);
Route::get('/logos/group/{group}', [LogoApiController::class, 'getByGroup']);

// Translation Routes
Route::get('translations', [TranslationManageController::class, 'index']);
Route::get('translations/{id}', [TranslationManageController::class, 'show']);
Route::get('translations/key/{key}', [TranslationManageController::class, 'getByKey']);
Route::get('translations/group/{group}', [TranslationManageController::class, 'getByGroup']);

// SEO Routes
Route::prefix('seo')->group(function () {
    Route::get('/', [SeoController::class, 'index']);
    Route::get('/{key}', [SeoController::class, 'show']);
    Route::post('/', [SeoController::class, 'store']);
    Route::put('/{id}', [SeoController::class, 'update']);
    Route::delete('/{id}', [SeoController::class, 'destroy']);
});

// Blog Routes
Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index']);
    Route::get('/latest/{limit?}', [BlogController::class, 'getLatest']);
    Route::get('/paginated/{perPage?}', [BlogController::class, 'getPaginated']);
    Route::get('/slug/{lang}/{slug}', [BlogController::class, 'getBySlug']);
    Route::get('/{id}', [BlogController::class, 'show']);
});

// Gallery Video Routes
Route::prefix('gallery-videos')->group(function () {
    Route::get('/', [GalleryVideoController::class, 'index']);
    Route::get('/latest/{limit?}', [GalleryVideoController::class, 'getLatest']);
    Route::get('/paginated/{perPage?}', [GalleryVideoController::class, 'getPaginated']);
    Route::get('/slug/{lang}/{slug}', [GalleryVideoController::class, 'getBySlug']);
    Route::get('/{id}', [GalleryVideoController::class, 'show']);
});

// Gallery Image Routes
Route::prefix('gallery-images')->group(function () {
    Route::get('/', [GalleryController::class, 'index']);
    Route::get('/latest/{limit?}', [GalleryController::class, 'getLatest']);
    Route::get('/paginated/{perPage?}', [GalleryController::class, 'getPaginated']);
    Route::get('/slug/{lang}/{slug}', [GalleryController::class, 'getBySlug']);
    Route::get('/{id}', [GalleryController::class, 'show']);
});

// Store Type Routes
Route::prefix('store-types')->group(function () {
    Route::get('/', [StoreTypeApiController::class, 'index']);
    Route::get('/{id}', [StoreTypeApiController::class, 'show']);
    Route::post('/', [StoreTypeApiController::class, 'store']);
    Route::put('/{id}', [StoreTypeApiController::class, 'update']);
    Route::delete('/{id}', [StoreTypeApiController::class, 'destroy']);
});

// Store Routes
Route::prefix('stores')->group(function () {
    Route::get('/', [StoreApiController::class, 'index']);
    Route::get('/{id}', [StoreApiController::class, 'show']);
    Route::post('/', [StoreApiController::class, 'store']);
    Route::put('/{id}', [StoreApiController::class, 'update']);
    Route::delete('/{id}', [StoreApiController::class, 'destroy']);
});

// Contact Routes
Route::prefix('contact')->group(function () {
    Route::get('/', [ContactApiController::class, 'index']);
    Route::get('/{id}', [ContactApiController::class, 'show']);
    Route::get('/{id}/edit', [ContactApiController::class, 'edit']);
    Route::put('/{id}', [ContactApiController::class, 'update']);
    Route::delete('/{id}', [ContactApiController::class, 'destroy']);
});

// Store Hero Routes
Route::prefix('store-hero')->group(function () {
    Route::get('/', [StoreHeroApiController::class, 'index']);
    Route::get('/{id}', [StoreHeroApiController::class, 'show']);
});

// Social Media Routes
Route::prefix('social-media')->group(function () {
    Route::get('/', [SocialMediaApiController::class, 'index']);
    Route::get('/{id}', [SocialMediaApiController::class, 'show']);
    Route::post('/', [SocialMediaApiController::class, 'store']);
    Route::put('/{id}', [SocialMediaApiController::class, 'update']);
    Route::delete('/{id}', [SocialMediaApiController::class, 'destroy']);
    Route::post('/{id}/toggle-status', [SocialMediaApiController::class, 'toggleStatus']);
});

// Socialshare Routes
Route::prefix('socialshares')->group(function () {
    Route::get('/', [SocialshareApiController::class, 'index']);
    Route::get('/{id}', [SocialshareApiController::class, 'show']);
    Route::post('/', [SocialshareApiController::class, 'store']);
    Route::put('/{id}', [SocialshareApiController::class, 'update']);
    Route::delete('/{id}', [SocialshareApiController::class, 'destroy']);
});

// Social Footer Routes
Route::prefix('social-footer')->group(function () {
    Route::get('/', [SocialfooterApiController::class, 'index']);
    Route::get('/{id}', [SocialfooterApiController::class, 'show']);
    Route::post('/', [SocialfooterApiController::class, 'store']);
    Route::put('/{id}', [SocialfooterApiController::class, 'update']);
    Route::delete('/{id}', [SocialfooterApiController::class, 'destroy']);
});

// Home About Routes
Route::prefix('home-about')->group(function () {
    Route::get('/', [HomeAboutApiController::class, 'index']);
    Route::get('/{id}', [HomeAboutApiController::class, 'show']);
});

// Home Card Routes
Route::prefix('home-cards')->group(function () {
    Route::get('/', [HomeCardController::class, 'index']);
    Route::get('/{id}', [HomeCardController::class, 'show']);
});

// Contact Rent Routes
Route::prefix('contact-rent')->group(function () {
    Route::get('/', [ContactRentApiController::class, 'index']);
    Route::get('/{id}', [ContactRentApiController::class, 'show']);
    Route::post('/', [ContactRentApiController::class, 'store']);
    Route::delete('/{id}', [ContactRentApiController::class, 'destroy']);
});

// Contact Footer Routes
Route::prefix('contact-footer')->group(function () {
    Route::get('/', [ContactfooterApiController::class, 'index']);
    Route::get('/{id}', [ContactfooterApiController::class, 'show']);
    Route::post('/', [ContactfooterApiController::class, 'store']);
    Route::put('/{id}', [ContactfooterApiController::class, 'update']);
    Route::delete('/{id}', [ContactfooterApiController::class, 'destroy']);
});

Route::apiResource('services', ServiceApiController::class);