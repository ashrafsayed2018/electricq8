<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Cluster extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = [
        'title', 'slug', 'content',
        'meta_title', 'meta_description', 'canonical_url',
    ];

    protected $fillable = [
        'pillar_id',
        'title', 'slug', 'content',
        'meta_title', 'meta_description', 'canonical_url',
        'search_intent', 'status', 'sort_order', 'image_url',
    ];

    public function pillar()
    {
        return $this->belongsTo(Pillar::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        // Admin routes bind by id (the route key field is explicitly 'id')
        if ($field === 'id' || is_numeric($value)) {
            return static::find($value) ?? abort(404);
        }

        // Public routes bind by bilingual slug
        foreach (config('app.available_locales') as $locale) {
            $model = static::whereJsonContains("slug->{$locale}", $value)->first();
            if ($model) return $model;
        }
        abort(404);
    }
}
