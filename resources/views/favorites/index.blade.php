<x-app>
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Resep Favorit Saya</h1>
            <p class="text-gray-600 mt-2">Koleksi resep yang telah Anda simpan</p>
        </div>

        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favorites as $resep)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $resep->foto_masakan) }}" 
                                 alt="{{ $resep->nama_masakan }}" 
                                 class="w-full h-48 object-cover">
                            <div class="absolute top-2 right-2">
                                <form action="{{ route('favorites.toggle', $resep) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2">{{ $resep->nama_masakan }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($resep->penjelasan, 100) }}</p>
                            <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                                <span>{{ $resep->kategori->nama }}</span>
                                <span>{{ $resep->daerah->nama }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="text-yellow-400">★</span>
                                    <span class="text-sm text-gray-600 ml-1">
                                        {{ number_format($resep->averageRating(), 1) }} ({{ $resep->totalRatings() }})
                                    </span>
                                </div>
                                <a href="{{ route('resep.show', $resep) }}" 
                                   class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600 transition-colors">
                                    Lihat Resep
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $favorites->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada resep favorit</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai tambahkan resep ke favorit Anda!</p>
                <div class="mt-6">
                    <a href="{{ route('resep.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Jelajahi Resep
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app>
