<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trophet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_trophets', 'trophet_id', 'user_id');
    }
}
