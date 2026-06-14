<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Media extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'alt'];

    protected $fillable = [
        'name',
        'alt',
        'file_name',
        'path',
        'mime_type',
        'size',
        'sort_order',
    ];

    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }
}
