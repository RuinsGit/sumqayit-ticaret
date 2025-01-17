<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\TranslationManageController;
use App\Http\Controllers\Admin\SeoController;
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
            

        });
    });
});
