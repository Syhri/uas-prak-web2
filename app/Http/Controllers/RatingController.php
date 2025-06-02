<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Resep $resep)
    {
        $request->validate([
            'nilai' => 'required|integer|min:1|max:5',
        ]);

        // Check if user already rated this recipe
        $existingRating = Rating::where('user_id', Auth::id())
                               ->where('resep_id', $resep->id)
                               ->first();

        if ($existingRating) {
            // Update existing rating
            $existingRating->update([
                'nilai' => $request->nilai,
            ]);
        } else {
            // Create new rating
            Rating::create([
                'user_id' => Auth::id(),
                'resep_id' => $resep->id,
                'nilai' => $request->nilai,
            ]);
        }

        return back()->with('success', 'Rating berhasil disimpan!');
    }

    public function destroy(Resep $resep)
    {
        $rating = Rating::where('user_id', Auth::id())
                       ->where('resep_id', $resep->id)
                       ->first();

        if ($rating) {
            $rating->delete();
            return back()->with('success', 'Rating berhasil dihapus!');
        }

        return back()->with('error', 'Rating tidak ditemukan!');
    }
}
