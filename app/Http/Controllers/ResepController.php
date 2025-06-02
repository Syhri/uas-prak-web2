<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\Kategori;
use App\Models\Daerah;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ResepController extends Controller
{
    /**
     * Display a listing of the recipes.
     */
    public function index()
    {
        $reseps = Resep::with(['kategori', 'daerah'])->latest()->get();
        return view('resep.index', compact('reseps'));
    }

    /**
     * Show the form for creating a new recipe.
     */
    public function create()
    {
        // Check if categories and regions exist, if not create some default ones
        if (Kategori::count() === 0) {
            $this->seedDefaultKategori();
        }
        
        if (Daerah::count() === 0) {
            $this->seedDefaultDaerah();
        }
        
        $kategoris = Kategori::all();
        $daerahs = Daerah::all();
        
        return view('resep.create', compact('kategoris', 'daerahs'));
    }

    /**
     * Seed default categories if none exist
     */
    private function seedDefaultKategori()
    {
        $kategoris = [
            ['nama' => 'Makanan Utama', 'slug' => 'makanan-utama', 'deskripsi' => 'Hidangan utama untuk makan siang atau makan malam'],
            ['nama' => 'Sarapan', 'slug' => 'sarapan', 'deskripsi' => 'Hidangan untuk memulai hari'],
            ['nama' => 'Camilan', 'slug' => 'camilan', 'deskripsi' => 'Makanan ringan untuk di antara waktu makan'],
            ['nama' => 'Minuman', 'slug' => 'minuman', 'deskripsi' => 'Berbagai jenis minuman'],
            ['nama' => 'Dessert', 'slug' => 'dessert', 'deskripsi' => 'Hidangan penutup dan makanan manis']
        ];
        
        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
    
    /**
     * Seed default regions if none exist
     */
    private function seedDefaultDaerah()
    {
        $daerahs = [
            ['nama' => 'Jawa', 'slug' => 'jawa', 'deskripsi' => 'Masakan dari daerah Jawa', 'gambar' => null],
            ['nama' => 'Sumatera', 'slug' => 'sumatera', 'deskripsi' => 'Masakan dari daerah Sumatera', 'gambar' => null],
            ['nama' => 'Sulawesi', 'slug' => 'sulawesi', 'deskripsi' => 'Masakan dari daerah Sulawesi', 'gambar' => null],
            ['nama' => 'Kalimantan', 'slug' => 'kalimantan', 'deskripsi' => 'Masakan dari daerah Kalimantan', 'gambar' => null],
            ['nama' => 'Bali', 'slug' => 'bali', 'deskripsi' => 'Masakan dari daerah Bali', 'gambar' => null]
        ];
        
        foreach ($daerahs as $daerah) {
            Daerah::create($daerah);
        }
    }

    /**
     * Store a newly created recipe in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto_masakan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_masakan' => 'required|max:255',
            'penjelasan' => 'required',
            'jumlah_sajian' => 'required',
            'waktu_memasak' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'daerah_id' => 'nullable|exists:daerahs,id',
            'rincian_bahan' => 'required',
            'cara_memasak' => 'required',
            'bahan_nama' => 'nullable|array',
            'bahan_jumlah' => 'nullable|array',
            'bahan_satuan' => 'nullable|array',
        ]);

        // Handle file upload
        if ($request->hasFile('foto_masakan')) {
            $path = $request->file('foto_masakan')->store('resep-images', 'public');
            $validated['foto_masakan'] = $path;
        }

        // Begin transaction
        DB::beginTransaction();

        try {
            // Create the recipe
            $resep = Resep::create([
                'foto_masakan' => $validated['foto_masakan'],
                'nama_masakan' => $validated['nama_masakan'],
                'penjelasan' => $validated['penjelasan'],
                'jumlah_sajian' => $validated['jumlah_sajian'],
                'waktu_memasak' => $validated['waktu_memasak'],
                'kategori_id' => $validated['kategori_id'],
                'daerah_id' => $validated['daerah_id'],
                'rincian_bahan' => $validated['rincian_bahan'], // Keep for backward compatibility
                'cara_memasak' => $validated['cara_memasak'],
            ]);

            // Create ingredients if provided
            if (isset($request->bahan_nama) && is_array($request->bahan_nama)) {
                foreach ($request->bahan_nama as $key => $nama) {
                    if (!empty($nama)) {
                        Bahan::create([
                            'resep_id' => $resep->id,
                            'nama' => $nama,
                            'jumlah' => $request->bahan_jumlah[$key] ?? null,
                            'satuan' => $request->bahan_satuan[$key] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('resep.index')
                ->with('success', 'Resep berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded image if exists
            if (isset($validated['foto_masakan'])) {
                Storage::disk('public')->delete($validated['foto_masakan']);
            }

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified recipe.
     */
    public function show(Resep $resep)
    {
        $resep->load(['kategori', 'daerah', 'bahans']);
        return view('resep.show', compact('resep'));
    }

    /**
     * Show the form for editing the specified recipe.
     */
    public function edit(Resep $resep)
    {
        $kategoris = Kategori::all();
        $daerahs = Daerah::all();
        $resep->load('bahans');
        return view('resep.edit', compact('resep', 'kategoris', 'daerahs'));
    }

    /**
     * Update the specified recipe in storage.
     */
    public function update(Request $request, Resep $resep)
    {
        $validated = $request->validate([
            'foto_masakan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_masakan' => 'required|max:255',
            'penjelasan' => 'required',
            'jumlah_sajian' => 'required',
            'waktu_memasak' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'daerah_id' => 'nullable|exists:daerahs,id',
            'rincian_bahan' => 'required',
            'cara_memasak' => 'required',
            'bahan_nama' => 'nullable|array',
            'bahan_jumlah' => 'nullable|array',
            'bahan_satuan' => 'nullable|array',
            'bahan_id' => 'nullable|array',
        ]);

        // Handle file upload
        if ($request->hasFile('foto_masakan')) {
            // Delete old image if exists
            if ($resep->foto_masakan) {
                Storage::disk('public')->delete($resep->foto_masakan);
            }

            $path = $request->file('foto_masakan')->store('resep-images', 'public');
            $validated['foto_masakan'] = $path;
        }

        // Begin transaction
        DB::beginTransaction();

        try {
            // Update the recipe
            $resep->update([
                'nama_masakan' => $validated['nama_masakan'],
                'penjelasan' => $validated['penjelasan'],
                'jumlah_sajian' => $validated['jumlah_sajian'],
                'waktu_memasak' => $validated['waktu_memasak'],
                'kategori_id' => $validated['kategori_id'],
                'daerah_id' => $validated['daerah_id'],
                'rincian_bahan' => $validated['rincian_bahan'],
                'cara_memasak' => $validated['cara_memasak'],
            ]);

            if (isset($validated['foto_masakan'])) {
                $resep->foto_masakan = $validated['foto_masakan'];
                $resep->save();
            }

            // Update ingredients
            // First, delete all existing ingredients
            $resep->bahans()->delete();

            // Then create new ones
            if (isset($request->bahan_nama) && is_array($request->bahan_nama)) {
                foreach ($request->bahan_nama as $key => $nama) {
                    if (!empty($nama)) {
                        Bahan::create([
                            'resep_id' => $resep->id,
                            'nama' => $nama,
                            'jumlah' => $request->bahan_jumlah[$key] ?? null,
                            'satuan' => $request->bahan_satuan[$key] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('resep.show', $resep)
                ->with('success', 'Resep berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded image if exists and it's a new upload
            if (isset($validated['foto_masakan']) && $validated['foto_masakan'] !== $resep->getOriginal('foto_masakan')) {
                Storage::disk('public')->delete($validated['foto_masakan']);
            }

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified recipe from storage.
     */
    public function destroy(Resep $resep)
    {
        // Begin transaction
        DB::beginTransaction();

        try {
            // Delete image if exists
            if ($resep->foto_masakan) {
                Storage::disk('public')->delete($resep->foto_masakan);
            }

            // Delete the recipe (will cascade delete ingredients due to foreign key constraint)
            $resep->delete();

            DB::commit();

            return redirect()->route('resep.index')
                ->with('success', 'Resep berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Filter resep berdasarkan kategori
    public function filterByKategori($id)
    {
        $reseps = Resep::where('kategori_id', $id)->with(['kategori', 'daerah'])->latest()->get();
        return view('resep.index', compact('reseps'));
    }

    // Filter resep berdasarkan daerah
    public function filterByDaerah($id)
    {
        $reseps = Resep::where('daerah_id', $id)->with(['kategori', 'daerah'])->latest()->get();
        return view('resep.index', compact('reseps'));
    }
}
