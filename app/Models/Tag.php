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
}
