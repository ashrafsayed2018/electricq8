<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\PillarController;
use App\Http\Controllers\ServiceLocationController;
use Illuminate\Support\Facades\Route;

Route::middleware('locale')->group(function () {

    // Arabic — no prefix (default)
    Route::get('/',                       [HomeController::class, 'index'])->name('home');
    Route::get('/services',                              [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service}/{location}',         [ServiceLocationController::class, 'show'])->name('service-locations.show');
    Route::get('/services/{service}',                    [ServiceController::class, 'show'])->name('services.show');
    Route::get('/areas',                                 [AreaController::class, 'index'])->name('areas.index');
    Route::get('/areas/{location}',       [AreaController::class, 'show'])->name('areas.show');
    Route::get('/about',                  [AboutController::class, 'index'])->name('about');
    Route::get('/gallery',                [GalleryController::class, 'index'])->name('gallery');
    Route::get('/contact',                [ContactController::class, 'index'])->name('contact');
    Route::get('/privacy',                [PageController::class, 'privacy'])->name('privacy');
    Route::get('/blog',                   [PostController::class, 'index'])->name('posts.index');
    Route::get('/blog/{post}',            [PostController::class, 'show'])->name('posts.show');
    Route::get('/clusters/{cluster}',     [ClusterController::class, 'show'])->name('clusters.show');
    Route::get('/pillars/{pillar}',       [PillarController::class,  'show'])->name('pillars.show');

    // English — /en/ prefix
    Route::prefix('en')->name('en.')->group(function () {
        Route::get('/',                       [HomeController::class, 'index'])->name('home');
        Route::get('/services',                              [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/{service}/{location}',         [ServiceLocationController::class, 'show'])->name('service-locations.show');
        Route::get('/services/{service}',                    [ServiceController::class, 'show'])->name('services.show');
        Route::get('/areas',                                 [AreaController::class, 'index'])->name('areas.index');
        Route::get('/areas/{location}',       [AreaController::class, 'show'])->name('areas.show');
        Route::get('/about',                  [AboutController::class, 'index'])->name('about');
        Route::get('/gallery',                [GalleryController::class, 'index'])->name('gallery');
        Route::get('/contact',                [ContactController::class, 'index'])->name('contact');
        Route::get('/blog',                   [PostController::class, 'index'])->name('posts.index');
        Route::get('/blog/{post}',            [PostController::class, 'show'])->name('posts.show');
        Route::get('/clusters/{cluster}',     [ClusterController::class, 'show'])->name('clusters.show');
        Route::get('/pillars/{pillar}',       [PillarController::class,  'show'])->name('pillars.show');
    });
});

// Sitemap — public, no middleware
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Locale switcher — sets session and redirects to the correct-prefix equivalent URL
Route::get('/locale/{locale}', function (string $locale) {
    if (! in_array($locale, config('app.available_locales', ['ar', 'en']))) {
        return redirect()->back();
    }

    session(['locale' => $locale]);

    $referer = request()->header('Referer', '/');
    $path    = parse_url($referer, PHP_URL_PATH) ?? '/';
    $query   = parse_url($referer, PHP_URL_QUERY);

    // Admin pages: never add /en/ prefix — just reload the same URL
    if (str_starts_with($path, '/admin') || str_contains($path, '/admin/')) {
        return redirect()->back();
    }

    // Strip existing /en prefix
    $stripped = preg_replace('#^/en(/|$)#', '/', $path);
    $stripped = preg_replace('#/{2,}#', '/', $stripped) ?: '/';

    if ($locale === 'en') {
        $target = rtrim('/en' . $stripped, '/') ?: '/en';
    } else {
        $target = $stripped;
    }
    if ($query) $target .= '?' . $query;

    return redirect($target);
})->name('locale.switch')->middleware('web');

// Auth
Route::middleware(['locale', 'guest'])->group(function () {
    Route::get('/login',     [LoginController::class,    'showLoginForm'])->name('login');
    Route::post('/login',    [LoginController::class,    'login']);
    Route::get('/register',  [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware(['locale', 'auth']);

// Admin — any authenticated user with any assigned role may enter; individual routes restrict further
Route::prefix('admin')->middleware(['locale', 'auth', 'role:admin|writer'])->group(function () {
    Route::get('/',              \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/analytics',     \App\Livewire\Admin\Analytics\Index::class)->name('admin.analytics');

    // Posts — admin always allowed; writers need the specific permission
    Route::get('/posts',                        \App\Livewire\Admin\Posts\Index::class)->name('admin.posts.index')->middleware('role_or_permission:admin|posts.index');
    Route::get('/posts/create',                 \App\Livewire\Admin\Posts\Form::class)->name('admin.posts.create')->middleware('role_or_permission:admin|posts.create');
    Route::get('/posts/{post:id}/edit',         \App\Livewire\Admin\Posts\Form::class)->name('admin.posts.edit')->middleware('role_or_permission:admin|posts.edit');

    // Admin-only sections
    Route::middleware('role:admin')->group(function () {
        Route::get('/contacts/{locale?}',            \App\Livewire\Admin\Contacts\Index::class)->name('admin.contacts.index');
        Route::get('/pillars',                       \App\Livewire\Admin\Pillars\Index::class)->name('admin.pillars.index');
        Route::get('/pillars/create',                \App\Livewire\Admin\Pillars\Form::class)->name('admin.pillars.create');
        Route::get('/pillars/{pillar:id}/edit',      \App\Livewire\Admin\Pillars\Form::class)->name('admin.pillars.edit');
        Route::get('/clusters',                      \App\Livewire\Admin\Clusters\Index::class)->name('admin.clusters.index');
        Route::get('/clusters/create',               \App\Livewire\Admin\Clusters\Form::class)->name('admin.clusters.create');
        Route::get('/clusters/{cluster:id}/edit',    \App\Livewire\Admin\Clusters\Form::class)->name('admin.clusters.edit');
        Route::get('/services',                      \App\Livewire\Admin\Services\Index::class)->name('admin.services.index');
        Route::get('/services/create',               \App\Livewire\Admin\Services\Form::class)->name('admin.services.create');
        Route::get('/services/{service:id}/edit',    \App\Livewire\Admin\Services\Form::class)->name('admin.services.edit');
        Route::get('/areas',                         \App\Livewire\Admin\Areas\Index::class)->name('admin.areas.index');
        Route::get('/areas/create',                  \App\Livewire\Admin\Areas\Form::class)->name('admin.areas.create');
        Route::get('/areas/{location:id}/edit',      \App\Livewire\Admin\Areas\Form::class)->name('admin.areas.edit');
        Route::get('/service-locations',                                        \App\Livewire\Admin\ServiceLocations\Index::class)->name('admin.service-locations.index');
        Route::get('/service-locations/create',                                 \App\Livewire\Admin\ServiceLocations\Form::class)->name('admin.service-locations.create');
        Route::get('/service-locations/{serviceLocationPage:id}/edit',          \App\Livewire\Admin\ServiceLocations\Form::class)->name('admin.service-locations.edit');
        Route::get('/testimonials',                  \App\Livewire\Admin\Testimonials\Index::class)->name('admin.testimonials.index');
        Route::get('/gallery',                       \App\Livewire\Admin\Gallery\Index::class)->name('admin.gallery.index');
        Route::get('/users',                         \App\Livewire\Admin\Users\Index::class)->name('admin.users.index');
        Route::get('/users/create',                  \App\Livewire\Admin\Users\Form::class)->name('admin.users.create');
        Route::get('/users/{user:id}/edit',          \App\Livewire\Admin\Users\Form::class)->name('admin.users.edit');
        Route::get('/roles',                         \App\Livewire\Admin\Roles\Index::class)->name('admin.roles.index');
        Route::get('/roles/create',                  \App\Livewire\Admin\Roles\Form::class)->name('admin.roles.create');
        Route::get('/roles/{role:id}/edit',          \App\Livewire\Admin\Roles\Form::class)->name('admin.roles.edit');
        Route::get('/permissions',                   \App\Livewire\Admin\Permissions\Index::class)->name('admin.permissions.index');
        Route::get('/permissions/create',            \App\Livewire\Admin\Permissions\Form::class)->name('admin.permissions.create');
        Route::get('/permissions/{permission:id}/edit', \App\Livewire\Admin\Permissions\Form::class)->name('admin.permissions.edit');
        Route::get('/settings',                      \App\Livewire\Admin\Settings\Index::class)->name('admin.settings');
    });
});
