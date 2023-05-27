<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventTouri extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'date_event',
        'place',
        'price',
        'status',
    ];

    protected $casts = [
        'date_event' => 'date',
        'place' => 'integer',
        'price' => 'float',
    ];

    public function reservations(): HasMany
    {
        return $this->hasMany(ReservationEvent::class);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function shares(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Share::class, 'shareable');
    }
}
