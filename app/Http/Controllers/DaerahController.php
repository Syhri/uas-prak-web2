<?php

namespace App\Http\Controllers;

use App\Models\Daerah;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DaerahController extends Controller
{
    /**
     * Display a listing of regions.
     */
    public function index()
    {
        $daerahs = Daerah::withCount('reseps')->get();
        return view('daerah.index', compact('daerahs'));
    }

    /**
     * Show the form for creating a new region.
     */
    public function create()
    {
        return view('daerah.create');
    }

    /**
     * Store a newly created region in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:daerahs',
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('daerah-images', 'public');
            $validated['gambar'] = $path;
        }

        Daerah::create($validated);

        return redirect()->route('daerah.index')
            ->with('success', 'Daerah berhasil ditambahkan!');
    }

    /**
     * Display the specified region.
     */
    public function show(Daerah $daerah)
    {
        $reseps = $daerah->reseps()->with(['kategori'])->latest()->get();
        return view('daerah.show', compact('daerah', 'reseps'));
    }

    /**
     * Show the form for editing the specified region.
     */
    public function edit(Daerah $daerah)
    {
        return view('daerah.edit', compact('daerah'));
    }

    /**
     * Update the specified region in storage.
     */
    public function update(Request $request, Daerah $daerah)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:daerahs,nama,' . $daerah->id,
            'deskripsi' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($daerah->gambar) {
                Storage::disk('public')->delete($daerah->gambar);
            }
            
            $path = $request->file('gambar')->store('daerah-images', 'public');
            $validated['gambar'] = $path;
        }

        $daerah->update($validated);

        return redirect()->route('daerah.index')
            ->with('success', 'Daerah berhasil diperbarui!');
    }

    /**
     * Remove the specified region from storage.
     */
    public function destroy(Daerah $daerah)
    {
        // Check if there are recipes in this region
        if ($daerah->reseps()->count() > 0) {
            return back()->withErrors(['error' => 'Daerah tidak dapat dihapus karena masih memiliki resep!']);
        }

        // Delete image if exists
        if ($daerah->gambar) {
            Storage::disk('public')->delete($daerah->gambar);
        }

        $daerah->delete();

        return redirect()->route('daerah.index')
            ->with('success', 'Daerah berhasil dihapus!');
    }
}