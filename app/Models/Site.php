<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Site",
 * type="object",
 * title="Site",
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", readOnly="true", example="Site 1"),
 * @OA\Property(property="description", type="string", readOnly="true", example="Site 1 description"),
 * @OA\Property(property="price", type="integer", readOnly="true", example="100"),
 * @OA\Property(property="latitude", type="string", readOnly="true", example="36.8529"),
 * @OA\Property(property="longitude", type="string", readOnly="true", example="10.2263"),
 * @OA\Property(property="created_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="updated_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="departement", ref="#/components/schemas/Departement"),
 * @OA\Property(property="medias", type="array", @OA\Items(ref="#/components/schemas/Media")),
 * @OA\Property(property="activites", type="array", @OA\Items(
 *    @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *   @OA\Property(property="name", type="string", readOnly="true", example="Activite 1"),
 *  @OA\Property(property="description", type="string", readOnly="true", example="Activite 1 description"),
 * @OA\Property(property="price", type="integer", readOnly="true", example="100"),
 * @OA\Property(property="created_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="updated_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="pivot", type="object", @OA\Property(property="type", type="string", readOnly="true", example="1"), @OA\Property(property="price", type="integer", readOnly="true", example="100")),
 * ))
 * )
 */
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
