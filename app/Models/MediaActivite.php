<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaActivite extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'is_main',
        'site_id'
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'site_id' => 'integer',
    ];

    public function activite(): BelongsTo
    {
        return $this->belongsTo(Activite::class);
    }
}
