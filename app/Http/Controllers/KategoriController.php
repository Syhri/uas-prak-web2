<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $kategoris = Kategori::withCount('reseps')->get();
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:kategoris',
            'deskripsi' => 'nullable',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        Kategori::create($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified category.
     */
    public function show(Kategori $kategori)
    {
        $reseps = $kategori->reseps()->with(['daerah'])->latest()->get();
        return view('kategori.show', compact('kategori', 'reseps'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:kategoris,nama,' . $kategori->id,
            'deskripsi' => 'nullable',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        $kategori->update($validated);

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Kategori $kategori)
    {
        // Check if there are recipes in this category
        if ($kategori->reseps()->count() > 0) {
            return back()->withErrors(['error' => 'Kategori tidak dapat dihapus karena masih memiliki resep!']);
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
