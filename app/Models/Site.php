<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the departement that owns the site.
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * Get the activites for the site.
     */
    public function activites()
    {
        return $this->belongsToMany(Activite::class, 'activites_sites')->withPivot('type', 'price');
    }

    /**
     * Get the reservations for the site.
     */
    public function reservations()
    {
        return $this->hasMany(ReservationSite::class);
    }
    /**
     * Get the media for the site.
     */
    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function siteDates()
    {
        return $this->hasMany(SiteDate::class);
    }
}
