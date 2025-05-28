<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'registered_count',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function confirmedRegistrationsCount()
    {
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    public function isFull()
    {
        return $this->capacity > 0 && $this->confirmedRegistrationsCount() >= $this->capacity;
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }
}
