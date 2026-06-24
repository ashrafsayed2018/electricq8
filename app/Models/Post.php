<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = [
        'title', 'slug', 'h1', 'excerpt', 'content',
        'meta_title', 'meta_description', 'canonical_url',
    ];

    protected $fillable = [
        'title', 'slug', 'h1', 'excerpt', 'content',
        'meta_title', 'meta_description', 'canonical_url',
        'featured_image', 'status', 'published_at', 'sort_order', 'cluster_id',
    ];

    protected function casts(): array
    {
        return [
            'status'       => PostStatus::class,
            'published_at' => 'datetime',
        ];
    }

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', PostStatus::Published)
                     ->whereNotNull('published_at')
                     ->orderByDesc('published_at');
    }

    public function resolveRouteBinding($value, $field = null): ?static
    {
        if ($field === 'id' || is_numeric($value)) {
            return static::findOrFail($value);
        }

        foreach (config('app.available_locales') as $locale) {
            $model = static::whereJsonContains("slug->{$locale}", $value)->first();
            if ($model) return $model;
        }

        abort(404);
    }
}
