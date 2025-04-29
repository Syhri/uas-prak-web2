<x-app title="Resep {{ $daerah->nama }}" section_title="Resep Masakan {{ $daerah->nama }}">

    <p class="text-gray-600 text-center mb-8">Temukan hidangan khas {{ $daerah->nama }} yang lezat dan autentik</p>

    <div class="px-16 sm:px-16 lg:px-16">
        @if ($reseps->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($reseps as $resep)
                    <a href="{{ route('resep.show', $resep) }}"
                        class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition relative">
                        <img src="{{ asset('storage/' . $resep->foto_masakan) }}" alt="{{ $resep->nama_masakan }}"
                            class="w-full h-48 object-cover">

                        <!-- Badge waktu dan tingkat -->
                        <div class="absolute top-2 left-2 flex flex-col gap-1">
                            <span
                                class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full">{{ $resep->waktu_memasak }}</span>
                            <span
                                class="bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full">{{ $resep->kategori->nama }}</span>
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 text-lg mb-2">{{ $resep->nama_masakan }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <p class="text-gray-600">Belum ada resep untuk daerah {{ $daerah->nama }}.</p>
                <a href="{{ route('resep.create') }}"
                    class="mt-4 inline-block bg-amber-600 text-white px-6 py-2 rounded-full hover:bg-amber-700">
                    Tambahkan Resep Pertama
                </a>
            </div>
        @endif
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('daerah.index') }}" class="text-amber-600 hover:text-amber-800">
            &larr; Kembali ke Daftar Daerah
        </a>
    </div>

</x-app>
