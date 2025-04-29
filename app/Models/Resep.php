<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
