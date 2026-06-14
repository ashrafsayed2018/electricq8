<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    use HasFactory, HasTranslations;

    public array $translatable = ['name', 'slug', 'description'];

    protected $fillable = [
        'name', 'slug', 'description',
        'governorate', 'is_active', 'sort_order',
    ];

    public function services(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'service_location_pages')
                    ->withPivot('id', 'status');
    }

    public function serviceLocationPages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ServiceLocationPage::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
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
