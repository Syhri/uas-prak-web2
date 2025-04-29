<x-app title="Edit Resep" section_title="Edit Resep: {{ $resep->nama_masakan }}">

    <form action="{{ route('resep.update', $resep) }}" method="POST" enctype="multipart/form-data"
        class="space-y-8 max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">

        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Current Image Preview -->
        <div class="text-center">
            <label class="block mb-2 font-semibold">Foto Masakan Saat Ini</label>
            <img src="{{ asset('storage/' . $resep->foto_masakan) }}" alt="{{ $resep->nama_masakan }}"
                class="h-48 object-cover mx-auto rounded-lg">
        </div>

        <!-- Upload New Foto -->
        <div class="text-center">
            <label class="block mb-2 font-semibold">Ganti Foto Masakan (Opsional)</label>
            <input type="file" name="foto_masakan" accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
        </div>

        <!-- Nama Masakan -->
        <div>
            <label class="block mb-1 font-semibold">Nama Masakan:</label>
            <input type="text" name="nama_masakan" class="w-full border rounded p-2"
                value="{{ old('nama_masakan', $resep->nama_masakan) }}" required>
        </div>

        <!-- Penjelasan Singkat -->
        <div>
            <label class="block mb-1 font-semibold">Penjelasan Singkat:</label>
            <textarea name="penjelasan" class="w-full border rounded p-2" rows="3" required>{{ old('penjelasan', $resep->penjelasan) }}</textarea>
        </div>

        <!-- Berapa Sajian, Waktu Memasak, Kategori -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block mb-1 font-semibold">Berapa Sajian?</label>
                <select name="jumlah_sajian" class="w-full border rounded p-2" required>
                    <option value="">Pilih</option>
                    <option value="1-4" {{ $resep->jumlah_sajian == '1-4' ? 'selected' : '' }}>1-4 porsi</option>
                    <option value="5-8" {{ $resep->jumlah_sajian == '5-8' ? 'selected' : '' }}>5-8 porsi</option>
                    <option value="9-12" {{ $resep->jumlah_sajian == '9-12' ? 'selected' : '' }}>9-12 porsi</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Waktu Memasak</label>
                <select name="waktu_memasak" class="w-full border rounded p-2" required>
                    <option value="30mnt" {{ $resep->waktu_memasak == '30mnt' ? 'selected' : '' }}>30 menit</option>
                    <option value="1jam" {{ $resep->waktu_memasak == '1jam' ? 'selected' : '' }}>1 jam</option>
                    <option value="2jam" {{ $resep->waktu_memasak == '2jam' ? 'selected' : '' }}>2 jam</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Kategori</label>
                <select name="kategori_id" class="w-full border rounded p-2" required>
                    <option value="">Pilih</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ $resep->kategori_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Daerah (Opsional)</label>
                <select name="daerah_id" class="w-full border rounded p-2">
                    <option value="">Pilih Daerah</option>
                    @foreach ($daerahs as $daerah)
                        <option value="{{ $daerah->id }}" {{ $resep->daerah_id == $daerah->id ? 'selected' : '' }}>
                            {{ $daerah->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Rincian Bahan -->
        <div>
            <label class="block mb-1 font-semibold">Masukkan Rincian Bahan:</label>
            <textarea name="rincian_bahan" class="w-full border rounded p-2" rows="5" required>{{ old('rincian_bahan', $resep->rincian_bahan) }}</textarea>
        </div>

        <!-- Bahan (Structured) -->
        <div>
            <label class="block mb-1 font-semibold">Bahan-bahan (Terstruktur):</label>
            <div id="bahan-container" class="space-y-2">
                @if ($resep->bahans->count() > 0)
                    @foreach ($resep->bahans as $index => $bahan)
                        <div class="flex flex-wrap gap-2">
                            <input type="hidden" name="bahan_id[]" value="{{ $bahan->id }}">
                            <input type="text" name="bahan_nama[]" value="{{ $bahan->nama }}"
                                placeholder="Nama bahan" class="flex-1 border rounded p-2">
                            <input type="text" name="bahan_jumlah[]" value="{{ $bahan->jumlah }}"
                                placeholder="Jumlah" class="w-24 border rounded p-2">
                            <input type="text" name="bahan_satuan[]" value="{{ $bahan->satuan }}"
                                placeholder="Satuan" class="w-24 border rounded p-2">
                            <button type="button"
                                class="remove-bahan bg-red-100 text-red-800 px-3 py-1 rounded text-sm">
                                Hapus
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="flex flex-wrap gap-2">
                        <input type="text" name="bahan_nama[]" placeholder="Nama bahan"
                            class="flex-1 border rounded p-2">
                        <input type="text" name="bahan_jumlah[]" placeholder="Jumlah"
                            class="w-24 border rounded p-2">
                        <input type="text" name="bahan_satuan[]" placeholder="Satuan"
                            class="w-24 border rounded p-2">
                    </div>
                @endif
            </div>
            <button type="button" id="add-bahan" class="mt-2 bg-amber-100 text-amber-800 px-3 py-1 rounded text-sm">
                + Tambah Bahan
            </button>
        </div>

        <!-- Cara Memasak -->
        <div>
            <label class="block mb-1 font-semibold">Cara Memasak:</label>
            <textarea name="cara_memasak" class="w-full border rounded p-2" rows="5" required>{{ old('cara_memasak', $resep->cara_memasak) }}</textarea>
        </div>

        <!-- Submit and Cancel -->
        <div class="flex justify-between">
            <a href="{{ route('resep.show', $resep) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Batal
            </a>
            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded">
                Simpan Perubahan
            </button>
        </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('bahan-container');
            const addButton = document.getElementById('add-bahan');

            // Add event listeners to existing remove buttons
            document.querySelectorAll('.remove-bahan').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('div').remove();
                });
            });

            addButton.addEventListener('click', function() {
                const div = document.createElement('div');
                div.className = 'flex flex-wrap gap-2';
                div.innerHTML = `
                    <input type="text" name="bahan_nama[]" placeholder="Nama bahan" class="flex-1 border rounded p-2">
                    <input type="text" name="bahan_jumlah[]" placeholder="Jumlah" class="w-24 border rounded p-2">
                    <input type="text" name="bahan_satuan[]" placeholder="Satuan" class="w-24 border rounded p-2">
                    <button type="button" class="remove-bahan bg-red-100 text-red-800 px-3 py-1 rounded text-sm">
                        Hapus
                    </button>
                `;
                container.appendChild(div);

                // Add event listener to the new remove button
                div.querySelector('.remove-bahan').addEventListener('click', function() {
                    container.removeChild(div);
                });
            });
        });
    </script>

</x-app>
