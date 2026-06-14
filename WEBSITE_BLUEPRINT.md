# Website Blueprint — Local Service Business (Laravel + Livewire)

This document is a complete specification for replicating the CoolQ8 website architecture for **any local service business** (pest control, plumbing, construction materials, cleaning, etc.).

Hand this file to your AI IDE and say:
> "Build me a Laravel 13 local-service website following this blueprint. The business is [YOUR BUSINESS NAME]. Replace every AC/cooling reference with [YOUR SERVICE]."

---

## 1. Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13 |
| Reactive UI | Livewire 4 (admin panels, forms) |
| Frontend JS | Alpine.js 3 (dropdowns, accordions, tabs) |
| CSS | Tailwind CSS v4 |
| Translations | `spatie/laravel-translatable` |
| Roles & Permissions | `spatie/laravel-permission` |
| Images | `intervention/image` (WebP conversion) |
| Database | MySQL 8 |
| PHP | 8.3+ |

Install command:
```bash
composer require spatie/laravel-translatable spatie/laravel-permission intervention/image
npm install -D tailwindcss @tailwindcss/vite @tailwindcss/typography alpinejs
```

---

## 2. Business Customization Variables

Before you start, define these. Search-replace them everywhere.

| Variable | CoolQ8 example | Your value |
|---|---|---|
| `BUSINESS_NAME` | CoolQ8 / كول كويت | e.g. PestFree Kuwait |
| `BUSINESS_SLUG` | coolq8 | pestfree |
| `SERVICE_NOUN_AR` | تكييف | مكافحة حشرات |
| `SERVICE_NOUN_EN` | AC | Pest Control |
| `COUNTRY` | Kuwait / الكويت | Kuwait / Saudi / UAE |
| `CURRENCY` | KWD | KWD / SAR / AED |
| `PRIMARY_COLOR` | blue-700 | green-700 (adjust in Tailwind) |
| `WHATSAPP_NUMBER` | 96512345678 | your number with country code |

---

## 3. Bilingual Architecture

The site serves two languages from one codebase.

### URL structure
```
Arabic (default)  →  /          /services     /areas      /blog
English           →  /en        /en/services  /en/areas   /en/blog
```

### Middleware — `app/Http/Middleware/SetLocale.php`
```php
public function handle(Request $request, Closure $next): Response
{
    $segment = $request->segment(1);
    if (in_array($segment, config('app.available_locales'))) {
        app()->setLocale($segment);
        session(['locale' => $segment]);
    } else {
        app()->setLocale(session('locale', 'ar')); // ar is default
    }
    return $next($request);
}
```

Register in `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias(['locale' => SetLocale::class]);
})
```

### `config/app.php` additions
```php
'available_locales' => ['ar', 'en'],
'locale'            => 'ar',
'fallback_locale'   => 'ar',
```

### Database columns — all translatable fields use JSON type
```sql
-- Example: title column stores {"ar":"عنوان عربي","en":"English Title"}
title JSON NOT NULL
slug  JSON NOT NULL
```

### Spatie Translatable pattern (every translatable Model)
```php
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    public array $translatable = ['title', 'slug', 'h1', 'intro', 'content',
                                   'meta_title', 'meta_description', 'faq_schema'];
}
```

Access in Blade:
```blade
{{ $service->getTranslation('title', app()->getLocale()) }}
{{-- or shorthand after setting locale: --}}
{{ $service->title }}
```

### Route binding with bilingual slugs
Every model that has a slug resolves it across both locales:
```php
public function resolveRouteBinding($value, $field = null): ?static
{
    foreach (config('app.available_locales') as $locale) {
        $model = static::whereJsonContains("slug->{$locale}", $value)->first();
        if ($model) return $model;
    }
    abort(404);
}
```

---

## 4. Database Schema

### 4.1 `services` table
```php
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cluster_id')->nullable()->constrained()->nullOnDelete();
    $table->json('title');
    $table->json('slug');
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('h1');
    $table->json('intro')->nullable();
    $table->json('content')->nullable();       // rich HTML per locale
    $table->json('canonical_url')->nullable();
    $table->json('faq_schema')->nullable();    // FAQ JSON-LD per locale
    $table->string('service_type')->default('general'); // customize per business
    $table->unsignedInteger('price_from')->nullable();
    $table->unsignedInteger('price_to')->nullable();
    $table->string('image_url')->nullable();
    $table->string('status')->default('active');
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

**Adapt `service_type` enum values to your business:**
- Pest control: `cockroach | rodent | termite | bed_bug | general`
- Plumbing: `leak_repair | drain | installation | emergency | general`
- Construction: `supply | delivery | wholesale | retail | general`

### 4.2 `locations` table
```php
Schema::create('locations', function (Blueprint $table) {
    $table->id();
    $table->json('name');           // {"ar":"السالمية","en":"Salmiya"}
    $table->json('slug');
    $table->string('governorate');  // group areas by region/district
    $table->json('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

### 4.3 `posts` table (Blog)
```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->json('title');
    $table->json('slug');
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('h1');
    $table->json('excerpt')->nullable();
    $table->json('content')->nullable();       // rich HTML
    $table->json('canonical_url')->nullable();
    $table->string('featured_image')->nullable();
    $table->string('status')->default('draft'); // draft | published
    $table->timestamp('published_at')->nullable();
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

### 4.4 `testimonials` table
```php
Schema::create('testimonials', function (Blueprint $table) {
    $table->id();
    $table->json('client_name');
    $table->json('body');
    $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
    $table->unsignedTinyInteger('rating')->default(5); // 1-5
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 4.5 `contacts` table
```php
Schema::create('contacts', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('phone');
    $table->string('email')->nullable();
    $table->text('message')->nullable();
    $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
    $table->string('status')->default('new'); // new | read | done
    $table->string('locale')->default('ar');
    $table->timestamps();
});
```

### 4.6 `site_settings` table
```php
Schema::create('site_settings', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();
    $table->text('value')->nullable();
    $table->string('group')->default('general');
    $table->timestamps();
});
```

**Required settings keys:**
```
site_name_ar, site_name_en
phone_number, whatsapp_number, email
instagram_url, snapchat_url, tiktok_url
address_ar, address_en
logo_url          ← managed via admin Settings → Brand Images
favicon_url       ← managed via admin Settings → Brand Images
hero_image_url    ← managed via admin Settings → Brand Images (also used as OG image)
```

### 4.7 `pillars` table (top-level content hierarchy)
```php
Schema::create('pillars', function (Blueprint $table) {
    $table->id();
    $table->json('title');
    $table->json('slug');
    $table->json('h1');
    $table->json('intro')->nullable();
    $table->json('content')->nullable();
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('canonical_url')->nullable();
    $table->string('status')->default('active');
    $table->unsignedInteger('sort_order')->default(0);
    $table->string('image_url')->nullable();            // added via migration after initial creation
    $table->timestamps();
});
```

> **Note:** If the table already exists without `image_url`, add it via a separate migration:
> ```php
> $table->string('image_url')->nullable()->after('sort_order');
> ```

### 4.8 `clusters` table (service categories, child of pillars)
```php
Schema::create('clusters', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pillar_id')->constrained()->cascadeOnDelete();
    $table->json('title');
    $table->json('slug');
    $table->json('h1');
    $table->json('intro')->nullable();
    $table->json('content')->nullable();
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('canonical_url')->nullable();
    $table->string('search_intent')->default('commercial'); // informational|commercial|transactional
    $table->string('status')->default('active');            // active|draft|archived
    $table->string('image_url')->nullable();
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

**Hierarchy:** `pillars` → `clusters` → `services`. A pillar is a top-level topic (e.g. "AC Repair"), a cluster is a sub-topic (e.g. "Split AC Repair"), services belong to a cluster. This lets you build a silo content structure for SEO.

### 4.9 `service_location_pages` table (Local SEO — the most important table)
```php
Schema::create('service_location_pages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('service_id')->constrained()->cascadeOnDelete();
    $table->foreignId('location_id')->constrained()->cascadeOnDelete();
    $table->unique(['service_id', 'location_id']);          // one page per pair

    // Translatable content fields
    $table->json('title');
    $table->json('slug');
    $table->json('h1');
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('canonical_url')->nullable();
    $table->json('intro')->nullable();
    $table->json('unique_local_content')->nullable();       // HTML, unique per page
    $table->json('local_problem')->nullable();              // unique pain point per area
    $table->json('local_solution')->nullable();             // unique solution per area
    $table->json('cta_text')->nullable();

    $table->boolean('noindex')->default(true);              // true until real content added
    $table->string('status')->default('active');
    $table->timestamps();
});
```

**Why `noindex` defaults to `true`:** Pages are auto-generated with templated content. Mark `noindex = false` only after adding genuinely unique content per page — otherwise Google may penalise thin content.

### 4.10 `media` table (image library)
```php
Schema::create('media', function (Blueprint $table) {
    $table->id();
    $table->string('filename');         // e.g. abc123.webp
    $table->string('original_name');
    $table->string('path');             // storage/media/abc123.webp
    $table->string('url');              // public URL
    $table->unsignedBigInteger('size');
    $table->string('mime_type');
    $table->timestamps();
});
```

---

## 5. Models

### Service Model (`app/Models/Service.php`)
```php
class Service extends Model
{
    use HasTranslations;

    public array $translatable = ['title','slug','h1','intro','content',
                                   'meta_title','meta_description','faq_schema'];

    // Scope used by all controllers
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('sort_order');
    }

    // Returns emoji/icon based on service_type — customize per business
    public function icon(): string
    {
        return match($this->service_type) {
            'emergency' => '⚡',
            'install'   => '🔧',
            'repair'    => '🛠️',
            'clean'     => '💧',
            default     => '⭐',
        };
    }

    // Relationships
    public function cluster()              { return $this->belongsTo(Cluster::class); }
    public function serviceLocationPages() { return $this->hasMany(ServiceLocationPage::class); }
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'service_location_pages')
                    ->withPivot('id', 'status');
    }

    // Bilingual slug route binding (see section 3)
    public function resolveRouteBinding($value, $field = null): ?static
    {
        foreach (config('app.available_locales') as $locale) {
            $model = static::whereJsonContains("slug->{$locale}", $value)->first();
            if ($model) return $model;
        }
        abort(404);
    }
}
```

### Location Model (`app/Models/Location.php`)
```php
class Location extends Model
{
    use HasTranslations;
    public array $translatable = ['name', 'slug', 'description'];

    public function testimonials()       { return $this->hasMany(Testimonial::class); }
    public function contacts()           { return $this->hasMany(Contact::class); }
    public function serviceLocationPages() { return $this->hasMany(ServiceLocationPage::class); }
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_location_pages')
                    ->withPivot('id', 'status');
    }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        foreach (config('app.available_locales') as $locale) {
            $model = static::whereJsonContains("slug->{$locale}", $value)->first();
            if ($model) return $model;
        }
        abort(404);
    }
}
```

### Pillar Model (`app/Models/Pillar.php`)
```php
class Pillar extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title', 'slug', 'h1', 'intro', 'content',
        'meta_title', 'meta_description', 'canonical_url',
    ];

    protected $fillable = [
        'title', 'slug', 'h1', 'intro', 'content',
        'meta_title', 'meta_description', 'canonical_url',
        'status', 'sort_order', 'image_url',
    ];

    public function clusters() { return $this->hasMany(Cluster::class); }
}
```

### Cluster Model (`app/Models/Cluster.php`)
```php
class Cluster extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title', 'slug', 'h1', 'intro', 'content',
        'meta_title', 'meta_description', 'canonical_url',
    ];

    protected $fillable = [
        'pillar_id',
        'title', 'slug', 'h1', 'intro', 'content',
        'meta_title', 'meta_description', 'canonical_url',
        'search_intent', 'status', 'sort_order', 'image_url',
    ];

    public function pillar()   { return $this->belongsTo(Pillar::class); }
    public function services() { return $this->hasMany(Service::class); }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        foreach (config('app.available_locales') as $locale) {
            $model = static::whereJsonContains("slug->{$locale}", $value)->first();
            if ($model) return $model;
        }
        abort(404);
    }
}
```

### ServiceLocationPage Model (`app/Models/ServiceLocationPage.php`)
```php
class ServiceLocationPage extends Model
{
    use HasTranslations;

