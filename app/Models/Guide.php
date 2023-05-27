<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
    ];

    public function raitings(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Raiting::class, 'raitable');
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function sites(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Site::class, 'guides_sites');
    }
}
