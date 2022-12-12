<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationSite extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the site that owns the reservation.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the user that owns the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the site date that owns the reservation.
     */
    public function siteDate()
    {
        return $this->belongsTo(SiteDate::class);
    }

    /**
     * Get the activites for the reservation.
     */
    public function activites()
    {
        return $this->belongsToMany(Activite::class, 'reservations_activites', 'reservation_site_id', 'activite_id');
    }
}
