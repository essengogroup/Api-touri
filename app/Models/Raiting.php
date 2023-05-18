<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raiting extends Model
{
    use HasFactory;

    protected $fillable = [
        "value",
        "raitable_id",
        "raitable_type",
    ];

    protected $casts = [
        "value" => "integer",
    ];

    public function raitable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
