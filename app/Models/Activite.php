<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 * schema="Activite",
 * type="object",
 * title="Activite",
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", readOnly="true", example="Activite 1"),
 * @OA\Property(property="description", type="string", readOnly="true", example="Description 1"),
 * @OA\Property(property="image_path", type="string", readOnly="true", example="http://localhost:8000/storage/activites/1.jpg"),
 * @OA\Property(property="created_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="updated_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="deleted_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="sites", type="array", @OA\Items(ref="#/components/schemas/Site")),
 * )
 */
class Activite extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    /**
     * Get the sites for the activite.
     */
    public function sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class, 'activites_sites')->withPivot('type', 'price');
    }

    public function medias(): HasMany
    {
        return $this->hasMany(MediaActivite::class);
    }

    public function reservationSites(): BelongsToMany
    {
        return $this->belongsToMany(ReservationSite::class, 'reservation_activites');
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
}
