<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 * schema="Media",
 * type="object",
 * title="Media",
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="name", type="string", readOnly="true", example="Media 1"),
 * @OA\Property(property="path", type="string", readOnly="true", example="http://localhost:8000/storage/medias/1.jpg"),
 * @OA\Property(property="type", type="string", readOnly="true", example="image"),
 * @OA\Property(property="is_main", type="boolean", readOnly="true", example="true"),
 * @OA\Property(property="created_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * @OA\Property(property="updated_at", type="string", readOnly="true", example="2021-05-05T12:00:00.000000Z"),
 * )
 */
class Media extends Model
{
    use HasFactory;

    /*    public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);

            $this->setAttribute('type', ['image', 'video']);
        }*/

    protected $fillable = [
        'name',
        'path',
        'type',
        'is_main',
        'site_id',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'site_id' => 'integer',
    ];

    /**
     * Get the site that owns the media.
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}
