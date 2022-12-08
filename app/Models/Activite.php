<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the sites for the activite.
     */
    public function sites()
    {
        return $this->belongsToMany(Site::class, 'activites_sites')->withPivot('type', 'price');
    }
}