    public array $translatable = [
        'title', 'slug', 'h1',
        'meta_title', 'meta_description', 'canonical_url',
        'intro', 'unique_local_content', 'local_problem', 'local_solution', 'cta_text',
    ];

    protected function casts(): array { return ['noindex' => 'boolean']; }

    public function service()  { return $this->belongsTo(Service::class); }
    public function location() { return $this->belongsTo(Location::class); }

    public function scopeActive($query) { return $query->where('status', 'active'); }

    /**
     * Generate default bilingual content for a service × location combination.
     * Used by the admin "Generate All" button and the controller for virtual pages.
     */
    public static function autoFill(Service $service, Location $location, string $locale): array
    {
        $sName = $service->getTranslation('title', $locale);
        $lName = $location->getTranslation('name', $locale);

        if ($locale === 'ar') {
            return [
                'title'          => "{$sName} في {$lName}",
                'h1'             => "فني {$sName} في {$lName}",
                'meta_title'     => "{$sName} في {$lName} | BUSINESS_NAME_AR",
                'meta_description' => "خدمة {$sName} في {$lName} — فنيون معتمدون، استجابة سريعة، ضمان 3 أشهر. اتصل الآن.",
                'intro'          => "تقدم BUSINESS_NAME_AR خدمة {$sName} في {$lName} بأعلى معايير الجودة.",
                'local_problem'  => "تعاني {$lName} من ظروف قد تؤثر على أجهزة الخدمة.",
                'local_solution' => "فريقنا في {$lName} يقدم حلاً شاملاً بسعر واضح.",
                'cta_text'       => "احجز فنيًا في {$lName} الآن",
            ];
        }

        return [
            'title'          => "{$sName} in {$lName}",
            'h1'             => "{$sName} Technician in {$lName}",
            'meta_title'     => "{$sName} in {$lName} | BUSINESS_NAME_EN",
            'meta_description' => "Professional {$sName} in {$lName} — certified technicians, fast response, warranty. Call now.",
            'intro'          => "BUSINESS_NAME_EN provides {$sName} in {$lName} to the highest quality standards.",
            'local_problem'  => "{$lName} conditions can accelerate wear on service equipment.",
            'local_solution' => "Our team in {$lName} delivers a complete solution at a clear, guaranteed price.",
            'cta_text'       => "Book a Technician in {$lName} Now",
        ];
    }
}
```

### Post Model (`app/Models/Post.php`)
```php
class Post extends Model
{
    use HasTranslations;
    public array $translatable = ['title','slug','h1','excerpt','content',
                                   'meta_title','meta_description'];
    protected $casts = ['published_at' => 'datetime'];

