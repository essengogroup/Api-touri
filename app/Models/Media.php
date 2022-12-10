<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the site that owns the media.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
