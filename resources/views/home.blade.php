@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<!-- Hero Section -->
<section id="beranda" class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="1.5"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Jelajahi Dunia <br>
                <span class="text-yellow-300">Pengetahuan</span>
            </h1>
            <p class="text-xl md:text-2xl text-indigo-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                Perpustakaan digital modern dengan koleksi lengkap buku, jurnal, dan e-book untuk mendukung perjalanan belajar Anda
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-10">
                <div class="relative">
                    <input type="text"
                           placeholder="Cari buku, jurnal, atau artikel..."
                           class="w-full px-6 py-4 text-lg rounded-full border-0 shadow-lg focus:ring-4 focus:ring-white focus:ring-opacity-30 focus:outline-none">
                    <button class="absolute right-2 top-2 bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#layanan" class="bg-white text-indigo-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                    Jelajahi Koleksi
                </a>
                <a href="/register" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-indigo-600 transition-colors">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 text-white text-6xl opacity-20 animate-bounce">📚</div>
    <div class="absolute top-40 right-20 text-white text-4xl opacity-20 animate-pulse">✨</div>
    <div class="absolute bottom-20 left-20 text-white text-5xl opacity-20 animate-bounce" style="animation-delay: 1s;">🎓</div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-indigo-600 mb-2">1,247</div>
                <div class="text-gray-600">Total Buku</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-purple-600 mb-2">892</div>
                <div class="text-gray-600">Anggota Aktif</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-pink-600 mb-2">324</div>
                <div class="text-gray-600">E-Book</div>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-yellow-600 mb-2">156</div>
                <div class="text-gray-600">Jurnal Digital</div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="layanan" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Layanan Perpustakaan</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Nikmati berbagai layanan modern yang kami sediakan untuk mendukung kebutuhan belajar dan penelitian Anda
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Peminjaman Buku -->
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow border border-gray-100">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Peminjaman Buku</h3>
                <p class="text-gray-600 mb-6">Pinjam buku fisik dengan sistem digital yang mudah dan cepat. Proses peminjaman hanya butuh beberapa klik.</p>
                <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                    Pelajari lebih lanjut
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- E-Book Digital -->
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow border border-gray-100">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">E-Book Digital</h3>
                <p class="text-gray-600 mb-6">Akses ribuan e-book berkualitas tinggi kapan saja, di mana saja. Baca di smartphone, tablet, atau komputer.</p>
                <a href="#" class="text-purple-600 hover:text-purple-800 font-medium inline-flex items-center">
                    Jelajahi E-Book
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Jurnal Penelitian -->
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow border border-gray-100">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Jurnal Penelitian</h3>
                <p class="text-gray-600 mb-6">Akses jurnal ilmiah dan artikel penelitian terkini dari berbagai disiplin ilmu untuk mendukung riset Anda.</p>
                <a href="#" class="text-green-600 hover:text-green-800 font-medium inline-flex items-center">
                    Baca Jurnal
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Ruang Belajar -->
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow border border-gray-100">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Ruang Belajar</h3>
                <p class="text-gray-600 mb-6">Reservasi ruang belajar yang nyaman dan tenang, dilengkapi dengan fasilitas WiFi dan colokan listrik.</p>
                <a href="#" class="text-yellow-600 hover:text-yellow-800 font-medium inline-flex items-center">
                    Reservasi Ruang
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Konsultasi -->
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow border border-gray-100">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Konsultasi Pustakawan</h3>
                <p class="text-gray-600 mb-6">Dapatkan bantuan dari pustakawan profesional untuk riset, pencarian referensi, dan kebutuhan akademik lainnya.</p>
                <a href="#" class="text-red-600 hover:text-red-800 font-medium inline-flex items-center">
                    Konsultasi Sekarang
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Workshop -->
            <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow border border-gray-100">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Workshop & Pelatihan</h3>
                <p class="text-gray-600 mb-6">Ikuti workshop literasi digital, pelatihan penelitian, dan seminar yang diselenggarakan secara berkala.</p>
                <a href="#" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                    Lihat Jadwal
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Popular Books Section -->
<section id="koleksi" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Koleksi Terpopuler</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Temukan buku-buku terbaik dan paling diminati oleh para pembaca di perpustakaan kami
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Book 1 -->
            <div class="group cursor-pointer">
                <div class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg p-6 mb-4 transform group-hover:scale-105 transition-transform">
                    <div class="text-white text-center">
                        <div class="text-6xl mb-4">📖</div>
                        <h3 class="text-lg font-semibold">Laskar Pelangi</h3>
                        <p class="text-blue-100 text-sm">Andrea Hirata</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400">⭐⭐⭐⭐⭐</div>
                    <span class="text-sm text-gray-500">47 peminjaman</span>
                </div>
            </div>

            <!-- Book 2 -->
            <div class="group cursor-pointer">
                <div class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg shadow-lg p-6 mb-4 transform group-hover:scale-105 transition-transform">
                    <div class="text-white text-center">
                        <div class="text-6xl mb-4">📚</div>
                        <h3 class="text-lg font-semibold">Bumi Manusia</h3>
                        <p class="text-purple-100 text-sm">Pramoedya Ananta Toer</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400">⭐⭐⭐⭐⭐</div>
                    <span class="text-sm text-gray-500">42 peminjaman</span>
                </div>
            </div>

            <!-- Book 3 -->
            <div class="group cursor-pointer">
                <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-lg shadow-lg p-6 mb-4 transform group-hover:scale-105 transition-transform">
                    <div class="text-white text-center">
                        <div class="text-6xl mb-4">📓</div>
                        <h3 class="text-lg font-semibold">Dilan 1990</h3>
                        <p class="text-green-100 text-sm">Pidi Baiq</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400">⭐⭐⭐⭐⭐</div>
                    <span class="text-sm text-gray-500">38 peminjaman</span>
                </div>
            </div>

            <!-- Book 4 -->
            <div class="group cursor-pointer">
                <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-lg shadow-lg p-6 mb-4 transform group-hover:scale-105 transition-transform">
                    <div class="text-white text-center">
                        <div class="text-6xl mb-4">📔</div>
                        <h3 class="text-lg font-semibold">Ayat-Ayat Cinta</h3>
                        <p class="text-red-100 text-sm">Habiburrahman El Shirazy</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex text-yellow-400">⭐⭐⭐⭐⭐</div>
                    <span class="text-sm text-gray-500">35 peminjaman</span>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold inline-flex items-center transition-colors">
                Lihat Semua Koleksi
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="tentang" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Tentang Perpustakaan Kami</h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    Perpustakaan Digital adalah pusat pembelajaran modern yang menggabungkan koleksi tradisional dengan teknologi terdepan. Kami berkomitmen untuk menyediakan akses terbaik terhadap informasi dan pengetahuan bagi semua anggota komunitas.
                </p>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                    Dengan koleksi lebih dari 1.000 buku fisik, ratusan e-book, dan akses ke jurnal internasional, kami siap mendukung perjalanan belajar dan penelitian Anda.
                </p>

                <!-- Features -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Akses 24/7 ke koleksi digital</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Pustakawan profesional siap membantu</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-gray-700">Ruang belajar yang nyaman dan modern</span>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="bg-gradient-to-br from-indigo-400 to-purple-500 rounded-2xl p-8 text-white">
                    <div class="text-center">
                        <div class="text-8xl mb-6">🏛️</div>
                        <h3 class="text-2xl font-bold mb-4">Didirikan sejak 1995</h3>
                        <p class="text-indigo-100">Melayani komunitas dengan dedikasi selama lebih dari 25 tahun</p>
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-yellow-300 rounded-full opacity-20"></div>
                <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-pink-300 rounded-full opacity-20"></div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-indigo-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">Siap Memulai Perjalanan Belajar?</h2>
        <p class="text-xl text-indigo-100 mb-8 max-w-3xl mx-auto">
            Bergabunglah dengan ribuan anggota yang telah mempercayai kami sebagai mitra belajar mereka
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/register" class="bg-white text-indigo-600 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
                Daftar Gratis Sekarang
            </a>
            <a href="#kontak" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-white hover:text-indigo-600 transition-colors">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="kontak" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Ada pertanyaan atau butuh bantuan? Tim kami siap membantu Anda
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-gray-50 rounded-xl p-8">
                <h3 class="text-2xl font-semibold text-gray-900 mb-6">Kirim Pesan</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subjek</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-6">Informasi Kontak</h3>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Alamat</h4>
                                <p class="text-gray-600">Jl. Pendidikan No. 123<br>Jakarta Selatan, DKI Jakarta 12345</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Telepon</h4>
                                <p class="text-gray-600">(021) 123-4567<br>(021) 123-4568</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">Email</h4>
                                <p class="text-gray-600">info@perpustakaan.ac.id<br>bantuan@perpustakaan.ac.id</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Operating Hours -->
                <div class="bg-indigo-50 rounded-xl p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Jam Operasional</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Senin - Jumat</span>
                            <span class="font-medium text-gray-900">08:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Sabtu</span>
                            <span class="font-medium text-gray-900">09:00 - 17:00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Minggu</span>
                            <span class="font-medium text-gray-900">10:00 - 15:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
