<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Resep extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reseps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'foto_masakan',
        'nama_masakan',
        'penjelasan',
        'jumlah_sajian',
        'waktu_memasak',
        'kategori_id',
        'daerah_id',
        'rincian_bahan',
        'cara_memasak',
    ];

    /**
     * Get the kategori that owns the resep.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Get the daerah that owns the resep.
     */
    public function daerah(): BelongsTo
    {
        return $this->belongsTo(Daerah::class);
    }

    /**
     * Get the bahan for the resep.
     */
    public function bahans(): HasMany
    {
        return $this->hasMany(Bahan::class);
    }

    /**
     * Get the ratings for the resep.
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the comments for the resep.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the users who favorited this resep.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * Get the average rating for this resep.
     */
    public function averageRating(): float
    {
        return $this->ratings()->avg('nilai') ?? 0;
    }

    /**
     * Get the total number of ratings for this resep.
     */
    public function totalRatings(): int
    {
        return $this->ratings()->count();
    }

    /**
     * Check if a user has rated this resep.
     */
    public function hasRatedBy(User $user): bool
    {
        return $this->ratings()->where('user_id', $user->id)->exists();
    }

    /**
     * Get user's rating for this resep.
     */
    public function getUserRating(User $user): ?Rating
    {
        return $this->ratings()->where('user_id', $user->id)->first();
    }
}
