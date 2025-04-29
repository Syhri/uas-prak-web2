<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bahan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bahans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resep_id',
        'nama',
        'jumlah',
        'satuan',
    ];

    /**
     * Get the resep that owns the bahan.
     */
    public function resep(): BelongsTo
    {
        return $this->belongsTo(Resep::class);
    }
}
