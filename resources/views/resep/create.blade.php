<x-app title="Unggah Resep" section_title="Unggah Resep Baru">

    <form action="{{ route('resep.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-8 max-w-3xl mx-auto p-6 bg-gray-50 rounded-lg shadow">

        @csrf

        <!-- Upload Foto -->
        <div class="text-center">
            <label class="block mb-2 font-semibold">Unggah Foto Masakanmu</label>
            <input type="file" name="foto_masakan" accept="image/*"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                required>
        </div>

        <!-- Nama Masakan -->
        <div>
            <label class="block mb-1 font-semibold">Nama Masakan:</label>
            <input type="text" name="nama_masakan" class="w-full border rounded p-2"
                placeholder="Ketik nama masakanmu (Maks. 10 kata)" required>
        </div>

        <!-- Penjelasan Singkat -->
        <div>
            <label class="block mb-1 font-semibold">Penjelasan Singkat:</label>
            <textarea name="penjelasan" class="w-full border rounded p-2" rows="3"
                placeholder="Tulis cerita menarik di balik resep ini!" required></textarea>
        </div>

        <!-- Berapa Sajian, Waktu Memasak, Kategori -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block mb-1 font-semibold">Berapa Sajian?</label>
                <select name="jumlah_sajian" class="w-full border rounded p-2" required>
                    <option value="">Pilih</option>
                    <option value="1-4">1-4 porsi</option>
                    <option value="5-8">5-8 porsi</option>
                    <option value="9-12">9-12 porsi</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Waktu Memasak</label>
                <select name="waktu_memasak" class="w-full border rounded p-2" required>
                    <option value="30mnt">30 menit</option>
                    <option value="1jam">1 jam</option>
                    <option value="2jam">2 jam</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Kategori</label>
                <select name="kategori_id" class="w-full border rounded p-2" required>
                    <option value="">Pilih</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Daerah (Opsional)</label>
                <select name="daerah_id" class="w-full border rounded p-2">
                    <option value="">Pilih Daerah</option>
                    @foreach ($daerahs as $daerah)
                        <option value="{{ $daerah->id }}">{{ $daerah->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Rincian Bahan -->
        <div>
            <label class="block mb-1 font-semibold">Masukkan Rincian Bahan:</label>
            <textarea name="rincian_bahan" class="w-full border rounded p-2" rows="5"
                placeholder="Contoh:
    - 2 sdm garam
    - 1 liter air
    - 500 gr ayam" required></textarea>
        </div>

        <!-- Bahan (Structured) -->
        <div>
            <label class="block mb-1 font-semibold">Bahan-bahan (Terstruktur):</label>
            <div id="bahan-container" class="space-y-2">
                <div class="flex flex-wrap gap-2">
                    <input type="text" name="bahan_nama[]" placeholder="Nama bahan"
                        class="flex-1 border rounded p-2">
                    <input type="text" name="bahan_jumlah[]" placeholder="Jumlah" class="w-24 border rounded p-2">
                    <input type="text" name="bahan_satuan[]" placeholder="Satuan" class="w-24 border rounded p-2">
                </div>
            </div>
            <button type="button" id="add-bahan" class="mt-2 bg-amber-100 text-amber-800 px-3 py-1 rounded text-sm">
                + Tambah Bahan
            </button>
        </div>

        <!-- Cara Memasak -->
        <div>
            <label class="block mb-1 font-semibold">Cara Memasak:</label>
            <textarea name="cara_memasak" class="w-full border rounded p-2" rows="5"
                placeholder="Contoh:
    1. Tumis bawang hingga harum.
    2. Masukkan ayam dan aduk rata.
    3. Tambahkan air dan bumbu, masak hingga matang."
                required></textarea>
        </div>

        <!-- Submit -->
        <div class="text-center">
            <button type="submit"
                class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded-full">
                Bagikan Sekarang
            </button>
        </div>

    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('bahan-container');
            const addButton = document.getElementById('add-bahan');

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

                // Add event listener to the remove button
                div.querySelector('.remove-bahan').addEventListener('click', function() {
                    container.removeChild(div);
                });
            });
        });
    </script>

</x-app>
