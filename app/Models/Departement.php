<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 * schema="Departement",
 * type="object",
 * title="Departement",
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", readOnly="true", example="Departement 1"),
 * @OA\Property(property="description", type="string", readOnly="true", example="Departement 1 description"),
 * @OA\Property(property="image_path", type="string", readOnly="true", example="https://www.google.com"),
 * @OA\Property(property="created_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="updated_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="deleted_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * )
 */
class Departement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_path',
    ];

    protected $with = ['sites'];

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }
}
