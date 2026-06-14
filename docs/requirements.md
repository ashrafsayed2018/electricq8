# CoolQ8 — Kuwait AC Services Website

## خدمات تكييف الهواء — الكويت

> **Stack:** Laravel 13 · Livewire 4 · Spatie Permission · Spatie Translatable · Tailwind CSS 4
> **Languages:** Arabic (RTL, default) + English (LTR)
> **PHP:** 8.2+ (Herd uses 8.2.30; `composer.json` set to `^8.2`)
> **Local dev:** `coolq8.test` via Laravel Herd

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Tech Stack & Installation](#2-tech-stack--installation)
3. [Database Schema](#3-database-schema)
4. [Eloquent Models](#4-eloquent-models)
5. [Bilingual Setup](#5-bilingual-setup-ar--en)
6. [Routes](#6-routes)
7. [Livewire 4 Components](#7-livewire-4-components)
8. [Controllers](#8-controllers-public)
9. [SEO Strategy](#9-seo-strategy)
10. [WhatsApp Integration](#10-whatsapp-integration)
11. [Admin Panel](#11-admin-panel)
12. [Authentication & Authorization](#12-authentication--authorization)
13. [File Structure](#13-file-structure)
14. [Setup Checklist](#14-setup-checklist)
15. [Posts (Blog)](#15-posts-blog)
16. [Gallery](#16-gallery)

---

## 1. Project Overview

An informational + contact website for an AC installation, repair, cleaning, gas refill, and 24/7 emergency service company serving all Kuwait governorates. Fully bilingual Arabic/English with WhatsApp, contact form, and phone integration. Built around a **4-level SEO topic architecture** to maximise search visibility across services, clusters, and locations.

### SEO Content Architecture

```
Pillar
  └── Cluster (AC Repair)
        └── Service (Split AC Repair)
              └── ServiceLocationPage (Split AC Repair in Salmiya)
```

### URL Structure

```
/ac-services-kuwait              ← Pillar
/ac-repair                       ← Cluster
/ac-repair/split-ac-repair       ← Service
/ac-repair/split-ac-repair/salmiya  ← ServiceLocationPage

/en/ac-repair                    ← English equivalents
/en/ac-repair/split-ac-repair/salmiya
```

### Kuwait Governorates Served

| English           | Arabic       | Governorate Key      |
| ----------------- | ------------ | -------------------- |
| Kuwait City       | مدينة الكويت | capital              |
| Hawalli           | حولي         | hawalli              |
| Farwaniya         | الفروانية    | farwaniya            |
| Ahmadi            | الأحمدي      | ahmadi               |
| Jahra             | الجهراء      | jahra                |
| Mubarak Al-Kabeer | مبارك الكبير | mubarak_al_kabeer    |

---

## 2. Tech Stack & Installation

| Package             | Version | Purpose                                       |
| ------------------- | ------- | --------------------------------------------- |
| Laravel             | 13.x    | Backend framework                             |
| PHP                 | ^8.2    | Enums, typed properties, readonly             |
| Livewire            | 4.x     | Reactive UI — contact form, language switcher |
| Spatie Permission   | 6.x     | Admin role management                         |
| Spatie Translatable | 6.x     | AR/EN translations on models                  |
| Spatie Sitemap      | 8.x     | XML sitemap generation                        |
| Tailwind CSS        | 4.x     | Styling via `@tailwindcss/vite`               |
| Vite                | 6.x     | Asset bundling (`laravel-vite-plugin ^1.0`)   |
| Alpine.js           | 3.x     | Bundled with Livewire 4                       |

### Install

```bash
composer create-project laravel/laravel:^13.0 coolq8
cd coolq8

composer require livewire/livewire:^4.0
composer require spatie/laravel-permission:^6.0
composer require spatie/laravel-translatable
composer require spatie/laravel-sitemap

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

npm install   # if SSL error: npm config set strict-ssl false first
npm run build

php artisan migrate
```

> **PHP note:** `composer.json` uses `"php": "^8.2"` and `vendor/composer/platform_check.php`
> checks `PHP_VERSION_ID >= 80200`. Avast Firewall intercepts HTTPS — use
> `npm config set strict-ssl false` for npm and `COMPOSER_DISABLE_TLS=1` for Composer
> if SSL errors appear.

> **Vite note:** `vite.config.js` uses `laravel-vite-plugin ^1.0` — the `fonts` import
> (`laravel-vite-plugin/fonts`) does **not** exist in this version and must not be used.

---

## 3. Database Schema

### 3.1 Enums

```php
// app/Enums/ServiceStatus.php
enum ServiceStatus: string {
    case Active   = 'active';
    case Inactive = 'inactive';
}

// app/Enums/ContactStatus.php
enum ContactStatus: string {
    case New     = 'new';
    case Read    = 'read';
    case Replied = 'replied';
}
```

### 3.2 Full Migration Order (20 tables)

| Migration file                                   | Table                    | Depends on              |
| ------------------------------------------------ | ------------------------ | ----------------------- |
| `0001_01_01_000000`                              | `users`                  | —                       |
| `0001_01_01_000001`                              | `cache`                  | —                       |
| `0001_01_01_000002`                              | `jobs`                   | —                       |
| `2025_01_01_000001_create_pillars_table`         | `pillars`                | —                       |
| `2025_01_01_000002_create_clusters_table`        | `clusters`               | `pillars`               |
| `2025_01_01_000010_create_services_table`        | `services`               | `clusters`              |
| `2025_01_01_000011_create_locations_table`       | `locations`              | —                       |
| `2025_01_01_000012_create_testimonials_table`    | `testimonials`           | `locations`             |
| `2025_01_01_000013_create_contacts_table`        | `contacts`               | `services`, `locations` |
| `2025_01_01_000014_create_site_settings_table`   | `site_settings`          | —                       |
| `2025_01_01_000015_create_service_location_pages_table` | `service_location_pages` | `services`, `locations` |
| `2025_01_01_000016_create_keywords_table`        | `keywords`               | —                       |
| `2025_01_01_000017_create_page_keywords_table`   | `page_keywords`          | `keywords`              |
| `2025_01_01_000018_create_internal_links_table`  | `internal_links`         | —                       |
| `2025_01_01_000019_create_faqs_table`            | `faqs`                   | —                       |
| `2025_01_01_000020_create_page_faqs_table`       | `page_faqs`              | `faqs`                  |
| `2025_01_01_000021_create_redirects_table`       | `redirects`              | —                       |
| `2025_01_01_000022_create_seo_audits_table`      | `seo_audits`             | —                       |
| `2026_xx_xx_create_permission_tables`            | 5 Spatie tables          | `users`                 |

### 3.3 `pillars` — Top-level SEO hubs

```php
Schema::create('pillars', function (Blueprint $table) {
    $table->id();
    $table->json('title');               // {"ar":"خدمات التكييف في الكويت","en":"AC Services in Kuwait"}
    $table->json('slug');                // {"ar":"خدمات-تكييف-الكويت","en":"ac-services-kuwait"}
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('h1');
    $table->json('intro')->nullable();
    $table->json('content')->nullable();
    $table->json('canonical_url')->nullable();
    $table->string('status')->default('active'); // active | draft | archived
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

### 3.4 `clusters` — Service category groups

```php
Schema::create('clusters', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pillar_id')->constrained()->cascadeOnDelete();
    $table->json('title');               // {"ar":"إصلاح التكييف","en":"AC Repair"}
    $table->json('slug');
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('h1');
    $table->json('intro')->nullable();
    $table->json('content')->nullable();
    $table->json('canonical_url')->nullable();
    // informational | commercial | transactional | navigational
    $table->string('search_intent')->default('commercial');
    $table->string('status')->default('active');
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

### 3.5 `services` — Individual service pages

```php
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cluster_id')->constrained()->cascadeOnDelete();
    $table->json('title');               // {"ar":"إصلاح مكيف سبليت","en":"Split AC Repair"}
    $table->json('slug');
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('h1');
    $table->json('intro')->nullable();
    $table->json('content')->nullable();
    $table->json('canonical_url')->nullable();
    // split | central | window | cassette | portable | duct | general
    $table->string('service_type')->default('general');
    $table->unsignedInteger('price_from')->nullable();
    $table->unsignedInteger('price_to')->nullable();
    $table->json('faq_schema')->nullable(); // raw FAQ JSON-LD per locale
    $table->string('status')->default('active');
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

### 3.6 `locations` — Kuwait areas (replaces old `areas` table)

```php
Schema::create('locations', function (Blueprint $table) {
    $table->id();
    $table->json('name');                // {"ar":"السالمية","en":"Salmiya"}
    $table->json('slug');                // {"ar":"سالمية","en":"salmiya"}
    // capital | hawalli | farwaniya | ahmadi | jahra | mubarak_al_kabeer
    $table->string('governorate')->default('hawalli');
    $table->json('description')->nullable();
    $table->boolean('is_active')->default(true);
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

### 3.7 `service_location_pages` — Local SEO pages (most important table)

Each row = one unique service+location combination. Every field must contain
**original, location-specific content** — Google will penalise pages that only
swap the location name.

```php
Schema::create('service_location_pages', function (Blueprint $table) {
    $table->id();
    $table->foreignId('service_id')->constrained()->cascadeOnDelete();
    $table->foreignId('location_id')->constrained()->cascadeOnDelete();
    $table->json('title');               // {"ar":"إصلاح تكييف السالمية","en":"AC Repair in Salmiya"}
    $table->json('slug');
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('h1');
    $table->json('intro')->nullable();
    $table->json('unique_local_content')->nullable();
    $table->json('local_problem')->nullable();   // "In Salmiya, humidity causes..."
    $table->json('local_solution')->nullable();  // "Our Salmiya team..."
    $table->json('cta_text')->nullable();
    $table->json('canonical_url')->nullable();
    $table->boolean('noindex')->default(false);  // protect thin-content pages
    $table->string('status')->default('active');
    $table->timestamps();

    $table->unique(['service_id', 'location_id']); // one page per combo
});
```

### 3.8 `keywords` — Keyword pool

```php
Schema::create('keywords', function (Blueprint $table) {
    $table->id();
    $table->json('keyword');             // {"ar":"إصلاح تكييف","en":"ac repair"}
    // informational | commercial | transactional | navigational
    $table->string('intent')->default('commercial');
    // pillar | cluster | service | location | blog
    $table->string('type')->default('service');
    $table->unsignedInteger('search_volume')->nullable();
    $table->unsignedTinyInteger('difficulty')->nullable(); // 0–100
    // active | paused | cannibalized
    $table->string('status')->default('active');
    $table->timestamps();
});
```

### 3.9 `page_keywords` — Keyword → page assignments

One primary keyword must belong to **exactly one page**. The unique constraint
on `(keyword_id, is_primary)` enforces this at the database level and prevents
keyword cannibalization.

```php
Schema::create('page_keywords', function (Blueprint $table) {
    $table->id();
    $table->foreignId('keyword_id')->constrained()->cascadeOnDelete();
    // pillar | cluster | service | service_location_page
    $table->string('page_type');
    $table->unsignedBigInteger('page_id');
    $table->boolean('is_primary')->default(false);
    $table->timestamps();

    $table->index(['page_type', 'page_id']);
    $table->unique(['keyword_id', 'is_primary'], 'unique_primary_keyword');
});
```

### 3.10 `internal_links` — Automated SEO linking

```php
Schema::create('internal_links', function (Blueprint $table) {
    $table->id();
    $table->string('source_type');       // pillar | cluster | service | service_location_page
    $table->unsignedBigInteger('source_id');
    $table->string('target_type');
    $table->unsignedBigInteger('target_id');
    $table->json('anchor_text');         // {"ar":"إصلاح الضاغط","en":"AC Compressor Repair"}
    $table->timestamps();

    $table->index(['source_type', 'source_id']);
    $table->index(['target_type', 'target_id']);
    $table->unique(['source_type', 'source_id', 'target_type', 'target_id'], 'unique_link_pair');
});
```

### 3.11 `faqs` — Reusable FAQ bank

```php
Schema::create('faqs', function (Blueprint $table) {
    $table->id();
    $table->json('question');
    $table->json('answer');
    // repair | cleaning | installation | spare_parts | general
    $table->string('category')->default('general');
    $table->string('status')->default('active');
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

### 3.12 `page_faqs` — FAQ → page assignments

```php
Schema::create('page_faqs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('faq_id')->constrained()->cascadeOnDelete();
    $table->string('page_type');        // pillar | cluster | service | service_location_page
    $table->unsignedBigInteger('page_id');
    $table->unsignedSmallInteger('sort_order')->default(0);
    $table->timestamps();

    $table->index(['page_type', 'page_id']);
    $table->unique(['faq_id', 'page_type', 'page_id'], 'unique_faq_per_page');
});
```

### 3.13 `redirects` — URL redirect management

Fire whenever a slug changes. Essential for preserving SEO authority.

```php
Schema::create('redirects', function (Blueprint $table) {
    $table->id();
    $table->string('old_url')->unique();  // /ac-repair/salmia
    $table->string('new_url');            // /ac-repair/salmiya
    $table->unsignedSmallInteger('status_code')->default(301); // 301 | 302
    $table->timestamps();

    $table->index('new_url');
});
```

### 3.14 `seo_audits` — Duplication detector

Catches: duplicate meta titles, duplicate descriptions, similar content,
keyword cannibalization. Run after any bulk content generation.

```php
Schema::create('seo_audits', function (Blueprint $table) {
    $table->id();
    $table->string('page_type');
    $table->unsignedBigInteger('page_id');
    $table->json('primary_keyword')->nullable();
    $table->string('meta_title_hash', 32)->nullable();      // MD5
    $table->string('meta_description_hash', 32)->nullable();
    $table->string('content_hash', 32)->nullable();
    $table->decimal('similarity_score', 4, 2)->nullable();  // 0.00–1.00
    $table->string('duplicate_of_page_type')->nullable();
    $table->unsignedBigInteger('duplicate_of_page_id')->nullable();
    $table->timestamp('audited_at');
    $table->timestamps();

    $table->index(['page_type', 'page_id']);
    $table->index('meta_title_hash');
    $table->index('content_hash');
});
```

### 3.15 `testimonials`

```php
Schema::create('testimonials', function (Blueprint $table) {
    $table->id();
    $table->json('client_name');
    $table->json('body');
    $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
    $table->unsignedTinyInteger('rating')->default(5);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### 3.16 `contacts`

```php
Schema::create('contacts', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('phone');
    $table->string('email')->nullable();
    $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
    $table->text('message')->nullable();
    $table->string('status')->default('new');   // ContactStatus enum
    $table->string('locale')->default('ar');
    $table->string('ip_address')->nullable();
    $table->timestamps();
});
```

### 3.17 `site_settings` — Key/value config store

```php
Schema::create('site_settings', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();
    $table->text('value')->nullable();
    $table->string('group')->default('general');
    $table->timestamps();
});
```

**Settings to seed:**

| Key                 | Group   | Example Value                     |
| ------------------- | ------- | --------------------------------- |
| `whatsapp_number`   | contact | `96512345678` (no + sign)         |
| `phone_number`      | contact | `+965 1234 5678`                  |
| `email`             | contact | `info@coolq8.com`                 |
| `google_maps_embed` | contact | `https://maps.google.com/...`     |
| `instagram_url`     | social  | `https://instagram.com/coolq8`    |
| `snapchat_url`      | social  | `https://snapchat.com/add/coolq8` |
| `tiktok_url`        | social  | `https://tiktok.com/@coolq8`      |
| `site_name_en`      | seo     | `CoolQ8 — AC Services Kuwait`     |
| `site_name_ar`      | seo     | `كول كيوت — خدمات تكييف الكويت`   |
| `default_meta_en`   | seo     | `AC Repair & Installation Kuwait` |
| `default_meta_ar`   | seo     | `تركيب وإصلاح تكييف الكويت`       |

---

## 4. Eloquent Models

> All content models use `spatie/laravel-translatable` (`HasTranslations`).
> The `resolveRouteBinding()` method reads `request()->segment(1)` to detect locale
> **before** middleware runs (route model binding fires before route middleware).

### 4.1 Pillar

```php
use Spatie\Translatable\HasTranslations;

class Pillar extends Model
{
    use HasTranslations;
    public array $translatable = ['title', 'slug', 'meta_title', 'meta_description', 'h1', 'intro', 'content', 'canonical_url'];

    public function clusters() { return $this->hasMany(Cluster::class); }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        $segment = request()->segment(1);
        $locale = in_array($segment, config('app.available_locales')) ? $segment : app()->getLocale();
        return static::whereJsonContains("slug->{$locale}", $value)->firstOrFail();
    }
}
```

### 4.2 Cluster

```php
class Cluster extends Model
{
    use HasTranslations;
    public array $translatable = ['title', 'slug', 'meta_title', 'meta_description', 'h1', 'intro', 'content', 'canonical_url'];

    public function pillar()   { return $this->belongsTo(Pillar::class); }
    public function services() { return $this->hasMany(Service::class); }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        $segment = request()->segment(1);
        $locale = in_array($segment, config('app.available_locales')) ? $segment : app()->getLocale();
        return static::whereJsonContains("slug->{$locale}", $value)->firstOrFail();
    }
}
```

### 4.3 Service

```php
class Service extends Model
{
    use HasTranslations;
    public array $translatable = ['title', 'slug', 'meta_title', 'meta_description', 'h1', 'intro', 'content', 'canonical_url', 'faq_schema'];

    protected function casts(): array
    {
        return ['status' => ServiceStatus::class];
    }

    public function cluster()               { return $this->belongsTo(Cluster::class); }
    public function locationPages()         { return $this->hasMany(ServiceLocationPage::class); }
    public function contacts()              { return $this->hasMany(Contact::class); }

    public function scopeActive($query)
    {
        return $query->where('status', ServiceStatus::Active)->orderBy('sort_order');
    }

    // Must read from request segment — route model binding fires before SetLocale middleware
    public function resolveRouteBinding($value, $field = null): ?static
    {
        $segment = request()->segment(1);
        $locale = in_array($segment, config('app.available_locales')) ? $segment : app()->getLocale();
        return static::whereJsonContains("slug->{$locale}", $value)->firstOrFail();
    }
}
```

### 4.4 Location (replaces old Area model)

```php
class Location extends Model
{
    use HasTranslations;
    public array $translatable = ['name', 'slug', 'description'];

    public function testimonials()   { return $this->hasMany(Testimonial::class); }
    public function contacts()       { return $this->hasMany(Contact::class); }
    public function servicePages()   { return $this->hasMany(ServiceLocationPage::class); }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        $segment = request()->segment(1);
        $locale = in_array($segment, config('app.available_locales')) ? $segment : app()->getLocale();
        return static::whereJsonContains("slug->{$locale}", $value)->firstOrFail();
    }
}
```

### 4.5 ServiceLocationPage

```php
class ServiceLocationPage extends Model
{
    use HasTranslations;
    public array $translatable = [
        'title', 'slug', 'meta_title', 'meta_description', 'h1',
        'intro', 'unique_local_content', 'local_problem', 'local_solution',
        'cta_text', 'canonical_url',
    ];

    public function service()  { return $this->belongsTo(Service::class); }
    public function location() { return $this->belongsTo(Location::class); }
    public function faqs()     { return $this->hasManyThrough(Faq::class, PageFaq::class, 'page_id', 'id', 'id', 'faq_id'); }
}
```

### 4.6 Keyword

```php
class Keyword extends Model
{
    use HasTranslations;
    public array $translatable = ['keyword'];

    public function pageKeywords() { return $this->hasMany(PageKeyword::class); }
}
```

### 4.7 Faq

```php
class Faq extends Model
{
    use HasTranslations;
    public array $translatable = ['question', 'answer'];
}
```

### 4.8 Contact

```php
class Contact extends Model
{
    protected $fillable = [
        'name', 'phone', 'email', 'service_id', 'location_id',
        'message', 'status', 'locale', 'ip_address',
    ];

    protected function casts(): array
    {
        return ['status' => ContactStatus::class];
    }

    public function service()  { return $this->belongsTo(Service::class); }
    public function location() { return $this->belongsTo(Location::class); }
}
```

### 4.9 Testimonial

```php
class Testimonial extends Model
{
    use HasTranslations;
    public array $translatable = ['client_name', 'body'];

    protected $fillable = ['client_name', 'body', 'location_id', 'rating', 'is_active'];

    public function location() { return $this->belongsTo(Location::class); }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->latest();
    }
}
```

### 4.10 SiteSetting

```php
class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

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

### 4.11 User (with HasRoles)

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    protected $fillable = ['name', 'email', 'password'];

    protected function casts(): array
    {
        return [
            'password'          => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }
}
```

---

## 5. Bilingual Setup (AR / EN)

### 5.1 config/app.php

```php
'locale'            => env('APP_LOCALE', 'ar'),
'fallback_locale'   => env('APP_FALLBACK_LOCALE', 'en'),
'available_locales' => ['ar', 'en'],
```

### 5.2 .env

```
APP_LOCALE=ar
APP_FALLBACK_LOCALE=en
```

### 5.3 SetLocale Middleware

```php
// app/Http/Middleware/SetLocale.php
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $segment = $request->segment(1);

        if (in_array($segment, config('app.available_locales'))) {
            app()->setLocale($segment);
            session(['locale' => $segment]);
        } else {
            app()->setLocale(session('locale', 'ar'));
        }

        return $next($request);
    }
}
```

> **Important:** `resolveRouteBinding()` fires **before** this middleware.
> Models must call `request()->segment(1)` directly — not `app()->getLocale()` —
> to detect the locale from the URL.

### 5.4 bootstrap/app.php

```php
$middleware->alias([
    'locale'             => \App\Http\Middleware\SetLocale::class,
    'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
    'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
]);
```

### 5.5 Translation Files

```php
// lang/ar/site.php
return [
    'nav' => [
        'home'     => 'الرئيسية',
        'services' => 'خدماتنا',
        'areas'    => 'مناطق الخدمة',
        'about'    => 'من نحن',
        'contact'  => 'تواصل معنا',
    ],
    'hero' => [
        'title'        => 'خبراء تكييف الهواء في الكويت',
        'subtitle'     => 'تركيب · إصلاح · تنظيف · شحن غاز · طوارئ 24/7',
        'cta_whatsapp' => 'تواصل واتساب',
        'cta_call'     => 'اتصل الآن',
    ],
    'contact' => [
        'title'    => 'تواصل معنا',
        'name'     => 'الاسم',
        'phone'    => 'رقم الهاتف',
        'service'  => 'الخدمة المطلوبة',
        'area'     => 'المنطقة',
        'message'  => 'رسالتك',
        'send'     => 'إرسال',
        'success'  => 'تم إرسال رسالتك! سنتواصل معك قريباً.',
        'whatsapp' => 'أو تواصل عبر واتساب',
    ],
    'emergency' => [
        'badge' => 'خدمة طوارئ 24/7',
        'text'  => 'متاحون على مدار الساعة طوال أيام الأسبوع',
    ],
];
```

```php
// lang/en/site.php
return [
    'nav' => [
        'home'     => 'Home',
        'services' => 'Services',
        'areas'    => 'Service Areas',
        'about'    => 'About Us',
        'contact'  => 'Contact',
    ],
    'hero' => [
        'title'        => "Kuwait's AC Experts",
        'subtitle'     => 'Installation · Repair · Cleaning · Gas Refill · 24/7 Emergency',
        'cta_whatsapp' => 'WhatsApp Us',
        'cta_call'     => 'Call Now',
    ],
    'contact' => [
        'title'    => 'Contact Us',
        'name'     => 'Full Name',
        'phone'    => 'Phone Number',
        'service'  => 'Service Needed',
        'area'     => 'Your Area',
        'message'  => 'Message',
        'send'     => 'Send Message',
        'success'  => 'Message sent! We will contact you shortly.',
        'whatsapp' => 'Or contact via WhatsApp',
    ],
    'emergency' => [
        'badge' => '24/7 Emergency Service',
        'text'  => 'Available around the clock, 7 days a week',
    ],
];
```

---

## 6. Routes

```php
// routes/web.php

Route::middleware('locale')->group(function () {

    // Arabic — no prefix (default)
    Route::get('/',                        [HomeController::class, 'index'])->name('home');
    Route::get('/{pillar}',                [PillarController::class, 'show'])->name('pillars.show');
    Route::get('/{cluster}',               [ClusterController::class, 'show'])->name('clusters.show');
    Route::get('/{cluster}/{service}',     [ServiceController::class, 'show'])->name('services.show');
    Route::get('/{cluster}/{service}/{location}', [ServiceLocationController::class, 'show'])->name('service_location.show');
    Route::get('/locations',               [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/{location}',    [LocationController::class, 'show'])->name('locations.show');
    Route::get('/about',                   [AboutController::class, 'index'])->name('about');
    Route::get('/contact',                 [ContactController::class, 'index'])->name('contact');
    Route::get('/privacy',                 [PageController::class, 'privacy'])->name('privacy');

    // English — /en/ prefix
    Route::prefix('en')->name('en.')->group(function () {
        Route::get('/',                        [HomeController::class, 'index'])->name('home');
        Route::get('/{pillar}',                [PillarController::class, 'show'])->name('pillars.show');
        Route::get('/{cluster}',               [ClusterController::class, 'show'])->name('clusters.show');
        Route::get('/{cluster}/{service}',     [ServiceController::class, 'show'])->name('services.show');
        Route::get('/{cluster}/{service}/{location}', [ServiceLocationController::class, 'show'])->name('service_location.show');
        Route::get('/locations',               [LocationController::class, 'index'])->name('locations.index');
        Route::get('/locations/{location}',    [LocationController::class, 'show'])->name('locations.show');
        Route::get('/about',                   [AboutController::class, 'index'])->name('about');
        Route::get('/contact',                 [ContactController::class, 'index'])->name('contact');
    });
});

// Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/',               \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/contacts',       \App\Livewire\Admin\Contacts\Index::class)->name('admin.contacts.index');
    Route::get('/pillars',        \App\Livewire\Admin\Pillars\Index::class)->name('admin.pillars.index');
    Route::get('/clusters',       \App\Livewire\Admin\Clusters\Index::class)->name('admin.clusters.index');
    Route::get('/services',       \App\Livewire\Admin\Services\Index::class)->name('admin.services.index');
    Route::get('/services/create',          \App\Livewire\Admin\Services\Form::class)->name('admin.services.create');
    Route::get('/services/{service}/edit',  \App\Livewire\Admin\Services\Form::class)->name('admin.services.edit');
    Route::get('/locations',      \App\Livewire\Admin\Locations\Index::class)->name('admin.locations.index');
    Route::get('/service-pages',  \App\Livewire\Admin\ServiceLocationPages\Index::class)->name('admin.service_location.index');
    Route::get('/keywords',       \App\Livewire\Admin\Keywords\Index::class)->name('admin.keywords.index');
    Route::get('/faqs',           \App\Livewire\Admin\Faqs\Index::class)->name('admin.faqs.index');
    Route::get('/redirects',      \App\Livewire\Admin\Redirects\Index::class)->name('admin.redirects.index');
    Route::get('/seo-audit',      \App\Livewire\Admin\SeoAudit\Index::class)->name('admin.seo_audit.index');
    Route::get('/testimonials',   \App\Livewire\Admin\Testimonials\Index::class)->name('admin.testimonials.index');
    Route::get('/settings',       \App\Livewire\Admin\Settings\Index::class)->name('admin.settings');
});
```

> **URL examples:**
> - `/ac-repair` → Cluster page
> - `/ac-repair/split-ac-repair` → Service page
> - `/ac-repair/split-ac-repair/salmiya` → Local SEO page
> - `/en/ac-repair/split-ac-repair/salmiya` → English version

---

## 7. Livewire 4 Components

### 7.1 ContactForm

```php
// app/Livewire/ContactForm.php
class ContactForm extends Component
{
    #[Validate('required|string|min:2|max:100')]
    public string $name = '';

    #[Validate('required|regex:/^[0-9+\s]{8,15}$/')]
    public string $phone = '';

    #[Validate('nullable|email')]
    public string $email = '';

    #[Validate('nullable|exists:services,id')]
    public string $service_id = '';

    #[Validate('nullable|exists:locations,id')]
    public string $location_id = '';

    #[Validate('nullable|string|max:500')]
    public string $message = '';

    public bool $submitted = false;

    public function send(): void
    {
        $this->validate();

        Contact::create([
            'name'        => $this->name,
            'phone'       => $this->phone,
            'email'       => $this->email ?: null,
            'service_id'  => $this->service_id ?: null,
            'location_id' => $this->location_id ?: null,
            'message'     => $this->message ?: null,
            'locale'      => app()->getLocale(),
            'ip_address'  => request()->ip(),
            'status'      => ContactStatus::New,
        ]);

        $this->submitted = true;
        $this->reset(['name', 'phone', 'email', 'service_id', 'location_id', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form', [
            'services'  => Service::active()->get(),
            'locations' => Location::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
```

### 7.2 LanguageSwitcher

```php
class LanguageSwitcher extends Component
{
    public function switchTo(string $locale): void
    {
        if (!in_array($locale, config('app.available_locales'))) {
            return;
        }
        session(['locale' => $locale]);
        $this->redirect(request()->header('Referer', '/'), navigate: true);
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
```

### 7.3 Admin Contacts Index

```php
class Index extends Component
{
    use WithPagination;

    #[Url] public string $status = '';
    #[Url] public string $locale = '';

    #[Computed]
    public function contacts()
    {
        return Contact::with(['service', 'location'])
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->when($this->locale, fn($q) => $q->where('locale', $this->locale))
            ->latest()
            ->paginate(20);
    }

    public function markRead(Contact $contact): void
    {
        if ($contact->status !== ContactStatus::Read) {
            $contact->update(['status' => ContactStatus::Read]);
        }
    }

    public function render()
    {
        return view('livewire.admin.contacts.index')->layout('layouts.admin');
    }
}
```

---

## 8. Controllers (Public)

### HomeController

```php
public function index()
{
    return view('home', [
        'services'     => Service::with('cluster')->active()->get(),
        'locations'    => Location::where('is_active', true)->orderBy('sort_order')->get(),
        'testimonials' => Testimonial::active()->limit(6)->get(),
    ]);
}
```

### ClusterController

```php
public function show(Cluster $cluster)
{
    return view('clusters.show', [
        'cluster'  => $cluster->load('pillar', 'services'),
        'services' => $cluster->services()->active()->get(),
    ]);
}
```

### ServiceController

```php
public function show(Cluster $cluster, Service $service)
{
    return view('services.show', [
        'service'       => $service->load('cluster'),
        'locationPages' => $service->locationPages()->where('status', 'active')->with('location')->get(),
        'faqs'          => PageFaq::with('faq')->where('page_type', 'service')->where('page_id', $service->id)->orderBy('sort_order')->get(),
    ]);
}
```

### ServiceLocationController

```php
public function show(Cluster $cluster, Service $service, Location $location)
{
    $page = ServiceLocationPage::where('service_id', $service->id)
        ->where('location_id', $location->id)
        ->where('status', 'active')
        ->firstOrFail();

    return view('service-location.show', [
        'page'     => $page,
        'service'  => $service,
        'location' => $location,
        'faqs'     => PageFaq::with('faq')->where('page_type', 'service_location_page')->where('page_id', $page->id)->orderBy('sort_order')->get(),
    ]);
}
```

### LocationController

```php
public function show(Location $location)
{
    return view('locations.show', [
        'location'     => $location,
        'servicePages' => $location->servicePages()->where('status', 'active')->with('service.cluster')->get(),
        'testimonials' => $location->testimonials()->active()->limit(4)->get(),
    ]);
}
```

---

## 9. SEO Strategy

### 9.1 Anti-duplication Rules (enforced at DB level)

Every page must have:

| Field           | Rule                                                  |
| --------------- | ----------------------------------------------------- |
| Primary keyword | One keyword → one page only (`unique_primary_keyword`) |
| Search intent   | Unique per page type                                  |
| H1              | Unique across all pages                               |
| Meta title      | Unique (detected by `seo_audits.meta_title_hash`)     |
| Intro           | Original content, not a template swap                 |
| Content         | Location pages need unique local angle                |

### 9.2 `noindex` Protection

Set `noindex = true` on `service_location_pages` that have thin content. The
controller should inject `<meta name="robots" content="noindex">` when this flag
is set.

### 9.3 Sitemap

Generated by `spatie/laravel-sitemap`. Include all active:
- Pillars, Clusters, Services, ServiceLocationPages, Locations.
- Exclude `noindex = true` pages.

### 9.4 App Layout Head

```blade
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <title>@yield('meta_title')</title>
    <meta name="description" content="@yield('meta_description')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <link rel="alternate" hreflang="ar" href="{{ url('/') }}">
    <link rel="alternate" hreflang="en" href="{{ url('/en') }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    <meta property="og:locale" content="{{ app()->getLocale() === 'ar' ? 'ar_KW' : 'en_US' }}">
    @yield('schema_markup')

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
```

### 9.5 LocalBusiness JSON-LD (home page)

```blade
@section('schema_markup')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "HVACBusiness",
  "name": "{{ \App\Models\SiteSetting::get('site_name_' . app()->getLocale()) }}",
  "telephone": "{{ \App\Models\SiteSetting::get('phone_number') }}",
  "address": { "@@type": "PostalAddress", "addressCountry": "KW" },
  "areaServed": "Kuwait",
  "openingHours": "Mo-Su 00:00-24:00"
}
</script>
@endsection
```

> **Note:** Use `@@context` and `@@type` in Blade — the `@@` escape renders as `@`
> and prevents Blade treating `@context`/`@type` as directives.

---

## 10. WhatsApp Integration

### 10.1 WhatsApp Helper

```php
// app/Helpers/WhatsAppHelper.php
class WhatsAppHelper
{
    public static function url(string $message = ''): string
    {
        $number  = SiteSetting::get('whatsapp_number');
        $default = app()->getLocale() === 'ar'
            ? 'مرحباً، أريد الاستفسار عن خدمات التكييف'
            : 'Hello, I need AC service assistance';

        return 'https://wa.me/' . $number . '?text=' . urlencode($message ?: $default);
    }
}
```

### 10.2 Floating Button (in layout)

```blade
<a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
   class="fixed bottom-6 {{ app()->getLocale() === 'ar' ? 'left-6' : 'right-6' }}
          z-50 bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-xl transition">
    {{-- WhatsApp SVG --}}
</a>
```

> Button uses `left-6` for Arabic (RTL), `right-6` for English (LTR).

---

## 11. Admin Panel

### 11.1 Spatie Permissions Seeder

```php
$permissions = [
    'contacts.view', 'services.manage', 'locations.manage',
    'testimonials.manage', 'settings.manage',
    'keywords.manage', 'faqs.manage', 'redirects.manage', 'seo_audit.view',
];

foreach ($permissions as $perm) {
    Permission::firstOrCreate(['name' => $perm]);
}

Role::firstOrCreate(['name' => 'admin'])->syncPermissions(Permission::all());

$admin = User::firstOrCreate(
    ['email' => 'admin@coolq8.com'],
    ['name' => 'Admin', 'password' => bcrypt('change_this_password_immediately')]
);
$admin->assignRole('admin');
```

---

## 12. Authentication & Authorization

### Stack
- **Authentication**: Laravel session-based auth (`web` guard)
- **Authorization / RBAC**: Spatie Laravel-Permission `^6.x`

---

### Auth Controllers

**Directory**: `app/Http/Controllers/Auth/`

#### LoginController
- `showLoginForm()` — redirects already-authenticated users to `/admin`
- `login()` — validates email + password, regenerates session on success, supports remember-me
- `logout()` — invalidates session, regenerates CSRF token, redirects to login

#### RegisterController
- `register()` — validates name / unique email / password (min 8, confirmed), creates user, auto-logs in
- Newly registered users have **no role** — admin access requires `admin:make` command

---

### Roles & Permissions

#### Defined Permissions

| Permission | Description |
|---|---|
| `contacts.view` | View contact form submissions |
| `services.manage` | Create / edit / delete services |
| `locations.manage` | Create / edit / delete locations |
| `testimonials.manage` | Create / edit / delete testimonials |
| `settings.manage` | Update site settings |
| `keywords.manage` | Manage keyword pool |
| `faqs.manage` | Manage FAQ bank |
| `redirects.manage` | Manage URL redirects |
| `seo_audit.view` | View SEO audit results |

#### Defined Roles

| Role | Permissions |
|---|---|
| `admin` | All permissions above |

#### Seeder

**File**: `database/seeders/RolesAndPermissionsSeeder.php`

- Creates all permissions and the `admin` role
- Default admin: `admin@coolq8.com` / `change_this_password_immediately`
- Called automatically by `DatabaseSeeder`

---

### MakeAdmin Artisan Command

**File**: `app/Console/Commands/MakeAdmin.php`

```bash
php artisan admin:make {email} {--name=Admin} {--password=password}
```

- Creates the user if they don't exist, then assigns the `admin` role
- Only way to grant admin access — no UI promotion flow

---

### Middleware Aliases

Registered in `bootstrap/app.php`:

| Alias | Class |
|---|---|
| `role` | `Spatie\Permission\Middleware\RoleMiddleware` |
| `permission` | `Spatie\Permission\Middleware\PermissionMiddleware` |
| `role_or_permission` | `Spatie\Permission\Middleware\RoleOrPermissionMiddleware` |

---

### Route Protection

| Route group | Middleware |
|---|---|
| Public pages | `locale` |
| Login / Register | `locale`, `guest` |
| Logout | `locale`, `auth` |
| `/admin/*` | `auth`, `role:admin` |

---

### Auth Config (`config/auth.php`)

- Guard: `web` (session driver)
- Provider: Eloquent → `App\Models\User`
- Password reset token expiry: 60 minutes
- Password confirmation timeout: 3 hours

---

### Security Notes

- Passwords auto-hashed via Eloquent cast (`'password' => 'hashed'`)
- Session regenerated on login; fully invalidated + CSRF token regenerated on logout
- Role check enforced at middleware layer — no per-controller checks needed
- Spatie permission cache TTL: 24 hours (auto-flushed on role/permission changes)

---

## 13. File Structure

```
app/
├── Enums/
│   ├── ServiceStatus.php
│   ├── ContactStatus.php
│   └── PostStatus.php
├── Helpers/
│   └── WhatsAppHelper.php
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── PillarController.php
│   │   ├── ClusterController.php
│   │   ├── ServiceController.php
│   │   ├── ServiceLocationController.php
│   │   ├── LocationController.php
│   │   ├── AboutController.php
│   │   ├── ContactController.php
│   │   └── PageController.php
│   └── Middleware/
│       └── SetLocale.php
├── Livewire/
│   ├── ContactForm.php
│   ├── LanguageSwitcher.php
│   └── Admin/
│       ├── Dashboard.php
│       ├── Contacts/Index.php
│       ├── Pillars/{Index,Form}.php
│       ├── Clusters/{Index,Form}.php
│       ├── Services/{Index,Form}.php
│       ├── Locations/{Index,Form}.php
│       ├── ServiceLocationPages/{Index,Form}.php
│       ├── Keywords/Index.php
│       ├── Faqs/{Index,Form}.php
│       ├── Redirects/Index.php
│       ├── SeoAudit/Index.php
│       ├── Testimonials/Index.php
│       ├── Posts/{Index,Form}.php
│       └── Settings/Index.php
└── Models/
    ├── Pillar.php
    ├── Cluster.php
    ├── Service.php
    ├── ServiceLocationPage.php
    ├── Location.php
    ├── Keyword.php
    ├── PageKeyword.php
    ├── InternalLink.php
    ├── Faq.php
    ├── PageFaq.php
    ├── Redirect.php
    ├── SeoAudit.php
    ├── Contact.php
    ├── Testimonial.php
    ├── SiteSetting.php
    ├── Post.php
    └── User.php

database/migrations/
├── 2025_01_01_000001_create_pillars_table.php
├── 2025_01_01_000002_create_clusters_table.php
├── 2025_01_01_000010_create_services_table.php
├── 2025_01_01_000011_create_locations_table.php
├── 2025_01_01_000012_create_testimonials_table.php
├── 2025_01_01_000013_create_contacts_table.php
├── 2025_01_01_000014_create_site_settings_table.php
├── 2025_01_01_000015_create_service_location_pages_table.php
├── 2025_01_01_000016_create_keywords_table.php
├── 2025_01_01_000017_create_page_keywords_table.php
├── 2025_01_01_000018_create_internal_links_table.php
├── 2025_01_01_000019_create_faqs_table.php
├── 2025_01_01_000020_create_page_faqs_table.php
├── 2025_01_01_000021_create_redirects_table.php
├── 2025_01_01_000022_create_seo_audits_table.php
└── 2026_05_15_000001_create_posts_table.php
```

---

## 14. Setup Checklist

### Installation

- [ ] `composer create-project laravel/laravel:^13.0 coolq8`
- [ ] PHP 8.2+ in Laravel Herd
- [ ] `composer require livewire/livewire:^4.0`
- [ ] `composer require spatie/laravel-permission:^6.0`
- [ ] `composer require spatie/laravel-translatable`
- [ ] `composer require spatie/laravel-sitemap`
- [ ] `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`
- [ ] `npm config set strict-ssl false` (if Avast SSL error)
- [ ] `npm install && npm run build`

### Config

- [ ] `APP_LOCALE=ar` and `APP_FALLBACK_LOCALE=en` in `.env`
- [ ] `"php": "^8.2"` in `composer.json`
- [ ] `available_locales` array in `config/app.php`
- [ ] Register middleware aliases in `bootstrap/app.php`
- [ ] Remove `laravel-vite-plugin/fonts` import from `vite.config.js` (not in v1.x)

### Database

- [ ] `php artisan migrate:fresh`
- [ ] `php artisan db:seed --class=RolesAndPermissionsSeeder`
- [ ] `php artisan db:seed --class=SiteSettingsSeeder`
- [ ] Seed at least one Pillar → Cluster → Service chain before testing routes

### Models

- [ ] `HasTranslations` on: Pillar, Cluster, Service, ServiceLocationPage, Location, Keyword, Faq, Testimonial, **Post**
- [ ] `resolveRouteBinding()` reads `request()->segment(1)` (not `app()->getLocale()`) on all routable models
- [ ] `HasRoles` on User

### SEO

- [ ] Every `service_location_page` has unique intro + content (no template swaps)
- [ ] `noindex = true` on any thin-content location page
- [ ] Hreflang in layout for AR + EN
- [ ] `seo_audits` run after bulk content inserts to catch duplication
- [ ] `redirects` record written whenever any slug changes
- [ ] One primary keyword per page (`unique_primary_keyword` constraint)

### Kuwait-Specific

- [ ] WhatsApp number format: `96512345678` (no `+`) for `wa.me` links
- [ ] Floating WhatsApp button: `left-6` Arabic · `right-6` English
- [ ] Social priority: Instagram → Snapchat → TikTok
- [ ] Test RTL layout on mobile (majority of Kuwait users)
- [ ] Use `@@context` / `@@type` in JSON-LD blocks inside Blade (not `@context`)

---

## 15. Posts (Blog)

Posts are a **separate content type** from the SEO cluster hierarchy — they share the same translatable JSON pattern but have no `pillar_id` dependency.

### Why separate from clusters

- Clusters belong to the 4-level SEO architecture (Pillar → Cluster → Service → Location) and must not be mixed with editorial content.
- Posts need fields clusters don't have: `excerpt`, `featured_image`, `published_at`.
- Different status lifecycle: `draft` / `published` vs cluster's `active` / `draft` / `archived`.

---

### PostStatus Enum

**File**: `app/Enums/PostStatus.php`

```php
enum PostStatus: string {
    case Draft     = 'draft';
    case Published = 'published';
}
```

---

### Migration

**File**: `database/migrations/2026_05_15_000001_create_posts_table.php`

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->json('title');
    $table->json('slug');
    $table->json('meta_title')->nullable();
    $table->json('meta_description')->nullable();
    $table->json('h1');
    $table->json('excerpt')->nullable();
    $table->json('content')->nullable();
    $table->json('canonical_url')->nullable();
    $table->string('featured_image')->nullable();
    $table->string('status')->default('draft');   // draft | published
    $table->timestamp('published_at')->nullable();
    $table->unsignedInteger('sort_order')->default(0);
    $table->timestamps();
});
```

---

### Post Model

**File**: `app/Models/Post.php`

- Traits: `HasTranslations`
- Translatable: `title`, `slug`, `h1`, `excerpt`, `content`, `meta_title`, `meta_description`, `canonical_url`
- Casts: `status → PostStatus`, `published_at → datetime`
- `scopePublished()` — filters `status = published` AND `published_at IS NOT NULL`, orders by `published_at DESC`
- `resolveRouteBinding()` — reads `request()->segment(1)` for locale-aware slug lookup

---

### Admin Livewire Components

#### Posts\Index

**File**: `app/Livewire/Admin/Posts/Index.php`

- `#[Url] $status` — filters by `draft` / `published`
- `delete(Post $post)` — hard deletes the record
- Paginates 20 per page, ordered by `published_at DESC`

#### Posts\Form

**File**: `app/Livewire/Admin/Posts/Form.php`

- Handles both create and edit via optional `?Post $post` mount parameter
- Fields: `title_ar/en`, `slug_ar/en`, `h1_ar/en`, `excerpt_ar/en`, `content_ar/en`, `meta_title_ar/en`, `meta_desc_ar/en`, `featured_image`, `status`, `published_at`, `sort_order`
- Validation: `title_ar`, `title_en`, `slug_ar`, `slug_en` required; `status` must be `draft` or `published`
- Redirects to `admin.posts.index` on success

---

### Admin Routes

```php
Route::get('/posts',                 \App\Livewire\Admin\Posts\Index::class)->name('admin.posts.index');
Route::get('/posts/create',          \App\Livewire\Admin\Posts\Form::class)->name('admin.posts.create');
Route::get('/posts/{post}/edit',     \App\Livewire\Admin\Posts\Form::class)->name('admin.posts.edit');
```

All three are inside the `prefix('admin')->middleware(['auth', 'role:admin'])` group.

---

### Views

| View | Description |
|---|---|
| `livewire/admin/posts/index.blade.php` | Dark table — AR/EN title stacked, status badge, published_at, delete |
| `livewire/admin/posts/form.blade.php` | Sectioned form: title/slug, excerpt, content, SEO, publish settings |

Status filter uses pill-tab links (`الكل` / `منشور` / `مسودة`) matching the contacts locale filter pattern.

---

### Test Coverage

| File | Tests |
|---|---|
| `tests/Unit/PostModelTest.php` | 14 unit tests — creation, translatable fields, enum cast, `scopePublished`, `published_at` cast, `featured_image`, `sort_order`, update, delete |
| `tests/Feature/AdminPostsLivewireTest.php` | 21 feature tests — access control (guest/non-admin/admin), index render, empty state, status filter, delete, form render, pre-fill on edit, create, update, all validation rules |

---

---

## 16. Gallery

A **WebP-only** image gallery where every image has an Arabic and English caption. Images are stored on disk and managed via the admin panel.

### Why WebP only

- WebP is smaller than JPEG/PNG (30–50% saving) — critical for mobile-first Kuwait audience.
- Enforced at upload time with MIME + extension validation; non-WebP uploads are rejected.

---

### GalleryImage Model

**File**: `app/Models/GalleryImage.php`

- Traits: `HasTranslations`
- Translatable: `name` (the image caption in AR + EN)
- `$fillable`: `name` (json), `path` (string), `alt` (json), `sort_order` (int), `is_active` (bool)
- `getUrlAttribute()` — returns `Storage::url($this->path)`

```php
use Spatie\Translatable\HasTranslations;

class GalleryImage extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'alt'];

    protected $fillable = ['name', 'alt', 'path', 'sort_order', 'is_active'];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }
}
```

---

### Migration

**File**: `database/migrations/2026_05_15_000002_create_gallery_images_table.php`

```php
Schema::create('gallery_images', function (Blueprint $table) {
    $table->id();
    $table->json('name');                          // {"ar":"تركيب مكيف سبليت","en":"Split AC Installation"}
    $table->json('alt')->nullable();               // {"ar":"...","en":"..."} — SEO alt text
    $table->string('path');                        // storage/gallery/abc123.webp
    $table->unsignedInteger('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

---

### Upload Rules

| Rule | Detail |
|---|---|
| Accepted MIME | `image/webp` only |
| Accepted extension | `.webp` only |
| Max size | 2 MB per image |
| Storage disk | `public` — `storage/app/public/gallery/` |
| Filename | UUID (`Str::uuid() . '.webp'`) — prevents collisions and hides original name |
| Validation message | Arabic error shown when non-WebP uploaded |

---

### Admin Livewire Components

#### Gallery\Index

**File**: `app/Livewire/Admin/Gallery/Index.php`

- `#[Layout('layouts.admin')]`
- Lists all images ordered by `sort_order`
- `delete(GalleryImage $image)` — deletes DB record **and** the file from storage (`Storage::delete($image->path)`)
- Displays AR name, EN name, thumbnail preview, active badge

#### Gallery\Form

**File**: `app/Livewire/Admin/Gallery/Form.php`

- `#[Layout('layouts.admin')]`
- Properties: `$name_ar`, `$name_en`, `$alt_ar`, `$alt_en`, `$sort_order`, `$is_active`, `$image` (temporary upload)
- Uses `WithFileUploads` Livewire trait
- **Validation rules:**

```php
protected function rules(): array
{
    return [
        'name_ar' => 'required|string|max:200',
        'name_en' => 'required|string|max:200',
        'alt_ar'  => 'nullable|string|max:200',
        'alt_en'  => 'nullable|string|max:200',
        'image'   => $this->galleryImage
                        ? 'nullable|mimes:webp|max:2048'
                        : 'required|mimes:webp|max:2048',
        'sort_order' => 'integer|min:0',
    ];
}
```

- `save()` flow:
  1. Validate
  2. If new image uploaded: store to `gallery/` on `public` disk, get path
  3. If editing and no new image: keep existing path
  4. Build `name` and `alt` JSON from `_ar` / `_en` properties
  5. `GalleryImage::updateOrCreate(...)`, redirect to `admin.gallery.index`

- On edit: `mount(GalleryImage $galleryImage)` pre-fills all fields; `$this->alt_ar = $galleryImage->getTranslation('alt', 'ar') ?? ''`

```php
public function save(): void
{
    $this->validate();

    $path = $this->galleryImage?->path;

    if ($this->image) {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
        $path = $this->image->storeAs(
            'gallery',
            Str::uuid() . '.webp',
            'public'
        );
    }

    GalleryImage::updateOrCreate(
        ['id' => $this->galleryImage?->id],
        [
            'name'       => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'alt'        => ['ar' => $this->alt_ar,  'en' => $this->alt_en],
            'path'       => $path,
            'sort_order' => $this->sort_order,
            'is_active'  => $this->is_active,
        ]
    );

    session()->flash('success', 'تم حفظ الصورة بنجاح.');
    $this->redirect(route('admin.gallery.index'), navigate: true);
}
```

---

### Admin Routes

```php
Route::get('/gallery',                       \App\Livewire\Admin\Gallery\Index::class)->name('admin.gallery.index');
Route::get('/gallery/create',                \App\Livewire\Admin\Gallery\Form::class)->name('admin.gallery.create');
Route::get('/gallery/{galleryImage}/edit',   \App\Livewire\Admin\Gallery\Form::class)->name('admin.gallery.edit');
```

All three inside `prefix('admin')->middleware(['auth', 'role:admin'])`.

---

### Views

| View | Description |
|---|---|
| `livewire/admin/gallery/index.blade.php` | Grid/table — thumbnail, AR name, EN name, sort_order, active toggle, edit/delete |
| `livewire/admin/gallery/form.blade.php` | Upload input (accept=".webp"), AR + EN name fields, alt text fields, sort order, is_active toggle |

**Upload input:**

```blade
<input wire:model="image" type="file" accept=".webp"
    class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white">
@error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
```

**Current image preview (edit mode):**

```blade
@if($galleryImage?->path)
    <img src="{{ Storage::url($galleryImage->path) }}" alt=""
         class="h-24 w-24 object-cover rounded-lg border border-white/10 mt-2">
@endif
```

---

### Public Gallery Page

- Route: `GET /gallery` (Arabic) and `GET /en/gallery` (English)
- Controller: `GalleryController@index` — returns active images ordered by `sort_order`
- View: responsive CSS grid, each card shows the image + `$image->getTranslation('name', app()->getLocale())`
- `alt` attribute uses `$image->getTranslation('alt', app()->getLocale())` for SEO

---

### File Structure additions

```
app/
├── Livewire/Admin/
│   └── Gallery/{Index,Form}.php
└── Models/
    └── GalleryImage.php

database/migrations/
└── 2026_05_15_000002_create_gallery_images_table.php

storage/app/public/gallery/     ← uploaded WebP files (symlinked via php artisan storage:link)
```

---

### Setup Checklist additions

- [ ] `php artisan migrate` (adds `gallery_images` table)
- [ ] `php artisan storage:link` (makes `public/storage` symlink for serving images)
- [ ] Add gallery routes inside admin group
- [ ] Add **معرض الصور** link to admin sidebar nav

---

_CoolQ8 — Kuwait AC Services Website · Laravel 13 + Livewire 4 · AR/EN Bilingual · SEO Topic Architecture_
