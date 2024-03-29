<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 * schema="SiteDate",
 * type="object",
 * title="SiteDate",
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="site_id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="date", type="string", readOnly="true", example="2021-05-05"),
 * @OA\Property(property="created_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="updated_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="deleted_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * )
 *
 * @OA\Schema(
 * schema="StoreSiteDateRequest",
 * type="object",
 * title="StoreSiteDateRequest",
 * @OA\Property(property="site_id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="date", type="string", readOnly="true", example="2021-05-05"),
 *
 * )
 *
 * @OA\Schema(
 * schema="UpdateSiteDateRequest",
 * type="object",
 * title="UpdateSiteDateRequest",
 * @OA\Property(property="site_id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="date", type="string", readOnly="true", example="2021-05-05"),
 * )
 *
 */
class SiteDate extends Model
{
    use HasFactory;


    protected $fillable = [
        'site_id',
        'date_visite',
    ];

    protected $casts = [
        'site_id' => 'integer',
        'date_visite' => 'date',
    ];

    /**
     * Get the site that owns the site date.
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the activites for the site date.
     */
    public function activites()
    {
        return $this->belongsToMany(Activite::class, 'reservations_activites');
    }
}
