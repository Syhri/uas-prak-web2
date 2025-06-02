<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Resep $resep)
    {
        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'resep_id' => $resep->id,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function update(Request $request, Comment $comment)
    {
        // Check if user owns this comment
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'komentar' => 'required|string|max:1000',
        ]);

        $comment->update([
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil diperbarui!');
    }

    public function destroy(Comment $comment)
    {
        // Check if user owns this comment
        if ($comment->user_id !== Auth::id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }
}