    public function scopePublished($query)
    {
        return $query->where('status','published')
                     ->whereNotNull('published_at')
                     ->orderByDesc('published_at');
    }
}
```

### SiteSetting Model (`app/Models/SiteSetting.php`)
```php
class SiteSetting extends Model
{
    public static function get(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
```

Usage in any Blade template:
```blade
{{ \App\Models\SiteSetting::get('phone_number') }}
{{ \App\Models\SiteSetting::get('site_name_' . app()->getLocale()) }}
```

---

## 6. Controllers

### HomeController
```php
public function index()
{
    return view('home', [
        'services'     => Service::active()->get(),
        'locations'    => Location::where('is_active', true)->orderBy('sort_order')->get(),
        'testimonials' => Testimonial::active()->limit(6)->get(),
    ]);
}
```

### ServiceController
```php
public function index()
{
    return view('services.index', ['services' => Service::active()->get()]);
}

public function show(Service $service)
{
    // 301 redirect if slug in wrong locale
    $correctSlug   = $service->getTranslation('slug', app()->getLocale());
    $requestedSlug = last(request()->segments());
    if ($requestedSlug !== $correctSlug) {
        return redirect()->route('services.show', $correctSlug, 301);
    }

    return view('services.show', [
        'service'       => $service,
        'otherServices' => Service::active()->where('id', '!=', $service->id)->get(),
        'locations'     => Location::where('is_active', true)->orderBy('sort_order')->get(),
    ]);
}
```

### AreaController
```php
public function show(Location $location)
{
    // related areas in same governorate for internal linking
    $relatedLocations = Location::where('is_active', true)
        ->where('governorate', $location->governorate)
        ->where('id', '!=', $location->id)
        ->orderBy('sort_order')->limit(6)->get();

    return view('areas.show', [
        'location'         => $location,
        'services'         => Service::active()->get(),
        'testimonials'     => $location->testimonials()->where('is_active', true)->limit(3)->get(),
        'relatedLocations' => $relatedLocations,
    ]);
}
```

### ClusterController
```php
public function show(Cluster $cluster)
{
    $locale      = app()->getLocale();
    $correctSlug = $cluster->getTranslation('slug', $locale);
    $requested   = last(request()->segments());

    if ($requested !== $correctSlug) {
        $route = $locale === 'ar' ? 'clusters.show' : 'en.clusters.show';
        return redirect()->route($route, $correctSlug, 301);
    }

    return view('clusters.show', [
        'cluster' => $cluster->load('pillar', 'services'),
    ]);
}
```

`clusters/show.blade.php` sections:
- Breadcrumb → Home / Services / Cluster title
- Hero: image thumbnail (if set), H1, intro
- `{!! $content !!}` rich HTML body (from TinyMCE)
- Services grid: all services belonging to this cluster, each links to its `services.show` page
- WhatsApp / Call CTA strip

### PostController
```php
public function index()
{
    return view('posts.index', [
        'posts' => Post::published()->paginate(12),
    ]);
}

public function show(Post $post)
{
    return view('posts.show', ['post' => $post]);
}
```

---

## 7. Routes (`routes/web.php`)

```php
Route::middleware('locale')->group(function () {

    // Arabic (default, no prefix)
    Route::get('/',               [HomeController::class, 'index'])->name('home');
    Route::get('/services',       [ServiceController::class, 'index'])->name('services.index');
    // ⚠ CRITICAL: register {service}/{location} BEFORE {service} — otherwise Laravel
    //   matches the two-segment URL with the one-segment route and location becomes the service.
    Route::get('/services/{service}/{location}', [ServiceLocationController::class, 'show'])->name('service-locations.show');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/areas',          [AreaController::class, 'index'])->name('areas.index');
    Route::get('/areas/{location}', [AreaController::class, 'show'])->name('areas.show');
    Route::get('/about',          [AboutController::class, 'index'])->name('about');
    Route::get('/contact',        [ContactController::class, 'index'])->name('contact');
    Route::get('/privacy',        [PageController::class, 'privacy'])->name('privacy');
    Route::get('/blog',               [PostController::class, 'index'])->name('posts.index');
    Route::get('/blog/{post}',        [PostController::class, 'show'])->name('posts.show');
    Route::get('/clusters/{cluster}', [ClusterController::class, 'show'])->name('clusters.show');

    // English (/en/ prefix)
    Route::prefix('en')->name('en.')->group(function () {
        Route::get('/',               [HomeController::class, 'index'])->name('home');
        Route::get('/services',       [ServiceController::class, 'index'])->name('services.index');
        // ⚠ Same ordering rule applies here
        Route::get('/services/{service}/{location}', [ServiceLocationController::class, 'show'])->name('service-locations.show');
        Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
        Route::get('/areas',          [AreaController::class, 'index'])->name('areas.index');
        Route::get('/areas/{location}', [AreaController::class, 'show'])->name('areas.show');
        Route::get('/about',          [AboutController::class, 'index'])->name('about');
        Route::get('/contact',        [ContactController::class, 'index'])->name('contact');
        Route::get('/blog',           [PostController::class, 'index'])->name('posts.index');
        Route::get('/blog/{post}',    [PostController::class, 'show'])->name('posts.show');
        Route::get('/clusters/{cluster}', [ClusterController::class, 'show'])->name('clusters.show');
    });
});

// Locale switcher
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, config('app.available_locales'))) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch')->middleware('web');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Admin (Livewire, role-protected)
Route::prefix('admin')->middleware(['locale','auth','role:admin|writer'])->group(function () {
    Route::get('/',            \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/analytics',   \App\Livewire\Admin\Analytics\Index::class)->name('admin.analytics');
    Route::get('/posts',       \App\Livewire\Admin\Posts\Index::class)->name('admin.posts.index');
    Route::get('/posts/create',\App\Livewire\Admin\Posts\Form::class)->name('admin.posts.create');
    Route::get('/posts/{post:id}/edit', \App\Livewire\Admin\Posts\Form::class)->name('admin.posts.edit');

    Route::middleware('role:admin')->group(function () {
        Route::get('/pillars',                   \App\Livewire\Admin\Pillars\Index::class)->name('admin.pillars.index');
        Route::get('/pillars/create',            \App\Livewire\Admin\Pillars\Form::class)->name('admin.pillars.create');
        Route::get('/pillars/{pillar:id}/edit',  \App\Livewire\Admin\Pillars\Form::class)->name('admin.pillars.edit');
        Route::get('/clusters',                  \App\Livewire\Admin\Clusters\Index::class)->name('admin.clusters.index');
        Route::get('/clusters/create',           \App\Livewire\Admin\Clusters\Form::class)->name('admin.clusters.create');
        Route::get('/clusters/{cluster:id}/edit',\App\Livewire\Admin\Clusters\Form::class)->name('admin.clusters.edit');
        Route::get('/services',        \App\Livewire\Admin\Services\Index::class)->name('admin.services.index');
        Route::get('/services/create', \App\Livewire\Admin\Services\Form::class)->name('admin.services.create');
        Route::get('/services/{service:id}/edit', \App\Livewire\Admin\Services\Form::class)->name('admin.services.edit');
        Route::get('/areas',           \App\Livewire\Admin\Areas\Index::class)->name('admin.areas.index');
        Route::get('/areas/create',    \App\Livewire\Admin\Areas\Form::class)->name('admin.areas.create');
        Route::get('/areas/{location:id}/edit', \App\Livewire\Admin\Areas\Form::class)->name('admin.areas.edit');
        Route::get('/service-locations',                          \App\Livewire\Admin\ServiceLocations\Index::class)->name('admin.service-locations.index');
        Route::get('/service-locations/create',                   \App\Livewire\Admin\ServiceLocations\Form::class)->name('admin.service-locations.create');
        Route::get('/service-locations/{serviceLocationPage:id}/edit', \App\Livewire\Admin\ServiceLocations\Form::class)->name('admin.service-locations.edit');
        Route::get('/contacts/{locale?}', \App\Livewire\Admin\Contacts\Index::class)->name('admin.contacts.index');
        Route::get('/testimonials',    \App\Livewire\Admin\Testimonials\Index::class)->name('admin.testimonials.index');
        Route::get('/gallery',         \App\Livewire\Admin\Gallery\Index::class)->name('admin.gallery.index');
        Route::get('/settings',        \App\Livewire\Admin\Settings\Index::class)->name('admin.settings');
        Route::get('/users',           \App\Livewire\Admin\Users\Index::class)->name('admin.users.index');
        Route::get('/roles',           \App\Livewire\Admin\Roles\Index::class)->name('admin.roles.index');
        Route::get('/permissions',     \App\Livewire\Admin\Permissions\Index::class)->name('admin.permissions.index');
    });
});
```

---

## 8. Frontend Views Structure

```
resources/views/
├── layouts/
│   ├── app.blade.php          # Public layout (nav + footer)
│   └── admin.blade.php        # Admin layout (sidebar + topbar)
├── partials/
│   ├── nav.blade.php          # Responsive bilingual nav + language switcher
│   ├── footer.blade.php       # 5-column footer
│   ├── home-sections.blade.php# Deep service content for homepage SEO
│   └── services-grid.blade.php# Reusable services card grid
├── home.blade.php
├── about.blade.php
├── contact.blade.php
├── privacy.blade.php          # Privacy + Terms (Alpine.js tab switcher)
├── clusters/
│   └── show.blade.php         # Cluster landing page: hero, rich content, services grid, CTA
├── services/
│   ├── index.blade.php
│   ├── show.blade.php         # Service schema + FAQ schema + breadcrumb + area pills
│   └── location.blade.php     # Service × Location page (local SEO landing page)
├── areas/
│   ├── index.blade.php
│   └── show.blade.php         # LocalBusiness schema + FAQ + related areas + service pills
├── posts/
│   ├── index.blade.php        # Blog listing with date + read time
│   └── show.blade.php         # Article schema + breadcrumb
└── livewire/admin/
    ├── dashboard.blade.php
    ├── pillars/
    │   ├── index.blade.php
    │   └── form.blade.php
    ├── clusters/
    │   ├── index.blade.php
    │   └── form.blade.php
    ├── services/
    │   ├── index.blade.php
    │   └── form.blade.php
    ├── service-locations/
    │   ├── index.blade.php    # Matrix grid: services × locations
    │   └── form.blade.php     # Full bilingual CRUD form
    ├── areas/
    ├── posts/
    ├── testimonials/
    ├── contacts/
    ├── settings/
    ├── gallery/
    ├── users/
    ├── roles/
    └── permissions/
```

---

## 9. Public Layout (`layouts/app.blade.php`)

```blade
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:url" content="{{ url()->current() }}">
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased text-gray-900">
    @include('partials.nav')
    <main>@yield('content')</main>
    @include('partials.footer')
    @livewireScripts
</body>
</html>
```

---

## 10. Nav Partial — Key Patterns

```blade
@php
$isAr   = app()->getLocale() === 'ar';
$prefix = $isAr ? '' : 'en.';
@endphp

<nav x-data="{ open: false }" ...>

    {{-- Language switcher --}}
    @if($isAr)
        <a href="{{ route('locale.switch', 'en') }}">English</a>
    @else
        <a href="{{ route('locale.switch', 'ar') }}">العربية</a>
    @endif

    {{-- Mobile close button — aria-hidden fix --}}
    <button @click="$el.blur(); open = false;
                    $nextTick(() => $el.closest('nav').querySelector('.hamburger')?.focus())">
        ✕
    </button>
</nav>
```

**Critical:** Always call `$el.blur()` before `open = false` to avoid aria-hidden focus violation.

---

## 11. SEO Patterns

### 11.1 Every page must have

```blade
@section('meta_title')  Keyword-rich title | Business Name @endsection
@section('meta_description') Unique 150-char description @endsection
```

### 11.2 Service page Schema (in `@push('head')`)

```blade
@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Service",
  "name": {{ json_encode($service->getTranslation('title', $locale)) }},
  "description": {{ json_encode($service->getTranslation('intro', $locale)) }},
  "provider": {
    "@type": "LocalBusiness",
    "name": {{ json_encode($siteName) }},
    "telephone": {{ json_encode(\App\Models\SiteSetting::get('phone_number')) }},
    "addressCountry": "KW"
  },
  "areaServed": { "@type": "Country", "name": "Kuwait" }
}
</script>
@endpush
```

### 11.3 FAQ Schema

```blade
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $i => $faq)
    {
      "@type": "Question",
      "name": {{ json_encode($faq['q']) }},
      "acceptedAnswer": { "@type": "Answer", "text": {{ json_encode($faq['a']) }} }
    }{{ $loop->last ? '' : ',' }}
    @endforeach
  ]
}
</script>
```

### 11.4 Area page Schema

```blade
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "{{ $siteName }} — {{ $location->getTranslation('name', $locale) }}",
  "telephone": "{{ \App\Models\SiteSetting::get('phone_number') }}",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": {{ json_encode($location->getTranslation('name', $locale)) }},
    "addressCountry": "KW"
  },
  "areaServed": {
    "@type": "City",
    "name": {{ json_encode($location->getTranslation('name', $locale)) }}
  }
}
```

### 11.5 Breadcrumb Schema (every inner page)

```blade
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    { "@type":"ListItem","position":1,"name":"Home","item":"{{ $siteUrl }}" },
    { "@type":"ListItem","position":2,"name":"Services","item":"{{ route('services.index') }}" },
    { "@type":"ListItem","position":3,"name":"{{ $service->title }}","item":"{{ url()->current() }}" }
  ]
}
```

### 11.6 Blog Article Schema

```blade
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": {{ json_encode($postTitle) }},
  "datePublished": "{{ $post->published_at->toIso8601String() }}",
  "author": { "@type":"Organization","name":"{{ $siteName }}" },
  "publisher": { "@type":"Organization","name":"{{ $siteName }}" }
}
```

---

## 12. Footer Structure (5 columns)

```blade
<footer class="bg-gray-900 text-gray-300 py-14" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-8 text-sm">

      {{-- Col 1: Brand + contact + social --}}
      {{-- Col 2: Services list (6 items → all link to services.index) --}}
      {{-- Col 3: Areas list (6 items → all link to areas.index) --}}
      {{-- Col 4: Quick links (Home, About, Blog, Contact) --}}
      {{-- Col 5: Legal (Privacy, Terms, Sitemap) + Hours block --}}

    </div>
    {{-- Bottom bar: © year + animated green dot "available now" --}}
  </div>
