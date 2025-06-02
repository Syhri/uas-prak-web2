<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with(['kategori', 'daerah'])->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Resep $resep)
    {
        $favorite = Favorite::where('user_id', Auth::id())
                           ->where('resep_id', $resep->id)
                           ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Resep dihapus dari favorit!';
            $status = 'removed';
        } else {
            Favorite::create([
                'user_id' => Auth::id(),
                'resep_id' => $resep->id,
            ]);
            $message = 'Resep ditambahkan ke favorit!';
            $status = 'added';
        }

        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
}
