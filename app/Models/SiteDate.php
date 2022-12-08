<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteDate extends Model
{
    use HasFactory;


    protected $guarded = [];

    /**
     * Get the site that owns the site date.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the reservations for the site date.
     */
    public function reservations()
    {
        return $this->hasMany(ReservationSite::class);
    }

    /**
     * Get the activites for the site date.
     */
    public function activites()
    {
        return $this->belongsToMany(Activite::class, 'reservations_activites');
    }

}
