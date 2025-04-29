<x-app title="{{ $resep->nama_masakan }}" section_title="{{ $resep->nama_masakan }}">

    <div class="max-w-4xl mx-auto">
        <!-- Image and Basic Info -->
        <div class="bg-white rounded-lg overflow-hidden shadow-lg mb-8">
            <img src="{{ asset('storage/' . $resep->foto_masakan) }}" alt="{{ $resep->nama_masakan }}"
                class="w-full h-96 object-cover">

            <div class="p-6">
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm">
                        {{ $resep->waktu_memasak }}
                    </span>
                    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm">
                        {{ $resep->jumlah_sajian }}
                    </span>
                    <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm">
                        {{ $resep->kategori->nama }}
                    </span>
                    @if ($resep->daerah)
                        <span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm">
                            {{ $resep->daerah->nama }}
                        </span>
                    @endif
                </div>

                <p class="text-gray-700 mb-6">{{ $resep->penjelasan }}</p>

                <div class="flex justify-between items-center">
                    <div class="flex space-x-2">
                        <a href="{{ route('resep.edit', $resep) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Edit
                        </a>
                        <form action="{{ route('resep.destroy', $resep) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                    </div>
                    <button class="bg-amber-100 text-amber-800 px-4 py-2 rounded-md hover:bg-amber-200">
                        ❤️ Favorit
                    </button>
                </div>
            </div>
        </div>

        <!-- Ingredients and Instructions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Ingredients -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Bahan-bahan</h2>

                    @if ($resep->bahans->count() > 0)
                        <ul class="space-y-2">
                            @foreach ($resep->bahans as $bahan)
                                <li class="flex items-start">
                                    <span class="text-amber-600 mr-2">•</span>
                                    <span>
                                        @if ($bahan->jumlah)
                                            {{ $bahan->jumlah }}
                                        @endif
                                        @if ($bahan->satuan)
                                            {{ $bahan->satuan }}
                                        @endif
                                        {{ $bahan->nama }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="whitespace-pre-line text-gray-700">{{ $resep->rincian_bahan }}</div>
                    @endif
                </div>
            </div>

            <!-- Instructions -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Cara Memasak</h2>
                    <div class="whitespace-pre-line text-gray-700">{{ $resep->cara_memasak }}</div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('resep.index') }}" class="text-amber-600 hover:text-amber-800">
                &larr; Kembali ke Daftar Resep
            </a>
        </div>
    </div>

</x-app>
