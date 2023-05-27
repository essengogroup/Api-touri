<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationSite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'site_id',
        'user_id',
        'date_reservation',
        'price',
        'nb_personnes',
        'is_paid',
        'status',
        'commentaire',
    ];

    protected $casts = [
        'date_reservation' => 'date',
        'is_paid' => 'boolean',
    ];

    /**
     * Get the site that owns the reservation.
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the user that owns the reservation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activites for the reservation.
     */
    public function activites() : BelongsToMany
    {
        return $this->belongsToMany(Activite::class, 'reservation_activites', 'reservation_site_id', 'activite_id')
//            ->withPivot('nb_personnes', 'price')
            ->withTimestamps();
    }
}
