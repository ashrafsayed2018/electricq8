<?php

namespace App\Models;

use App\Enums\ContactStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'phone', 'email', 'service_id', 'location_id',
        'message', 'status', 'locale', 'ip_address',
    ];

    protected function casts(): array
    {
        return ['status' => ContactStatus::class];
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
