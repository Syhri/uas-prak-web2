<x-app title="{{ $resep->nama_masakan }}" section_title="Detail Resep">

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Recipe Header -->
        <div class="relative">
            <img src="{{ asset('storage/' . $resep->foto_masakan) }}" alt="{{ $resep->nama_masakan }}"
                class="w-full h-64 object-cover">

            <!-- Favorite Button Overlay -->
            @auth
                <div class="absolute top-4 right-4">
                    <form action="{{ route('favorites.toggle', $resep) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-white p-2 rounded-full shadow-lg hover:bg-gray-50 transition-colors">
                            @if (Auth::user()->hasFavorited($resep))
                                <svg class="w-6 h-6 text-red-500" cursor="pointer" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-400" cursor="pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            @endif
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <h1 class="text-3xl font-bold text-gray-800">{{ $resep->nama_masakan }}</h1>

                @auth
                    <!-- Rating Section -->
                    <div class="text-right">
                        @php
                            $userRating = $resep->getUserRating(Auth::user());
                            $averageRating = $resep->averageRating();
                        @endphp

                        <div class="text-sm text-gray-600 mb-2">
                            Rating: {{ number_format($averageRating, 1) }}/5
                            ({{ $resep->ratings->count() }} rating{{ $resep->ratings->count() !== 1 ? 's' : '' }})
                        </div>

                        <form action="{{ route('ratings.store', $resep) }}" method="POST" class="inline-block">
                            @csrf
                            <div class="flex items-center space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="nilai" value="{{ $i }}" class="hidden"
                                            {{ $userRating && $userRating->nilai == $i ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <span
                                            class="text-xl {{ $userRating && $userRating->nilai >= $i ? 'text-yellow-400' : 'text-gray-300' }} hover:text-yellow-400">★</span>
                                    </label>
                                @endfor
                            </div>
                        </form>
                    </div>
                @endauth
            </div>

            <!-- Recipe Info -->
            <div class="flex flex-wrap gap-4 mb-6 text-sm">
                <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full">
                    {{ $resep->kategori->nama }}
                </span>
                @if ($resep->daerah)
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">
                        {{ $resep->daerah->nama }}
                    </span>
                @endif
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                    ⏱️ {{ $resep->waktu_memasak }}
                </span>
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full">
                    👥 {{ $resep->jumlah_sajian }}
                </span>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi</h2>
                <p class="text-gray-600 leading-relaxed">{{ $resep->penjelasan }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Ingredients -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bahan-bahan</h2>

                    @if ($resep->bahans->count() > 0)
                        <ul class="space-y-2">
                            @foreach ($resep->bahans as $bahan)
                                <li class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-gray-700">{{ $bahan->nama }}</span>
                                    <span class="text-gray-500 text-sm">
                                        {{ $bahan->jumlah }} {{ $bahan->satuan }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-600 whitespace-pre-line">{{ $resep->rincian_bahan }}</p>
                        </div>
                    @endif
                </div>

                <!-- Instructions -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Cara Memasak</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-gray-600 whitespace-pre-line">{{ $resep->cara_memasak }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth
        <!-- Comments Section -->
        <div class="max-w-4xl mx-auto mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-semibold mb-4">Komentar ({{ $resep->comments->count() }})</h3>

            <!-- Add Comment Form -->
            <form action="{{ route('comments.store', $resep) }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <textarea name="komentar" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                        placeholder="Tulis komentar Anda..." required>{{ old('komentar') }}</textarea>
                    @error('komentar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
                    Kirim Komentar
                </button>
            </form>

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($resep->comments()->latest()->get() as $comment)
                    <div class="border-b border-gray-200 pb-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                            @if ($comment->user_id === Auth::id())
                                <div class="flex space-x-2">
                                    <button onclick="editComment({{ $comment->id }})"
                                        class="text-blue-500 hover:underline text-sm">
                                        Edit
                                    </button>
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-sm"
                                            onclick="return confirm('Yakin ingin menghapus komentar ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div id="comment-{{ $comment->id }}">
                            <p class="text-gray-700">{{ $comment->komentar }}</p>
                        </div>
                        <div id="edit-form-{{ $comment->id }}" class="hidden">
                            <form action="{{ route('comments.update', $comment) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <textarea name="komentar" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 mb-2">{{ $comment->komentar }}</textarea>
                                <div class="flex space-x-2">
                                    <button type="submit"
                                        class="bg-orange-600 text-white px-3 py-1 rounded text-sm hover:bg-orange-700">
                                        Update
                                    </button>
                                    <button type="button" onclick="cancelEdit({{ $comment->id }})"
                                        class="bg-gray-500 text-white px-3 py-1 rounded text-sm hover:bg-gray-600">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada komentar. Jadilah yang pertama!</p>
                @endforelse
            </div>
        </div>
    @else
        <div class="max-w-4xl mx-auto mt-8 bg-white rounded-lg shadow-lg p-6 text-center">
            <p class="text-gray-600">
                <a href="{{ route('login') }}" class="text-orange-600 hover:underline">Login</a> untuk memberikan rating,
                komentar, dan menambahkan ke favorit.
            </p>
        </div>
    @endauth

    <script>
        function editComment(commentId) {
            document.getElementById('comment-' + commentId).classList.add('hidden');
            document.getElementById('edit-form-' + commentId).classList.remove('hidden');
        }

        function cancelEdit(commentId) {
            document.getElementById('comment-' + commentId).classList.remove('hidden');
            document.getElementById('edit-form-' + commentId).classList.add('hidden');
        }
    </script>

</x-app>
