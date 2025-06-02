<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\DaerahController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;

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

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to resep index
Route::get('/', function () {
    return redirect()->route('resep.index');
})->name('home');

// Resep routes
Route::resource('resep', ResepController::class);

// Daerah routes
Route::resource('daerah', DaerahController::class);

// Nested Bahan routes
Route::resource('resep.bahan', BahanController::class)->except(['show']);

// Rating routes (protected)
Route::middleware('auth')->group(function () {
    Route::post('/resep/{resep}/rating', [RatingController::class, 'store'])->name('ratings.store');
    Route::delete('/resep/{resep}/rating', [RatingController::class, 'destroy'])->name('ratings.destroy');
});

// Comment routes (protected)
Route::middleware('auth')->group(function () {
    Route::post('/resep/{resep}/comment', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comment/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Favorite routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/resep/{resep}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

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
