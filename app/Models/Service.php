<?php

namespace App\Models;

use App\Enums\ServiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = [
        'title', 'slug', 'h1', 'intro', 'content',
        'meta_title', 'meta_description', 'canonical_url', 'faq_schema',
    ];

    protected $fillable = [
        'cluster_id',
        'title', 'slug', 'h1', 'intro', 'content',
        'meta_title', 'meta_description', 'canonical_url', 'faq_schema',
        'service_type', 'price_from', 'price_to',
        'status', 'sort_order', 'image_url',
    ];

    protected function casts(): array
    {
        return ['status' => ServiceStatus::class];
    }

    public function icon(): string
    {
        return match($this->service_type) {
            'install'                                  => '🔧',
            'repair'                                   => '🛠️',
            'split', 'window', 'cassette', 'portable' => '🛠️',
            'central'                                  => '🔧',
            'duct'                                     => '💨',
            default                                    => match(true) {
                str_contains($this->title, 'تنظيف') || str_contains($this->title, 'Clean')     => '💧',
                str_contains($this->title, 'غاز')   || str_contains($this->title, 'Gas')       => '🫧',
                str_contains($this->title, 'طارئ')  || str_contains($this->title, 'Emergency') => '⚡',
                str_contains($this->title, 'تركيب') || str_contains($this->title, 'Install')   => '🔧',
                str_contains($this->title, 'إصلاح') || str_contains($this->title, 'Repair')   => '🛠️',
                default => '❄️',
            },
        };
    }

    public function locations(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'service_location_pages')
                    ->withPivot('id', 'status')
                    ->using(ServiceLocationPage::class);
    }

    public function serviceLocationPages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ServiceLocationPage::class);
    }

    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', ServiceStatus::Active)->orderBy('sort_order');
    }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        if ($field === 'id' || is_numeric($value)) {
            return static::findOrFail($value);
        }

        foreach (config('app.available_locales', ['en', 'ar']) as $locale) {
            $model = static::whereJsonContains("slug->{$locale}", $value)->first();
            if ($model) return $model;
        }

        abort(404);
    }
}
