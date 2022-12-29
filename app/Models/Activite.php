<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    protected $guarded = [];

    /**
     * Get the sites for the activite.
     */
    public function sites()
    {
        return $this->belongsToMany(Site::class, 'activites_sites')->withPivot('type', 'price');
    }
}