</footer>
```

---

## 13. Admin Panel — Livewire Components

Each admin section follows the same pattern:

### Livewire Form Component pattern (`app/Livewire/Admin/Services/Form.php`)

```php
#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Service $service = null;

    // One property per translatable field per locale
    public string $title_ar = '';
    public string $title_en = '';
    public string $slug_ar  = '';
    public string $slug_en  = '';

    // Auto-generate slug from title
    public function updatedTitleAr(string $value): void
    {
        $this->slug_ar = $this->toArSlug($value);
    }
    public function updatedTitleEn(string $value): void
    {
        $this->slug_en = Str::slug($value);
    }

    public function mount(?Service $service = null): void
    {
        if ($service?->exists) {
            $this->service  = $service;
            $this->title_ar = $service->getTranslation('title', 'ar');
            $this->title_en = $service->getTranslation('title', 'en');
            // ... load all fields
        }
    }

    public function save(): void
    {
        $this->validate(['title_ar'=>'required','title_en'=>'required', ...]);

        $data = [
            'title' => ['ar' => $this->title_ar, 'en' => $this->title_en],
            'slug'  => ['ar' => $this->slug_ar,  'en' => $this->slug_en],
            // ...
        ];

        $this->service ? $this->service->update($data) : Service::create($data);
        $this->redirect(route('admin.services.index'));
    }
}
```

### Admin Sections to build

| Section | Livewire Class | Description |
|---|---|---|
| Dashboard | `Admin\Dashboard` | Stats: services, areas, contacts, posts count |
| Pillars | `Admin\Pillars\{Index,Form}` | Top-level content hierarchy (must create before clusters) |
| Clusters | `Admin\Clusters\{Index,Form}` | Service categories, belong to a pillar |
| Services | `Admin\Services\{Index,Form}` | CRUD for service pages |
| Areas | `Admin\Areas\{Index,Form}` | CRUD for location pages |
| Service × Location | `Admin\ServiceLocations\{Index,Form}` | Matrix grid + bilingual CRUD for local SEO pages |
| Posts | `Admin\Posts\{Index,Form}` | Blog CRUD with image picker |
| Testimonials | `Admin\Testimonials\Index` | Inline edit, toggle active |
| Contacts | `Admin\Contacts\Index` | View submissions, change status |
| Gallery | `Admin\Gallery\Index` | Upload & manage media library |
| Settings | `Admin\Settings\Index` | Edit site_settings keys |
| Users | `Admin\Users\{Index,Form}` | CRUD users + assign roles |
| Roles | `Admin\Roles\{Index,Form}` | CRUD roles |
| Permissions | `Admin\Permissions\{Index,Form}` | CRUD permissions |
| Analytics | `Admin\Analytics\Index` | Page views chart |

### Admin index table — image thumbnail + public page link pattern

Every admin index table that belongs to a model with a public page should show a thumbnail that links to that public page. Use this pattern:

```blade
@php
    $slugAr    = $cluster->getTranslation('slug', 'ar');
    $publicUrl = $slugAr ? route('clusters.show', $slugAr) : null;
@endphp

<td class="px-4 py-3">
    @if($model->image_url && $publicUrl)
        {{-- Thumbnail → links to public page --}}
        <a href="{{ $publicUrl }}" target="_blank">
            <img src="{{ $model->image_url }}" alt="{{ $model->getTranslation('title', 'ar') }}"
                 class="w-12 h-12 rounded-lg object-cover border border-white/10 hover:border-purple-500 transition">
        </a>
    @elseif($publicUrl)
        {{-- No image but has slug → external-link icon placeholder --}}
        <a href="{{ $publicUrl }}" target="_blank"
           class="w-12 h-12 rounded-lg bg-white/5 border border-white/10 hover:border-purple-500 flex items-center justify-center transition">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
        </a>
    @else
        {{-- No slug yet → plain grey box --}}
        <div class="w-12 h-12 rounded-lg bg-white/5 border border-white/10"></div>
    @endif
</td>

{{-- Title cell also links to public page with ↗ icon --}}
<td class="px-4 py-3">
    @if($publicUrl)
        <a href="{{ $publicUrl }}" target="_blank"
           class="text-white font-medium hover:text-purple-400 transition inline-flex items-center gap-1">
            {{ $model->getTranslation('title', 'ar') }}
            <svg class="w-3 h-3 opacity-40" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
        </a>
    @else
        <span class="text-white font-medium">{{ $model->getTranslation('title', 'ar') }}</span>
    @endif
