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
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryVideoController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\StoreTypeController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\StoreHeroController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\SocialshareController;
use App\Http\Controllers\Admin\SocialfooterController;
use App\Http\Controllers\Admin\ContactRentController;
use App\Http\Controllers\Admin\ContactfooterController;
use App\Http\Controllers\Admin\MarketController;
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


              // Contact routes
              Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
              Route::get('contact/create', [ContactController::class, 'create'])->name('contact.create');
              Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
              Route::get('contact/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
              Route::put('contact/{id}', [ContactController::class, 'update'])->name('contact.update');
              Route::delete('contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');

            // Gallery routes
            Route::get('galleries', [GalleryController::class, 'index'])->name('galleries.index');
            Route::get('galleries/create', [GalleryController::class, 'create'])->name('galleries.create');
            Route::post('galleries', [GalleryController::class, 'store'])->name('galleries.store');
            Route::get('galleries/{gallery}/edit', [GalleryController::class, 'edit'])->name('galleries.edit');
            Route::put('galleries/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');
            Route::delete('galleries/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

            // Gallery Video routes
            Route::get('gallery-videos', [GalleryVideoController::class, 'index'])->name('gallery-videos.index');
            Route::get('gallery-videos/create', [GalleryVideoController::class, 'create'])->name('gallery-videos.create');
            Route::post('gallery-videos', [GalleryVideoController::class, 'store'])->name('gallery-videos.store');
            Route::get('gallery-videos/{galleryVideo}/edit', [GalleryVideoController::class, 'edit'])->name('gallery-videos.edit');
            Route::put('gallery-videos/{galleryVideo}', [GalleryVideoController::class, 'update'])->name('gallery-videos.update');
            Route::delete('gallery-videos/{galleryVideo}', [GalleryVideoController::class, 'destroy'])->name('gallery-videos.destroy');


             // Blog routes
             Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
             Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
             Route::post('blog', [BlogController::class, 'store'])->name('blog.store');
             Route::get('blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
             Route::put('blog/{id}', [BlogController::class, 'update'])->name('blog.update');
             Route::delete('blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');

            // Store Types
            Route::resource('store-type', StoreTypeController::class);
            
            // Stores
            Route::resource('store', StoreController::class);

            // Store Hero
            Route::resource('store-hero', StoreHeroController::class);

             // Social Media routes
             Route::get('social', [SocialMediaController::class, 'index'])->name('social.index');
             Route::get('social/create', [SocialMediaController::class, 'create'])->name('social.create');
             Route::post('social', [SocialMediaController::class, 'store'])->name('social.store');
             Route::get('social/{id}/edit', [SocialMediaController::class, 'edit'])->name('social.edit');
             Route::put('social/{id}', [SocialMediaController::class, 'update'])->name('social.update');
             Route::delete('social/{id}', [SocialMediaController::class, 'destroy'])->name('social.destroy');
             Route::post('social/order', [SocialMediaController::class, 'order'])->name('social.order');
             Route::post('social/toggle-status/{id}', [SocialMediaController::class, 'toggleStatus'])->name('social.toggle-status');

              // Social Share routes
            Route::get('socialshare', [SocialshareController::class, 'index'])->name('socialshare.index');
            Route::get('socialshare/create', [SocialshareController::class, 'create'])->name('socialshare.create');
            Route::post('socialshare', [SocialshareController::class, 'store'])->name('socialshare.store');
            Route::get('socialshare/{id}/edit', [SocialshareController::class, 'edit'])->name('socialshare.edit');
            Route::put('socialshare/{id}', [SocialshareController::class, 'update'])->name('socialshare.update');
            Route::delete('socialshare/{id}', [SocialshareController::class, 'destroy'])->name('socialshare.destroy');

              // Social Footer routes
              Route::get('socialfooter', [SocialfooterController::class, 'index'])->name('socialfooter.index');
              Route::get('socialfooter/create', [SocialfooterController::class, 'create'])->name('socialfooter.create');
              Route::post('socialfooter', [SocialfooterController::class, 'store'])->name('socialfooter.store');
              Route::get('socialfooter/{id}/edit', [SocialfooterController::class, 'edit'])->name('socialfooter.edit');
              Route::put('socialfooter/{id}', [SocialfooterController::class, 'update'])->name('socialfooter.update');
              Route::delete('socialfooter/{id}', [SocialfooterController::class, 'destroy'])->name('socialfooter.destroy');
              Route::post('socialfooter/order', [SocialfooterController::class, 'order'])->name('socialfooter.order');
              Route::post('socialfooter/toggle-status/{id}', [SocialfooterController::class, 'toggleStatus'])->name('socialfooter.toggle-status');

              // Contact Rent routes
              Route::resource('contact-rent', ContactRentController::class);

                // Contact Footer routes
            Route::get('contactfooter', [ContactfooterController::class, 'index'])->name('contactfooter.index');
            Route::get('contactfooter/create', [ContactfooterController::class, 'create'])->name('contactfooter.create');
            Route::post('contactfooter', [ContactfooterController::class, 'store'])->name('contactfooter.store');
            Route::get('contactfooter/{id}/edit', [ContactfooterController::class, 'edit'])->name('contactfooter.edit');
            Route::put('contactfooter/{id}', [ContactfooterController::class, 'update'])->name('contactfooter.update');
            Route::delete('contactfooter/{id}', [ContactfooterController::class, 'destroy'])->name('contactfooter.destroy');

            // Market Routes
            Route::group(['prefix' => 'market', 'as' => 'market.'], function () {
            Route::get('/', [MarketController::class, 'index'])->name('index');
            Route::get('/create', [MarketController::class, 'create'])->name('create');
            Route::post('/', [MarketController::class, 'store'])->name('store');
            Route::get('/{market}/edit', [MarketController::class, 'edit'])->name('edit');
            Route::put('/{market}', [MarketController::class, 'update'])->name('update');
            Route::delete('/{market}', [MarketController::class, 'destroy'])->name('destroy');
            });


        });
    });
});

