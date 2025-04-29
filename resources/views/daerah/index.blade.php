<x-app title="Daerah Kuliner" section_title="Daerah Kuliner">
{{-- 
    <div class="flex items-center mb-6">
        <p class="text-gray-600">Jelajahi masakan khas dari berbagai daerah di Indonesia</p>
    </div> --}}

    {{-- @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif --}}


    <div class="px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($daerahs as $daerah)
                <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                    <div class="h-48 bg-amber-100 flex items-center justify-center">
                        @if ($daerah->gambar)
                            <img src="{{ asset('storage/' . $daerah->gambar) }}" alt="{{ $daerah->nama }}"
                                class="w-full h-48 object-cover">
                        @else
                            <h3 class="font-bold text-amber-800 text-2xl">{{ $daerah->nama }}</h3>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $daerah->nama }}</h3>
                                <p class="text-gray-600 text-sm mt-1">{{ $daerah->reseps_count }} resep</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('daerah.show', $daerah) }}"
                                    class="text-amber-600 hover:text-amber-900">
                                    Lihat
                                </a>
                                <a href="{{ route('daerah.edit', $daerah) }}" class="text-blue-600 hover:text-blue-900">
                                    Edit
                                </a>
                                <form action="{{ route('daerah.destroy', $daerah) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus daerah ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if ($daerahs->count() === 0)
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-500">Belum ada daerah yang ditambahkan.</p>
            <a href="{{ route('daerah.create') }}"
                class="mt-4 inline-block bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700">
                Tambah Daerah Pertama
            </a>
        </div>
    @endif

</x-app>
