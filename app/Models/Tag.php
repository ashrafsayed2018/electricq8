<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'slug', 'content'];

    protected $fillable = ['name', 'slug', 'content'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function clusters(): BelongsToMany
    {
        return $this->belongsToMany(Cluster::class);
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
