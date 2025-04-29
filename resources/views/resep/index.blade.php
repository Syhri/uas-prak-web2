<x-app title="Daftar Resep" section_title="Resep Masakan">

    <p class="text-gray-600 text-center mb-8">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec dui velit,
        elementum in diam posuere, suscipit facilisis velit.</p>

    <!-- Tombol Tambah Resep -->
    <div class="flex justify-center mb-8">
        <a href="{{ route('resep.create') }}"
            class="bg-amber-600 text-white px-6 py-2 rounded-full flex items-center hover:bg-amber-700">
            Tambah Resep Baru
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </div>

    <!-- Grid Card Resep -->
    <div class="px-16 sm:px-16 lg:px-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @if ($reseps->count() > 0)
                @foreach ($reseps as $resep)
                    <!-- Card Resep -->
                    <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition relative">
                        <a href="{{ route('resep.show', $resep) }}">
                            <img src="{{ asset('storage/' . $resep->foto_masakan) }}" alt="{{ $resep->nama_masakan }}"
                                class="w-full h-48 object-cover">

                            <!-- Badge waktu dan tingkat -->
                            <div class="absolute top-2 left-2 flex flex-col gap-1">
                                <span
                                    class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full">{{ $resep->waktu_memasak }}</span>
                                <span
                                    class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full">{{ $resep->kategori->nama }}</span>
                            </div>

                            <!-- Icon Favorit -->
                            <button class="absolute top-2 right-2 bg-white p-1 rounded-full shadow">
                                ❤️
                            </button>

                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $resep->nama_masakan }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-600">Belum ada resep yang ditambahkan.</p>
                    <a href="{{ route('resep.create') }}"
                        class="mt-4 inline-block bg-amber-600 text-white px-6 py-2 rounded-full hover:bg-amber-700">
                        Tambahkan Resep Pertama
                    </a>
                </div>
            @endif

        </div>
    </div>

</x-app>
