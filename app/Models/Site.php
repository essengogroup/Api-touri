<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

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

    protected $fillable = [
        'name',
        'description',
        'address',
        'price',
        'latitude',
        'longitude',
        'is_date_required',
        'is_active',
        'departement_id',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'price' => 'integer',
        'is_date_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $with = ['comments', 'likes', 'shares'];


    public function getSharesCountAttribute()
    {
        return $this->shares()->count();
    }



    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    /**
     * Get the departement that owns the site.
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * Get the media for the site.
     */
    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Get the activites for the site.
     */
    public function activites()
    {
        return $this->belongsToMany(Activite::class, 'activites_sites');
    }

    /**
     * Get the reservations for the site.
     */
    public function reservations()
    {
        return $this->hasMany(ReservationSite::class);
    }


    public function siteDates()
    {
        return $this->hasMany(SiteDate::class);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function shares(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Share::class, 'shareable');
    }

    public function hebergements(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Hebergement::class, 'hebergements_sites');
    }

    public function transports(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Transport::class, 'transports_sites');
    }

    public function restaurants(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class, 'restaurants_sites');
    }

    public function guides(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Guide::class, 'guides_sites');
    }

    public function assurances(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Assurance::class, 'assurances_sites');
    }

}
