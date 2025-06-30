<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Penjaminan Mutu Internal | STIKes Bogor Husada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom Tailwind Configuration & Animations */
        @layer base {
            html {
                scroll-behavior: smooth;
            }
            body {
                font-family: 'Poppins', sans-serif;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Montserrat', sans-serif;
            }
        }

        @keyframes fadeInScaleUp {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulseEffect {
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7); }
            70% { transform: scale(1.02); box-shadow: 0 0 0 10px rgba(37, 99, 235, 0); }
        }

        .animate-fadeInScaleUp { animation: fadeInScaleUp 0.8s ease-out forwards; }
        .animate-slideInUp { animation: slideInUp 0.7s ease-out forwards; }
        .animate-pulseEffect { animation: pulseEffect 2s infinite cubic-bezier(0.66, 0, 0, 1); }

        /* Custom Swiper pagination styles */
        .swiper-pagination-bullet { background: #cbd5e1 !important; opacity: 1 !important; width: 10px !important; height: 10px !important; }
        .swiper-pagination-bullet-active { background: #2563eb !important; width: 25px !important; border-radius: 5px !important; transition: width 0.3s ease !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center animate-fadeInScaleUp">
            <div class="flex items-center space-x-3">
                {{-- Gunakan asset() helper untuk logo --}}
                <img src="{{ asset('path/logo.png') }}" alt="Logo STIKes" class="h-10 w-auto">
                <div>
                    <h1 class="text-xl md:text-2xl font-extrabold text-blue-700">UPMI</h1>
                    <p class="text-xs md:text-sm text-gray-600">STIKes Bogor Husada</p>
                </div>
            </div>
            <nav class="hidden md:flex items-center space-x-8 text-lg font-medium">
                <a href="#beranda" class="text-gray-700 hover:text-blue-600 transition duration-300">Beranda</a>
                
                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600 transition duration-300 focus:outline-none">
                        Tentang UPMI
                        <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute left-1/2 -translate-x-1/2 mt-3 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            <a href="#tentang-profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300" role="menuitem">Profil</a>
                            <a href="#tentang-visimisi" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300" role="menuitem">Visi Misi</a>
                            <a href="#tentang-struktur" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition duration-300" role="menuitem">Struktur Organisasi</a>
                        </div>
                    </div>
                </div>

                <a href="#berita-terkini" class="text-gray-700 hover:text-blue-600 transition duration-300">Berita</a>
                <a href="#dokumen" class="text-gray-700 hover:text-blue-600 transition duration-300">Dokumen</a>
                <a href="#kontak" class="text-gray-700 hover:text-blue-600 transition duration-300">Kontak</a>
            </nav>
            <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1">
                <svg class="inline-block w-5 h-5 mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login UPMI
            </a>
        </div>
    </header>

    <section id="beranda" class="bg-gradient-to-br from-blue-100 to-indigo-200 py-24 md:py-32 flex items-center justify-center min-h-[calc(100vh-6rem)] overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-6 text-center z-10">
            <h2 class="text-4xl md:text-6xl font-extrabold text-blue-900 mb-6 leading-tight animate-slideInUp">
                Unit Penjaminan Mutu Internal <br class="hidden md:block"><span class="text-indigo-700">STIKes Bogor Husada</span>
            </h2>
            <p class="text-gray-700 text-lg md:text-xl max-w-3xl mx-auto mb-10 animate-slideInUp" style="animation-delay: 0.2s;">
                Mewujudkan Budaya Mutu Akademik dan Non-Akademik yang Unggul dan Berkelanjutan.
            </p>
            <a href="#layanan" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full font-bold text-lg shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 animate-pulseEffect" style="animation-delay: 0.4s;">
                Pelajari Lebih Lanjut
            </a>
        </div>
        <div class="absolute inset-0 opacity-20">

            <img src="{{ asset('path/logo.png') }}" alt="Background Quality" class="w-full h-full object-cover">

        </div>
    </section>

    <section id="tentang" class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-3xl font-extrabold text-gray-800 mb-12 text-center">Tentang UPMI STIKes Bogor Husada</h3>

            <div id="tentang-profil" class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div class="animate-slideInUp">
                    <h4 class="text-2xl font-extrabold text-gray-800 mb-4 border-l-4 border-blue-500 pl-4">Profil UPMI</h4>
                    <p class="text-gray-700 text-lg leading-relaxed mb-4">
                        Unit Penjaminan Mutu Internal (UPMI) STIKes Bogor Husada memiliki peran vital dalam memastikan terlaksananya Sistem Penjaminan Mutu Internal (SPMI) secara konsisten dan berkelanjutan. Kami berkomitmen untuk meningkatkan kualitas pendidikan, penelitian, dan pengabdian kepada masyarakat. UPMI dibentuk sebagai wujud komitmen institusi terhadap mutu dan akuntabilitas.
                    </p>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        Kami beroperasi berdasarkan prinsip-prinsip transparansi, objektivitas, dan partisipasi seluruh civitas akademika untuk mencapai standar yang telah ditetapkan.
                    </p>
                </div>
                <div class="flex justify-center items-center animate-fadeInScaleUp" style="animation-delay: 0.2s;">
                    <img src="https://source.unsplash.com/600x400/?profile,team,office" alt="Profil UPMI" class="rounded-xl shadow-xl w-full h-auto object-cover max-h-96">
                </div>
            </div>

            <div id="tentang-visimisi" class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div class="flex justify-center items-center md:order-2 animate-fadeInScaleUp" style="animation-delay: 0.2s;">
                    <img src="https://source.unsplash.com/600x400/?vision,mission,goals" alt="Visi Misi UPMI" class="rounded-xl shadow-xl w-full h-auto object-cover max-h-96">
                </div>
                <div class="md:order-1 animate-slideInUp">
                    <h4 class="text-2xl font-extrabold text-gray-800 mb-4 border-l-4 border-indigo-500 pl-4">Visi & Misi UPMI</h4>
                    <div class="mb-4">
                        <p class="text-gray-700 font-semibold text-lg mb-2">Visi:</p>
                        <p class="text-gray-700 text-base leading-relaxed">
                            “Terwujudnya sebuah Unit penjaminan Mutu yang Berintegritas untuk mencapai visi STIKes Bogor Husada yakni : professional, berkarakter dan berwawasan global tahun 2040”
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-700 font-semibold text-lg mb-2">Misi:</p>
                        <ul class="list-disc list-inside text-gray-700 text-base leading-relaxed space-y-2">
                            <li>Membangun kesadaran setiap unit kerja yang ada di STIKes Bogor Husada akan pentingnya budaya mutu.</li>
                            <li>Meningkatkan pengetahuan dari setiap unit kerja terkait siklus penjaminan mutu PPEPP (Penetapan, Pelaksanaan, Evaluasi, Pengendalian dan Peningkatan).</li>
                            <li>Meningkatkan kualitas mutu STIKes Bogor Husada secara berkelanjutan (Continuous Quality Improvement).</li>
                            <li>Mengkomandoi terkait pelaksanaan Akreditasi sehingga mendapat pengakuan dari lembaga akreditasi.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="tentang-struktur" class="mb-20">
                <h4 class="text-2xl font-extrabold text-gray-800 mb-8 border-l-4 border-purple-500 pl-4 animate-slideInUp">Struktur Organisasi UPMI</h4>
                <div class="flex justify-center items-center bg-gray-50 p-8 rounded-xl shadow-md animate-fadeInScaleUp" style="animation-delay: 0.2s;">
                    <img src="https://via.placeholder.com/800x450/E0E7FF/4338CA?text=Struktur+Organisasi+UPMI" alt="Struktur Organisasi UPMI" class="max-w-full h-auto rounded-lg shadow-lg">
                </div>
                <p class="text-center text-gray-600 text-sm mt-4">Diagram di atas menunjukkan struktur organisasi UPMI STIKes Bogor Husada.</p>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-20 md:py-24 bg-blue-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h3 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-12 animate-slideInUp">Layanan Utama UPMI</h3>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-white p-8 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105 animate-slideInUp">
                    <svg class="w-16 h-16 mx-auto mb-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h4 class="text-xl font-bold mb-3 text-gray-900">Audit Mutu Internal (AMI)</h4>
                    <p class="text-gray-600 leading-relaxed">Pelaksanaan audit berkala untuk memastikan kepatuhan terhadap standar mutu yang ditetapkan.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105 animate-slideInUp" style="animation-delay: 0.1s;">
                    <svg class="w-16 h-16 mx-auto mb-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6zm2 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm0 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm0 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    <h4 class="text-xl font-bold mb-3 text-gray-900">Pelaporan SPMI</h4>
                    <p class="text-gray-600 leading-relaxed">Penyusunan laporan berkala terkait implementasi SPMI di seluruh unit.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg transition-transform duration-300 hover:scale-105 animate-slideInUp" style="animation-delay: 0.2s;">
                    <svg class="w-16 h-16 mx-auto mb-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414-.586a1 1 0 011.414 0L9 7.086V5a1 1 0 112 0v2.086l2.172-2.172a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414zM10 12a1 1 0 100 2h4a1 1 0 100-2h-4z" clip-rule="evenodd"></path></svg>
                    <h4 class="text-xl font-bold mb-3 text-gray-900">Manajemen Dokumen Mutu</h4>
                    <p class="text-gray-600 leading-relaxed">Pengelolaan terpusat dokumen-dokumen terkait mutu internal dan eksternal.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="dokumen" class="py-20 md:py-24 bg-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-3xl md:text-4xl font-extrabold text-gray-800 text-center mb-12 animate-slideInUp">Dokumen Mutu Penting</h3>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide p-8 bg-white rounded-xl shadow-lg text-center flex flex-col items-center justify-center transform transition-transform duration-300 hover:scale-105">
                        <svg class="w-16 h-16 mb-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        <h4 class="text-2xl font-bold mb-2 text-gray-900">Manual SPMI</h4>
                        <p class="text-gray-600 mb-4">Pedoman utama Sistem Penjaminan Mutu Internal.</p>
                        </div>
                    <div class="swiper-slide p-8 bg-white rounded-xl shadow-lg text-center flex flex-col items-center justify-center transform transition-transform duration-300 hover:scale-105">
                        <svg class="w-16 h-16 mb-4 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        <h4 class="text-2xl font-bold mb-2 text-gray-900">Standar Mutu</h4>
                        <p class="text-gray-600 mb-4">Dokumen standar mutu untuk berbagai aspek.</p>
                        </div>
                    <div class="swiper-slide p-8 bg-white rounded-xl shadow-lg text-center flex flex-col items-center justify-center transform transition-transform duration-300 hover:scale-105">
                        <svg class="w-16 h-16 mb-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        <h4 class="text-2xl font-bold mb-2 text-gray-900">Laporan AMI</h4>
                        <p class="text-gray-600 mb-4">Arsip Laporan Audit Mutu Internal tahunan.</p>
                        </div>
                </div>
                <div class="swiper-pagination mt-8"></div>
            </div>
            <div class="text-center mt-12">
                <a href="/dokumen-publik" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-bold shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1">
                    Lihat Semua Dokumen Publik
                </a>
            </div>
        </div>
    </section>

    <section id="berita-terkini" class="py-20 md:py-24 bg-blue-50"> {{-- Ubah warna background --}}
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h3 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-12 animate-slideInUp">Berita & Pengumuman Terbaru</h3> {{-- Ubah judul --}}

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"> {{-- Ubah gap --}}
                @forelse($beritas->take(3) as $berita)
                <div class="bg-white p-6 rounded-xl shadow-lg overflow-hidden border border-gray-200 transition-transform duration-300 hover:scale-[1.02] hover:shadow-xl flex flex-col"> {{-- Styling kartu --}}
                    @if($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" 
                             class="w-full h-48 object-cover object-center rounded-lg mb-4"> {{-- Styling gambar --}}
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg mb-4"> {{-- Placeholder gambar --}}
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <h4 class="text-xl font-bold mb-2 text-gray-900 leading-tight"> {{-- Styling judul, added leading-tight --}}
                        {{ \Illuminate\Support\Str::limit($berita->judul, 50, '...') }} {{-- Batasi judul lebih ketat --}}
                    </h4>
                    <p class="text-gray-700 leading-relaxed text-base flex-grow"> {{-- Styling narasi, added flex-grow --}}
                        {{ \Illuminate\Support\Str::limit(strip_tags($berita->narasi), 100, '...') }} {{-- Batasi narasi lebih ketat --}}
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100"> {{-- Added separator and margin-top --}}
                        <a href="{{ route('berita.publik.show', $berita->slug) }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold"> {{-- Styling link --}}
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
                @empty
                    <div class="col-span-full bg-white rounded-xl shadow-lg p-8 text-center border border-gray-200">
                        <p class="text-gray-600 text-lg italic">Belum ada berita atau pengumuman terbaru yang tersedia.</p>
                        <p class="text-gray-500 mt-2">Nantikan update dari kami!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12 text-center"> {{-- Ubah margin-top dan center --}}
                <a href="{{ route('berita.publik.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full font-bold shadow-xl transition duration-300 ease-in-out transform hover:-translate-y-1"> {{-- Styling tombol --}}
                    Lihat Semua Berita & Pengumuman
                </a>
            </div>
        </div>
    </section>

    <section id="kontak" class="bg-gradient-to-br from-indigo-600 to-blue-700 py-20 text-white text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h3 class="text-4xl md:text-5xl font-extrabold mb-6 animate-slideInUp">Butuh Bantuan atau Informasi Lebih Lanjut?</h3>
            <p class="text-xl opacity-90 mb-10 animate-slideInUp" style="animation-delay: 0.2s;">
                Tim Unit Penjaminan Mutu Internal STIKes Bogor Husada siap melayani Anda.
            </p>
            <a href="mailto:upmi@stikesbogorhusada.ac.id" class="inline-block bg-white text-blue-600 hover:bg-gray-100 px-10 py-4 rounded-full font-bold text-xl shadow-2xl transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105 animate-pulseEffect" style="animation-delay: 0.4s;">
                Hubungi Kami
            </a>
            <p class="mt-8 text-lg opacity-80">
                Alamat: Jl. Sholeh Iskandar No.4, Kedungbadak, Kec. Tanah Sereal, Kota Bogor, Jawa Barat 16164
            </p>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-6 text-center text-sm">
            <p>&copy; {{ date('Y') }} Unit Penjaminan Mutu Internal STIKes Bogor Husada. Hak Cipta Dilindungi.</p>
            <p class="mt-2 text-gray-400">Dikelola oleh Tim ICT.</p>
        </div>
    </footer>

    <script>
        // Swiper Initialization for Dokumen Penting Section
        new Swiper(".mySwiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });

        // Smooth scroll for dropdown links
        document.querySelectorAll('a[href^="#tentang-"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
                // Close the dropdown after clicking a link
                const dropdown = this.closest('[x-data="{ open: false }"]');
                if (dropdown) {
                    dropdown.__x.$data.open = false;
                }
            });
        });
    </script>
</body>
</html>