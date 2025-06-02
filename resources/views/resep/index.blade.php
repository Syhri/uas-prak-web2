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
                        </a>

                        <!-- Icon Favorit -->
                        @auth
                            <div class="absolute top-2 right-2">
                                <form action="{{ route('favorites.toggle', $resep) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-white p-1 rounded-full shadow hover:bg-gray-50 transition-colors">
                                        @if (Auth::user()->hasFavorited($resep))
                                            <svg class="w-5 h-5 text-red-500" cursor="pointer" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" cursor="pointer" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                </path>
                                            </svg>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="absolute top-2 right-2">
                                <a href="{{ route('login') }}"
                                    class="bg-white p-1 rounded-full shadow hover:bg-gray-50 transition-colors inline-block">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" t stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        @endauth

                        <a href="{{ route('resep.show', $resep) }}">
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
