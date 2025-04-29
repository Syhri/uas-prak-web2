<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->string('foto_masakan');
            $table->string('nama_masakan');
            $table->text('penjelasan');
            $table->string('jumlah_sajian');
            $table->string('waktu_memasak');
            $table->foreignId('kategori_id')->constrained('kategoris');
            $table->foreignId('daerah_id')->nullable()->constrained('daerahs');
            $table->text('rincian_bahan')->nullable(); // For backward compatibility
            $table->text('cara_memasak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
