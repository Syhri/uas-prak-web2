<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Daerah extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daerahs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'gambar',
    ];

    /**
     * Get the reseps for the daerah.
     */
    public function reseps(): HasMany
    {
        return $this->hasMany(Resep::class);
    }
}
