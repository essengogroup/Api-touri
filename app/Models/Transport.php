<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'price',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'integer',
    ];

    public function sites(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Site::class, 'transports_sites');
    }
}
