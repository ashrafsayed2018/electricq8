<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['client_name', 'body'];

    protected $fillable = ['client_name', 'body', 'location_id', 'rating', 'is_active'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->latest();
    }
}
