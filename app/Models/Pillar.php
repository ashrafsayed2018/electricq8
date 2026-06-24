<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Pillar extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = [
        'title', 'slug', 'content',
        'meta_title', 'meta_description', 'canonical_url',
    ];

    protected $fillable = [
        'title', 'slug', 'content',
        'meta_title', 'meta_description', 'canonical_url',
        'status', 'sort_order', 'image_url',
    ];

    public function clusters()
    {
        return $this->hasMany(Cluster::class);
    }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        if ($field === 'id' || is_numeric($value)) {
            return static::find($value) ?? abort(404);
        }
        foreach (config('app.available_locales') as $locale) {
            $model = static::whereJsonContains("slug->{$locale}", $value)->first();
            if ($model) return $model;
        }
        abort(404);
    }
}
