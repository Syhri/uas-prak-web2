<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'resep_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     * Only use created_at, not updated_at for favorites.
     *
     * @var array
     */
    protected $dates = ['created_at'];

    /**
     * Disable updated_at timestamp since we only need created_at for favorites.
     */
    const UPDATED_AT = null;

    /**
     * Get the user that owns the favorite.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the resep that is favorited.
     */
    public function resep(): BelongsTo
    {
        return $this->belongsTo(Resep::class);
    }
}