</td>
```

**Three states for the image cell:**
1. Has image + has slug → thumbnail, clicking opens public page in new tab
2. No image + has slug → grey box with ↗ icon, still clickable
3. No slug yet → plain grey box, no link (nothing to link to)

Always use the Arabic slug for the `route()` call in the admin, since the admin panel is typically viewed in Arabic locale. The public controller handles the canonical redirect for the other locale.

### Admin Layout (`layouts/admin.blade.php`) key structure
```blade
<div class="flex h-screen overflow-hidden bg-gray-100">
    {{-- Sidebar: fixed width, collapsible on mobile --}}
    <aside class="w-64 bg-gray-900 text-white flex-shrink-0">
        {{-- Logo, nav links with icons, active state --}}
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Topbar: page title, language switcher, user menu --}}
        <header class="bg-white border-b h-16 flex items-center px-6 justify-between">
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </main>
    </div>
</div>
```

---

## 14. Roles & Permissions Setup

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

Create roles and permissions in a seeder:
```php
Role::create(['name' => 'admin']);
Role::create(['name' => 'writer']);

Permission::create(['name' => 'posts.index']);
Permission::create(['name' => 'posts.create']);
Permission::create(['name' => 'posts.edit']);

// Admin gets all, writer gets posts only
$admin->givePermissionTo(Permission::all());
$writer->givePermissionTo(['posts.index','posts.create','posts.edit']);
```

Middleware registration:
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $m) {
    $m->alias([
        'role'                => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission'          => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission'  => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ]);
})
```

Make first admin:
```bash
php artisan make:command MakeAdmin
# Command: User::first()->assignRole('admin');
```

---

## 15. WhatsApp Helper

```php
// app/Helpers/WhatsAppHelper.php
class WhatsAppHelper
{
    public static function url(string $message = ''): string
    {
        $number  = SiteSetting::get('whatsapp_number');
        $default = app()->getLocale() === 'ar'
            ? 'مرحباً، أريد الاستفسار'       // translate per business
            : 'Hello, I need assistance';

        return 'https://wa.me/' . $number . '?text=' . urlencode($message ?: $default);
    }
}
```

Usage:
```blade
<a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank">WhatsApp</a>
```

---

## 16. Sitemap Controller

```php
class SitemapController extends Controller
{
    public function index()
    {
        $services  = Service::active()->get();
        $locations = Location::where('is_active', true)->get();
        $posts     = Post::published()->get();

        return response()->view('sitemap', compact('services','locations','posts'))
                         ->header('Content-Type', 'application/xml');
    }
}
```

`resources/views/sitemap.blade.php`:
```blade
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><priority>1.0</priority></url>
    <url><loc>{{ url('/en') }}</loc><priority>0.9</priority></url>

    @foreach($services as $s)
    <url><loc>{{ url('/services/'.$s->getTranslation('slug','ar')) }}</loc><priority>0.8</priority></url>
    <url><loc>{{ url('/en/services/'.$s->getTranslation('slug','en')) }}</loc><priority>0.8</priority></url>
    @endforeach

    @foreach($locations as $l)
    <url><loc>{{ url('/areas/'.$l->getTranslation('slug','ar')) }}</loc><priority>0.7</priority></url>
    <url><loc>{{ url('/en/areas/'.$l->getTranslation('slug','en')) }}</loc><priority>0.7</priority></url>
    @endforeach

    @foreach($posts as $p)
    <url><loc>{{ url('/blog/'.$p->getTranslation('slug','ar')) }}</loc><priority>0.6</priority></url>
    @endforeach
</urlset>
```

---

## 17. Blog Cards — Key Patterns

```blade
{{-- Correct excerpt display (strips HTML tags before truncating) --}}
{{ Str::limit(strip_tags($post->getTranslation('excerpt', $locale)), 140) }}

{{-- Reading time estimate --}}
@php
$wordCount   = str_word_count(strip_tags($post->getTranslation('content', $locale) ?? ''));
$readMinutes = max(1, (int) ceil($wordCount / 200));
@endphp
{{ $isAr ? $readMinutes . ' د قراءة' : $readMinutes . ' min read' }}

{{-- Date --}}
{{ $post->published_at->format('d M Y') }}
```

**NEVER use `{{ $post->excerpt }}` directly if the field stores HTML — it will print raw tags.**

---

## 18. FAQ Accordion (Alpine.js)

```blade
<div x-data="{ open: null }">
    @foreach($faqs as $i => $faq)
    <div class="border-b border-gray-200">
        <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                class="w-full text-start py-4 font-semibold text-gray-900 flex justify-between items-center">
            {{ $faq['q'] }}
            <svg :class="open === {{ $i }} ? 'rotate-180' : ''"
                 class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open === {{ $i }}" x-collapse class="pb-4 text-gray-600 text-sm">
            {{ $faq['a'] }}
        </div>
    </div>
    @endforeach
</div>
```

---

## 19. Bilingual Rich-Text Editor (TinyMCE)

Every admin form that needs long-form content (intro, body, description) uses a shared Blade component that wraps two TinyMCE instances — one for Arabic (RTL) and one for English (LTR) — behind an AR/EN tab switcher.

### Component location

```
resources/views/components/admin/bilingual-editor.blade.php
```

### Usage in any admin form blade

```blade
{{-- Short intro (4 rows) --}}
<x-admin.bilingual-editor
    label="{{ __('admin.common.intro') }}"
    modelAr="intro_ar"
    modelEn="intro_en"
    :rows="4"
/>

{{-- Long rich content (8 rows) --}}
<x-admin.bilingual-editor
    label="{{ __('admin.common.content') }}"
    modelAr="content_ar"
    modelEn="content_en"
    :rows="8"
/>
```

Props:

| Prop | Type | Default | Description |
|---|---|---|---|
| `label` | string | `'المحتوى'` | Card heading shown above the tabs |
| `modelAr` | string | required | Livewire property name for Arabic content |
| `modelEn` | string | required | Livewire property name for English content |
| `rows` | int | `8` | Textarea rows (TinyMCE ignores this, but fallback textarea uses it) |
| `required` | bool | `false` | Adds `*` to both labels |

### Component source (`resources/views/components/admin/bilingual-editor.blade.php`)

```blade
@props(['label' => 'المحتوى', 'modelAr', 'modelEn', 'rows' => 8, 'required' => false])

@php
    $idAr = 'tinymce_' . $modelAr . '_' . uniqid();
    $idEn = 'tinymce_' . $modelEn . '_' . uniqid();
@endphp

<div
    x-data="{ tab: 'ar' }"
    x-init="$nextTick(() => {
        initTinyMCE('#{{ $idAr }}', 'rtl');
        initTinyMCE('#{{ $idEn }}', 'ltr');
    })"
    class="bg-[#1a1d27] rounded-xl border border-white/10 p-6"
>
    {{-- Tab switcher --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest">{{ $label }}</h2>
        <div class="flex bg-[#0f1117] rounded-lg p-0.5 gap-0.5 border border-white/10">
            <button type="button" @click="tab = 'ar'"
                :class="tab === 'ar' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white'"
                class="px-4 py-1.5 rounded-md text-xs font-semibold transition">العربية</button>
            <button type="button" @click="tab = 'en'"
                :class="tab === 'en' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white'"
                class="px-4 py-1.5 rounded-md text-xs font-semibold transition">English</button>
        </div>
    </div>

    {{-- Both panels always in DOM so TinyMCE can initialise --}}
    <div :style="tab === 'ar' ? '' : 'display:none'">
        <label class="block text-xs text-gray-500 mb-1">{{ $label }} (عربي){{ $required ? ' *' : '' }}</label>
        <textarea id="{{ $idAr }}" wire:model="{{ $modelAr }}" rows="{{ $rows }}" dir="rtl"
            class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white"></textarea>
    </div>
    <div :style="tab === 'en' ? '' : 'display:none'">
        <label class="block text-xs text-gray-500 mb-1">{{ $label }} (English){{ $required ? ' *' : '' }}</label>
        <textarea id="{{ $idEn }}" wire:model="{{ $modelEn }}" rows="{{ $rows }}" dir="ltr"
            class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white"></textarea>
    </div>
</div>
```

### TinyMCE — `layouts/admin.blade.php`

Load the CDN script once, define `window.initTinyMCE()`, and clean up on Livewire navigation:

