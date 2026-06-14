<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Area extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name', 'slug', 'description', 'meta_title', 'meta_description',
    ];

    protected $fillable = [
        'name', 'slug', 'description', 'meta_title',
        'meta_description', 'image', 'is_active', 'sort_order',
    ];

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
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
