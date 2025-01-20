<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\TranslationManageController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\HomeCardController;
use App\Http\Controllers\Admin\HomeAboutController;
use App\Http\Controllers\Admin\ServiceController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('back.pages.index');
        }
        return redirect()->route('admin.login');
    });

    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login')->middleware('guest:admin');
    Route::post('login', [AdminController::class, 'login'])->name('handle-login');

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::get('profile', function () {
            return view('back.admin.profile');
        })->name('admin.profile');

        Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::prefix('pages')->name('back.pages.')->group(function () {
            Route::get('index', [PageController::class, 'index'])->name('index');

            Route::resource('logos', LogoController::class);
            Route::get('logos', [LogoController::class, 'index'])->name('logos.index');
            Route::get('logos/create', [LogoController::class, 'create'])->name('logos.create');
            Route::post('logos', [LogoController::class, 'store'])->name('logos.store');
            Route::get('logos/{id}', [LogoController::class, 'show'])->name('logos.show');
            Route::get('logos/{id}/edit', [LogoController::class, 'edit'])->name('logos.edit');
            Route::put('logos/{id}', [LogoController::class, 'update'])->name('logos.update');
            Route::delete('logos/{id}', [LogoController::class, 'destroy'])->name('logos.destroy');


            Route::resource('translation-manage', TranslationManageController::class);
            Route::get('translation-manage', [TranslationManageController::class, 'index'])->name('translation-manage.index');
            Route::get('translation-manage/create', [TranslationManageController::class, 'create'])->name('translation-manage.create');
            Route::post('translation-manage', [TranslationManageController::class, 'store'])->name('translation-manage.store');
            Route::get('translation-manage/{translation}/edit', [TranslationManageController::class, 'edit'])->name('translation-manage.edit');
            Route::put('translation-manage/{translation}', [TranslationManageController::class, 'update'])->name('translation-manage.update');
            Route::delete('translation-manage/{translation}', [TranslationManageController::class, 'destroy'])->name('translation-manage.destroy');

             // SEO routes
           
            Route::resource('seo', SeoController::class);
                

            Route::get('seo/toggle-status/{id}', [SeoController::class, 'toggleStatus'])->name('seo.toggle-status');
            Route::post('seo/toggle-status/{id}', [SeoController::class, 'toggleStatus'])->name('seo.toggle-status.post');
            Route::get('seo', [SeoController::class, 'index'])->name('seo.index');
            Route::get('seo/create', [SeoController::class, 'create'])->name('seo.create');
            Route::post('seo', [SeoController::class, 'store'])->name('seo.store');
            Route::get('seo/{id}/edit', [SeoController::class, 'edit'])->name('seo.edit');
            Route::put('seo/{id}', [SeoController::class, 'update'])->name('seo.update');
            Route::delete('seo/{id}', [SeoController::class, 'destroy'])->name('seo.destroy');

            Route::resource('home-cards', HomeCardController::class);
            Route::get('home-cards', [HomeCardController::class, 'index'])->name('home-cards.index');
            Route::get('home-cards/create', [HomeCardController::class, 'create'])->name('home-cards.create');
            Route::post('home-cards', [HomeCardController::class, 'store'])->name('home-cards.store');
            Route::get('home-cards/{id}/edit', [HomeCardController::class, 'edit'])->name('home-cards.edit');
            Route::put('home-cards/{id}', [HomeCardController::class, 'update'])->name('home-cards.update');
            Route::delete('home-cards/{id}', [HomeCardController::class, 'destroy'])->name('home-cards.destroy');
            

            Route::resource('home-about', HomeAboutController::class);
            Route::get('home-about', [HomeAboutController::class, 'index'])->name('home-about.index');
            Route::get('home-about/create', [HomeAboutController::class, 'create'])->name('home-about.create');
            Route::post('home-about', [HomeAboutController::class, 'store'])->name('home-about.store');
            Route::get('home-about/{id}/edit', [HomeAboutController::class, 'edit'])->name('home-about.edit');
            Route::put('home-about/{id}', [HomeAboutController::class, 'update'])->name('home-about.update');
            Route::delete('home-about/{id}', [HomeAboutController::class, 'destroy'])->name('home-about.destroy');

            Route::resource('services', ServiceController::class);
            Route::get('services', [ServiceController::class, 'index'])->name('services.index');
            Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
            Route::post('services', [ServiceController::class, 'store'])->name('services.store');
            Route::get('services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
            Route::put('services/{id}', [ServiceController::class, 'update'])->name('services.update');
            Route::delete('services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');

            Route::get('services/toggle-status/{id}', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
            Route::post('services/toggle-status/{id}', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status.post');

        });
    });
});
