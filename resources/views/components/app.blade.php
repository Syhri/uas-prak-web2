@props(['title', 'section_title' => 'Menu'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'LintasRasa' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex flex-col min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center space-x-2 pl-16">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-amber-600">
                            LintasRasa
                        </a>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="hidden sm:flex space-x-10 items-center">
                        <!-- Dropdown Resep -->
                        <div class="relative group">
                            <button
                                class="flex items-center space-x-1 font-sans text-base border-none outline-none py-3.5 px-4 bg-inherit m-0">
                                <span class="leading-none">Resep</span>
                                <svg class="w-4 h-4 mt-0.5 transition-transform rotate-0 group-hover:rotate-180"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0l-4.25-4.25a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div
                                class="hidden absolute bg-gray-100 min-w-[160px] rounded shadow-lg z-10 group-hover:block">
                                @foreach (\App\Models\Kategori::all() as $kategori)
                                    <a href="{{ route('resep.filterKategori', $kategori->id) }}"
                                        class="block text-gray-700 px-4 py-2 hover:bg-gray-200">
                                        {{ $kategori->nama }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Dropdown Daerah -->
                        <div class="relative group">
                            <button
                                class="flex items-center space-x-1 font-sans text-base border-none outline-none py-3.5 px-4 bg-inherit m-0">
                                <span class="leading-none">Daerah</span>
                                <svg class="w-4 h-4 mt-0.5 transition-transform rotate-0 group-hover:rotate-180"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0l-4.25-4.25a.75.75 0 01.02-1.06z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div
                                class="hidden absolute bg-gray-100 min-w-[160px] rounded shadow-lg z-10 group-hover:block">
                                @foreach (\App\Models\Daerah::all() as $daerah)
                                    <a href="{{ route('resep.filterDaerah', $daerah->id) }}"
                                        class="block text-gray-700 px-4 py-2 hover:bg-gray-200">
                                        {{ $daerah->nama }}
                                    </a>
                                @endforeach
                            </div>

                        </div>

                        <!-- Upload Resep -->
                        <a href="{{ route('resep.create') }}" class=" hover:text-amber-600 font-semibold text-sm">
                            Unggah Resepmu
                        </a>
                    </div>

                    <!-- Search -->
                    <div class="w-full max-w-sm min-w-[200px] pr-16">
                        <form action="{{ route('search') }}" method="GET" class="relative">
                            <input name="q"
                                class="w-full bg-transparent placeholder:text-amber-600 text-sm border border-amber-100 rounded-md pl-3 pr-28 py-2 transition duration-300 ease focus:outline-none focus:border-amber-400 hover:border-amber-300 shadow-sm focus:shadow"
                                placeholder="mau masak apa hari ini?" />
                            <button
                                class="absolute top-1 right-1 flex items-center rounded bg-amber-800 py-1 px-2.5 text-white text-sm transition-all shadow-sm hover:shadow focus:bg-amber-700"
                                type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-4 h-4 mr-2">
                                    <path fill-rule="evenodd"
                                        d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Search
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>


        <!-- Main Content -->
        <main class="flex-1 py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl text-center font-bold text-amber-600 mb-6">{{ $section_title }}</h1>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="mt-4 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} LintasRasa. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