```blade
{{-- After @livewireScripts --}}
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
window.initTinyMCE = function (selector, dir) {
    var existing = tinymce.get(selector.replace('#', ''));
    if (existing) { existing.remove(); }

    tinymce.init({
        selector:        selector,
        directionality:  dir,           // 'rtl' for Arabic, 'ltr' for English
        height:          600,
        menubar:         false,
        plugins:         'lists link image table code wordcount',
        toolbar:         'undo redo | bold italic underline | bullist numlist | link | code',
        skin:            'oxide-dark',
        content_css:     'dark',
        base_url:        '/tinymce',
        setup: function (editor) {
            editor.on('Change', function () {
                // Push content back to Livewire wire:model property
                var textarea = document.querySelector(selector);
                if (textarea) {
                    textarea.value = editor.getContent();
                    textarea.dispatchEvent(new Event('input'));
                }
            });
        },
    });
};

// Clean up all TinyMCE instances before Livewire swaps the DOM
document.addEventListener('livewire:navigating', function () { tinymce.remove(); });
</script>
```

> **Replace `YOUR_API_KEY`** with a key from [tiny.cloud](https://www.tiny.cloud). The free tier is sufficient for personal/small projects.

### Livewire Form — required properties per editor

For each `<x-admin.bilingual-editor>` you add, the parent Livewire component needs:

```php
// Properties
public string $intro_ar   = '';
public string $intro_en   = '';
public string $content_ar = '';
public string $content_en = '';

// Load in mount()
$this->intro_ar   = $model->getTranslation('intro', 'ar') ?? '';
$this->intro_en   = $model->getTranslation('intro', 'en') ?? '';
$this->content_ar = $model->getTranslation('content', 'ar') ?? '';
$this->content_en = $model->getTranslation('content', 'en') ?? '';

// Save in save()
$data['intro']   = ['ar' => $this->intro_ar,   'en' => $this->intro_en];
$data['content'] = ['ar' => $this->content_ar, 'en' => $this->content_en];
```

### Title inputs + slug preview — NEVER use `wire:model.live` alongside TinyMCE

`wire:model.live` fires a Livewire round-trip on **every keystroke**. This re-renders the whole component, destroying and re-initialising every TinyMCE instance on the page — the editor flashes blank while you type.

**Wrong (causes TinyMCE flash):**
```blade
<input wire:model.live="title_ar" type="text">
@if($slug_ar)
    <p>🔗 {{ $slug_ar }}</p>  {{-- server-rendered, needs a round-trip --}}
@endif
```

**Correct — blur sync + Alpine client-side slug preview:**
```blade
<div x-data="{ slug: '{{ $slug_ar }}' }">
    <input
        wire:model.blur="title_ar"
        type="text"
        dir="rtl"
        x-on:input="slug = $el.value.replace(/[^؀-ۿ\d\s-]/g,'').trim().replace(/[\s-]+/g,'-')"
        class="...">
    <p x-show="slug" class="text-xs text-gray-500 mt-1 font-mono" dir="rtl">
        🔗 <span x-text="slug"></span>
    </p>
</div>

<div x-data="{ slug: '{{ $slug_en }}' }">
    <input
        wire:model.blur="title_en"
        type="text"
        dir="ltr"
        x-on:input="slug = $el.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/[\s-]+/g,'-')"
        class="...">
    <p x-show="slug" class="text-xs text-gray-500 mt-1 font-mono" dir="ltr">
        🔗 <span x-text="slug"></span>
    </p>
</div>
```

How it works:
- `wire:model.blur` — Livewire syncs only when the user **leaves** the field (one request, not one per character)
- `x-on:input` — Alpine generates the slug preview **instantly client-side** while typing, with no network request
- `x-data="{ slug: '{{ $slug_ar }}' }"` — pre-populates the preview with the server value on edit pages

The server-side `updatedTitleAr` / `updatedTitleEn` methods in the Livewire component still run on blur to set the canonical slug value that gets saved — they are not removed, just no longer called on every keystroke.

Apply this pattern to **every admin form** that has both title inputs and a TinyMCE editor on the same page (services, clusters, pillars, areas, etc.).

### Image picker in admin forms

For sections that need a featured image chosen from the gallery, embed the existing `admin.image-picker` Livewire component:

```blade
@livewire('admin.image-picker', [
    'field'    => 'image_url',
    'imageUrl' => $image_url,
    'label'    => __('admin.common.main_image'),
])
```

Wire it up in the parent Livewire component:

```php
use Livewire\Attributes\On;

public string $image_url = '';

#[On('image-picked-image_url')]
public function imageSelected(string $url): void
{
    $this->image_url = $url;
}

// In mount(): $this->image_url = $model->image_url ?? '';
// In save():  $data['image_url'] = $this->image_url ?: null;
```

The `field` value in the component must match the suffix in `#[On('image-picked-{field}')]`.

> **Inline mode:** Pass `:inline="true"` when embedding inside another card (e.g. Settings page brand images). This renders only the button + modal without the standalone card wrapper, preventing double-wrapped UI.

---

## 20. Contact Form (Livewire)

```php
// app/Livewire/ContactForm.php
class ContactForm extends Component
{
    public string $name    = '';
    public string $phone   = '';
    public string $email   = '';
    public string $message = '';
    public bool   $sent    = false;

    public function send()
    {
        $this->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|string|max:20',
        ]);

        Contact::create([
            'name'    => $this->name,
            'phone'   => $this->phone,
            'email'   => $this->email,
            'message' => $this->message,
            'locale'  => app()->getLocale(),
        ]);

        $this->reset(['name','phone','email','message']);
        $this->sent = true;
    }
}
```

---

## 21. Image Upload & WebP Conversion

```php
// app/Services/ImageConverter.php
class ImageConverter
{
    public function storeAsWebp($file, string $directory = 'media'): array
    {
        $filename = Str::uuid() . '.webp';
        $path     = storage_path("app/public/{$directory}/{$filename}");

        Image::read($file)->toWebp(80)->save($path);

        return [
            'filename'      => $filename,
            'original_name' => $file->getClientOriginalName(),
            'path'          => "public/{$directory}/{$filename}",
            'url'           => asset("storage/{$directory}/{$filename}"),
            'size'          => filesize($path),
            'mime_type'     => 'image/webp',
        ];
    }
}
```

---

## 22. Area Landing Page — Content Pattern

Each area page must have **unique content** to avoid duplicate-content penalties:

```blade
{{-- Auto-generated unique intro if DB description is empty --}}
@php
$areaName = $location->getTranslation('name', $locale);
$govName  = $isAr
    ? match($location->governorate) {
        'capital'          => 'محافظة العاصمة',
        'hawalli'          => 'محافظة حولي',
        'farwaniya'        => 'محافظة الفروانية',
        'ahmadi'           => 'محافظة الأحمدي',
        'jahra'            => 'محافظة الجهراء',
        'mubarak_al_kabeer'=> 'محافظة مبارك الكبير',
        default            => $location->governorate,
    }
    : ucfirst(str_replace('_', ' ', $location->governorate)) . ' Governorate';
@endphp

{{-- Unique H1 per area --}}
<h1>{{ $isAr ? "فني $SERVICE_NOUN_AR في $areaName" : "$SERVICE_NOUN_EN Technician in $areaName" }}</h1>

{{-- Unique description --}}
<p>
  {{ $isAr
    ? "تغطي $BUSINESS_NAME_AR منطقة $areaName التابعة لـ$govName بخدمات $SERVICE_NOUN_AR..."
    : "$BUSINESS_NAME_EN covers $areaName in $govName with $SERVICE_NOUN_EN services..." }}
</p>
```

---

## 23. Brand Images in Settings (Logo, Favicon, Hero)

The admin **Settings** page includes a "Brand & Images" section that lets the admin pick logo, favicon, and hero/OG image directly from the media gallery — no code deployment needed.

### How it works

Three `ImagePicker` Livewire sub-components are embedded in the settings form, each bound to a different field name:

```blade
<livewire:admin.image-picker field="logo_url"       :imageUrl="$logo_url"    :key="'logo-picker'" />
<livewire:admin.image-picker field="favicon_url"    :imageUrl="$favicon_url" :key="'favicon-picker'" />
<livewire:admin.image-picker field="hero_image_url" :imageUrl="$hero_url"    :key="'hero-picker'" />
```

Each picker dispatches `image-picked-{field}` when an image is selected. The parent `Settings\Index` Livewire component catches those events via `#[On]` attributes:

```php
#[On('image-picked-logo_url')]
public function logoSelected(string $url): void { $this->logo_url = $url; }

#[On('image-picked-favicon_url')]
public function faviconSelected(string $url): void { $this->favicon_url = $url; }

#[On('image-picked-hero_image_url')]
public function heroSelected(string $url): void { $this->hero_url = $url; }
```

On save, all three are persisted as `site_settings` rows:

```php
SiteSetting::set('logo_url',       $this->logo_url);
SiteSetting::set('favicon_url',    $this->favicon_url);
SiteSetting::set('hero_image_url', $this->hero_url);
```

### How `layouts/app.blade.php` consumes them

```blade
{{-- Favicon: DB setting takes priority over static file --}}
@php $faviconUrl = \App\Models\SiteSetting::get('favicon_url') ?: asset('favicon.ico'); @endphp
<link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
<link rel="apple-touch-icon" href="{{ \App\Models\SiteSetting::get('logo_url') ?: asset('apple-touch-icon.png') }}">

{{-- OG / Twitter image: hero_image_url from DB, fallback to static --}}
@php $ogImage = \App\Models\SiteSetting::get('hero_image_url') ?: asset('images/og-default.jpg'); @endphp
<meta property="og:image" content="@yield('og_image', $ogImage)">
<meta name="twitter:image" content="@yield('og_image', $ogImage)">
```

Individual pages can still override `og_image` per-page with `@section('og_image', $post->image_url)`.

### Logo in the nav/header

Read the setting anywhere in Blade:

```blade
@php $logoUrl = \App\Models\SiteSetting::get('logo_url'); @endphp
@if($logoUrl)
    <img src="{{ $logoUrl }}" alt="{{ \App\Models\SiteSetting::get('site_name_' . app()->getLocale()) }}"
         class="h-10 w-auto object-contain">
@else
    <span class="font-bold text-xl text-white">
        {{ \App\Models\SiteSetting::get('site_name_' . app()->getLocale()) }}
    </span>
@endif
```

### Recommended image sizes

| Setting key | Use | Recommended size |
|---|---|---|
| `logo_url` | Header, footer, apple-touch-icon | PNG transparent, min 200px wide |
| `favicon_url` | Browser tab icon | ICO or PNG 32×32 or 64×64 |
| `hero_image_url` | OG/Twitter social share card | 1200×630 px JPG/PNG |

---

## 24. Service × Location Local SEO System

This is the highest-ROI feature. Every combination of `service + area` gets its own URL, H1, meta, and unique content — producing pages like `/services/ac-repair/salmiya` that rank for hyper-local queries like "تصليح تكييف السالمية".

### How it works

```
5 services × 12 areas = 60 SEO landing pages
Each page has: unique H1 · unique meta · unique intro · local_problem · local_solution
```

### ServiceLocationController (`app/Http/Controllers/ServiceLocationController.php`)

```php
public function show(Service $service, Location $location)
{
    $locale = app()->getLocale();

    // Resolve from DB (real content) or auto-generate virtual page
    $page = ServiceLocationPage::where('service_id', $service->id)
        ->where('location_id', $location->id)
        ->where('status', 'active')
        ->first();

    if (! $page) {
        // Virtual page — auto-generated, marked noindex
        $page = new ServiceLocationPage([
            'service_id'  => $service->id,
            'location_id' => $location->id,
            'status'      => 'active',
            'noindex'     => true,
        ]);
        foreach (['ar', 'en'] as $l) {
            foreach (ServiceLocationPage::autoFill($service, $location, $l) as $field => $value) {
                $page->setTranslation($field, $l, $value);
            }
        }
    }

    // 301 redirect if URL slug doesn't match current locale's canonical slug
    $serviceSlug  = $service->getTranslation('slug', $locale);
    $locationSlug = $location->getTranslation('slug', $locale);
    $seg = request()->segments();
    if (($seg[count($seg)-2] ?? null) !== $serviceSlug || ($seg[count($seg)-1] ?? null) !== $locationSlug) {
        $routeName = $locale === 'ar' ? 'service-locations.show' : 'en.service-locations.show';
        return redirect()->route($routeName, [$serviceSlug, $locationSlug], 301);
    }

    return view('services.location', compact(
        'service', 'location', 'page',
        'otherServices', 'otherLocations', 'nearbyLocations'  // nearby = same governorate
    ));
}
```

### `services/location.blade.php` — key sections

```blade
{{-- noindex until real content is added --}}
@if($page->noindex)
<meta name="robots" content="noindex, follow">
@endif

{{-- Schema: Service + FAQPage + BreadcrumbList --}}
{{-- Hero: H1, intro, WhatsApp CTA pre-filled with service+location --}}
{{-- Local Problem card (red background) --}}
{{-- Local Solution card (green background) --}}
{{-- unique_local_content rendered as {!! $page->unique_local_content !!} --}}
{{-- FAQ accordion (4 dynamic questions with service+location names) --}}
{{-- Nearby locations: same governorate, same service --}}
{{-- Other services in this location --}}
```

### Admin: "Generate All" button

In `Admin\ServiceLocations\Index`:

```php
public function generateAll(): void
{
    $services  = Service::active()->get();
    $locations = Location::where('is_active', true)->get();
    $created   = 0;

    foreach ($services as $service) {
        foreach ($locations as $location) {
            $exists = ServiceLocationPage::where('service_id', $service->id)
                ->where('location_id', $location->id)->exists();

            if (! $exists) {
                $data = ['service_id' => $service->id, 'location_id' => $location->id, 'status' => 'active'];
                foreach (['ar', 'en'] as $locale) {
                    foreach (ServiceLocationPage::autoFill($service, $location, $locale) as $field => $value) {
                        $data[$field][$locale] = $value;
                    }
                }
                ServiceLocationPage::create($data);
                $created++;
            }
        }
    }
    session()->flash('success', "Created {$created} new pages.");
}
```

### Admin matrix view

The index blade renders a grid table: services as columns, locations as rows. Each cell shows:
- 🟢 green dot = active page
- ⚪ grey dot = inactive page
- `—` dash = not created yet (click to create)

### Sitemap entries

```php
ServiceLocationPage::where('status', 'active')
    ->where('noindex', false)          // only index pages with real content
    ->with(['service', 'location'])
    ->get()
    ->each(function ($page) use ($sitemap, $base, $now) {
        $arUrl = $base . '/services/' . $page->service->getTranslation('slug','ar')
                       . '/' . $page->location->getTranslation('slug','ar');
        $enUrl = $base . '/en/services/' . $page->service->getTranslation('slug','en')
                       . '/' . $page->location->getTranslation('slug','en');
        // Add both URLs at priority 0.9
    });
```

### Workflow to go live

1. Add pillars → add clusters → add services → add locations
2. Admin → "Service × Location" → click **Generate All** (creates all combinations)
3. For each page: add `unique_local_content`, refine `local_problem`/`local_solution`
4. Once content is good: uncheck **noindex** on the page
5. Submit sitemap to Google Search Console

---

## 25. Internal Linking — Local SEO Silo

Each page links to all related service × location combinations to pass PageRank through the silo.

### On `services/show.blade.php` — "This service in all areas"

```blade
@if($locations->count())
<section class="py-12 bg-blue-50">
    <h2>{{ $isAr ? "خدمة {$title} في جميع مناطق الكويت" : "{$title} Across All Areas" }}</h2>
    <div class="flex flex-wrap gap-2">
        @foreach($locations as $loc)
        @php
            $locSlug = $loc->getTranslation('slug', $locale);
            $locName = $loc->getTranslation('name', $locale);
            $svcSlug = $service->getTranslation('slug', $locale);
            $prefix  = $isAr ? '' : 'en.';
        @endphp
        <a href="{{ route($prefix . 'service-locations.show', [$svcSlug, $locSlug]) }}"
           class="pill">
            {{ $isAr ? "{$title} في {$locName}" : "{$title} in {$locName}" }}
        </a>
        @endforeach
    </div>
</section>
@endif
```

### On `areas/show.blade.php` — "All services in this area"

```blade
@if($services->count())
<section class="py-12 bg-blue-50">
    <h2>{{ $isAr ? "جميع الخدمات في {$name}" : "All Services in {$name}" }}</h2>
    <div class="flex flex-wrap gap-2">
        @foreach($services as $svc)
        @php
            $svcSlug = $svc->getTranslation('slug', $locale);
            $svcName = $svc->getTranslation('title', $locale);
            $locSlug = $location->getTranslation('slug', $locale);
            $prefix  = $isAr ? '' : 'en.';
        @endphp
        <a href="{{ route($prefix . 'service-locations.show', [$svcSlug, $locSlug]) }}"
           class="pill">
            {{ $isAr ? "{$svcName} في {$name}" : "{$svcName} in {$name}" }}
        </a>
        @endforeach
    </div>
</section>
@endif
```

---

## 26. Locale-Aware Route Naming — Critical Rule

**Every** link in a shared partial (nav, footer, services-grid, areas-grid) must use `$prefix . 'route.name'`, not a hardcoded route name. Hardcoded names only work for one locale.

```blade
@php
$isAr   = app()->getLocale() === 'ar';
$prefix = $isAr ? '' : 'en.';
@endphp

{{-- Correct --}}
<a href="{{ route($prefix . 'services.show', $slug) }}">...</a>
<a href="{{ route($prefix . 'areas.show', $slug) }}">...</a>
<a href="{{ route($prefix . 'home') }}">Logo</a>

{{-- Wrong — only works in Arabic --}}
<a href="{{ route('services.show', $slug) }}">...</a>
```

**Rule:** `$prefix` is always defined at the top of any partial that generates links. Never hardcode a route name that has an `en.` equivalent.

---

## 27. Pillar → Cluster → Service Hierarchy

```
Pillar (top topic)
  └── Cluster (sub-topic / category)
        └── Service (specific offering)
```

**Example for AC business:**
```
Pillar:  "صيانة تكييف" / "AC Maintenance"
  Cluster: "صيانة سبليت" / "Split AC Repair"
    Service: "صيانة سبليت سامسونج"
    Service: "صيانة سبليت LG"
  Cluster: "صيانة مركزي" / "Central AC Repair"
    Service: "صيانة تكييف مركزي تجاري"
```

**Why it matters:** This silo structure tells Google that your site is an authority on the topic. Internal links flow from cluster pages to service pages, and from service pages to service × location pages.

### Admin workflow order

1. **Create Pillars first** (`/admin/pillars`) — e.g. "AC Installation", "AC Repair", "AC Cleaning"
2. **Create Clusters** (`/admin/clusters`) — choose a pillar for each, e.g. "Split AC Repair" under "AC Repair"
3. **Create Services** (`/admin/services`) — choose a cluster for each service
4. **Create Locations** (`/admin/areas`)
5. **Generate Service × Location pages** (`/admin/service-locations` → "Generate All")

---

## 28. Checklist — Adapt for Your Business

### Step 1: Replace content
- [ ] Update `BUSINESS_NAME`, `SERVICE_NOUN_AR/EN`, `COUNTRY`, `CURRENCY` everywhere
- [ ] Update `service_type` enum values in migration and Service model `icon()` method
- [ ] Update FAQ questions in `services/show.blade.php` to match your service types
- [ ] Update `lang/ar/site.php` and `lang/en/site.php` with your deep service content
- [ ] Update footer services list and areas list
- [ ] Update about page story, stats, brands/suppliers, why-us reasons
- [ ] Update WhatsApp default message text

### Step 2: Update design
- [ ] Change `bg-blue-700` primary color to your brand color throughout
- [ ] Replace hero images/illustrations
- [ ] Update social media links in footer
- [ ] Update working hours in footer and contact page

### Step 3: Database seed (in order)
- [ ] Seed `site_settings` with real phone, whatsapp, email, address
- [ ] Create admin user and assign role
- [ ] Create **Pillars** in admin (`/admin/pillars`)
- [ ] Create **Clusters** in admin, each linked to a pillar
- [ ] Create **Services** in admin, each linked to a cluster
- [ ] Create **Locations** (areas) in admin
- [ ] Admin → Service × Location → **Generate All** to create all combinations
- [ ] Edit individual service × location pages: add unique content, uncheck noindex

### Step 4: Brand images
- [ ] Upload logo, favicon, and hero/OG image via Gallery
- [ ] Admin → Settings → Brand Identity → assign each image

### Step 5: SEO
- [ ] Verify all pages have unique `meta_title` and `meta_description`
- [ ] All service pages have Service + FAQ + BreadcrumbList schema
- [ ] All area pages have LocalBusiness + BreadcrumbList schema
- [ ] All service × location pages have Service + FAQPage + BreadcrumbList schema
- [ ] Blog show page has Article + BreadcrumbList schema
- [ ] Sitemap at `/sitemap.xml` is accessible and includes service × location pages
- [ ] Submit sitemap to Google Search Console

---

## 29. Key Gotchas & Rules

1. **Never use `{{ $post->excerpt }}` if the field stores HTML** — use `strip_tags()` first, then `Str::limit()`.
2. **Always `$el.blur()` before `open = false`** in Alpine.js mobile nav — otherwise aria-hidden violation in browser console.
3. **Slug redirect in `show()`** — always 301-redirect if the slug doesn't match the current locale's slug.
4. **`json_encode()` in Schema** — always use `json_encode()` not direct `{{ }}` for Schema values to avoid XSS and JSON syntax errors.
5. **`@push('head')` for schemas** — requires `@stack('head')` in `layouts/app.blade.php` `<head>`.
6. **Testimonials may be empty** — always wrap in `@if($testimonials->isNotEmpty())`.
7. **`relatedLocations`** — the AreaController must pass this variable or the area show page will error.
8. **Bilingual slugs in Sitemap** — generate separate `<url>` entries for each locale.
9. **Admin route binding uses `{model:id}`** — not slug — to avoid locale ambiguity in admin.
10. **Tailwind v4 safelisting** — any dynamically generated class (e.g. `w-64`, sidebar widths) must be in a safelist or a `@source` directive in `tailwind.config.js`.
11. **`{service}/{location}` route order** — register the two-segment route BEFORE the one-segment route in `web.php`. If `{service}` is first, Laravel matches `salmiya` as a service slug and throws a 404. This applies to both the AR and EN route groups.
12. **`noindex` on auto-generated pages** — `ServiceLocationPage::autoFill()` produces templated content. Always set `noindex = true` on auto-generated pages and only flip to `false` once genuinely unique content has been written. Google penalises thin duplicate pages.
13. **Pillars must exist before Clusters** — the `clusters.pillar_id` column has a NOT NULL foreign key. Creating a cluster without a pillar will throw a database error. Admin workflow: Pillars → Clusters → Services.
14. **Locale-aware route names in partials** — use `$prefix . 'route.name'` pattern in every shared partial. Hardcoded `route('services.show')` only resolves for Arabic; in English it throws `RouteNotFoundException`.
15. **ImagePicker `$inline` prop** — when embedding `<livewire:admin.image-picker>` inside another form (e.g. Settings), pass `:inline="true"` to render just the button + modal without the standalone card wrapper and thumbnail, which would otherwise double-render.
16. **TinyMCE + Livewire sync** — TinyMCE intercepts `input` events, so `wire:model` alone does not update the Livewire property. The `initTinyMCE()` setup function must fire a native `input` event on the underlying `<textarea>` inside the `editor.on('Change')` callback. Without this, saving a form after only editing rich-text content will persist the old value.
17. **TinyMCE `livewire:navigating` cleanup** — always call `tinymce.remove()` inside a `document.addEventListener('livewire:navigating', ...)` handler. If you skip this, navigating between admin pages leaves orphaned editor instances that conflict with re-initialisation on the new page.
18. **Both editor panels must stay in the DOM** — the `bilingual-editor` component hides the inactive language panel with `:style="display:none"` (not `x-if`). Using `x-if` would remove the element from the DOM before TinyMCE can attach, causing an initialisation error. Always use `display:none` toggling for TinyMCE host elements.
19. **Admin image thumbnail uses Arabic slug for `route()`** — the admin panel is served in the Arabic locale, so always resolve the public URL using the Arabic slug (`$model->getTranslation('slug', 'ar')`). The public `ClusterController` (and other show controllers) handle a 301 canonical redirect when the URL locale doesn't match, so the link will always land on the correct page regardless of which slug you use — but using the Arabic one avoids a redirect.
20. **Never use `wire:model.live` on title inputs when TinyMCE is on the same page** — `.live` sends a network request on every keystroke, which re-renders the Livewire component and destroys/re-initialises TinyMCE, causing the editor to flash blank while you type. Always use `wire:model.blur` for title fields and generate the slug preview client-side with Alpine.js `x-on:input`. See section 19 for the correct pattern.
