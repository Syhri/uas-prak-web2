<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\DaerahController;
use App\Http\Controllers\BahanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to resep index
Route::get('/', function () {
    return redirect()->route('resep.index');
})->name('home');

// Resep routes
Route::resource('resep', ResepController::class);

// Daerah routes
Route::resource('daerah', DaerahController::class);

// Nested Bahan routes
Route::resource('resep.baWhere?han', BahanController::class)->except(['show']);

// Search route
Route::get('/search', function () {
    $query = request('q');

    if (!$query) {
        return redirect()->route('resep.index');
    }

    $reseps = \App\Models\Resep::where('nama_masakan', 'like', "%{$query}%")
        ->orWhere('penjelasan', 'like', "%{$query}%")
        ->get();

    return view('resep.search', compact('reseps', 'query'));
})->name('search');

// Filter berdasarkan kategori
Route::get('/resep/kategori/{id}', [ResepController::class, 'filterByKategori'])->name('resep.filterKategori');

// Filter berdasarkan daerah
Route::get('/resep/daerah/{id}', [ResepController::class, 'filterByDaerah'])->name('resep.filterDaerah');


// MENU
// // Filter resep tradisional
// Route::get('/resep/tradisional', [ResepController::class, 'tradisional'])->name('resep.tradisional');

// // Filter resep kekinian
// Route::get('/resep/kekinian', [ResepController::class, 'kekinian'])->name('resep.kekinian');

// // Daerah tertentu
// Route::get('/daerah/{nama}', [DaerahController::class, 'showByName'])->name('daerah.showByName');
