<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMAN 1 PLUTO - Membentuk Generasi Cerdas &amp; Berkarakter</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316', // Primary Orange
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer href="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased" x-data="{ mobileMenuOpen: false }">

    {{-- ===== NAVBAR ===== --}}
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- Logo --}}
                <a href="#home" class="flex items-center gap-3 group">
                    <div>
                        <span class="block text-slate-900 font-bold text-base tracking-tight leading-none">SMAN 1 PLUTO</span>
                        <span class="text-[0.65rem] text-slate-400 font-medium tracking-widest uppercase">Cerdas &amp; Berkarakter</span>
                    </div>
                </a>

                {{-- Desktop Links --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="#home" class="text-slate-600 hover:text-brand-500 text-sm font-medium transition-colors">Home</a>
                    <a href="#tentang" class="text-slate-600 hover:text-brand-500 text-sm font-medium transition-colors">Tentang</a>
                    <a href="#program" class="text-slate-600 hover:text-brand-500 text-sm font-medium transition-colors">Program</a>
                    <a href="#prestasi" class="text-slate-600 hover:text-brand-500 text-sm font-medium transition-colors">Prestasi</a>
                    <a href="#kontak" class="text-slate-600 hover:text-brand-500 text-sm font-medium transition-colors">Kontak</a>
                </div>

                {{-- Action Button --}}
                <div class="hidden md:flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md hover:shadow-brand-500/10">
                            Dashboard Guru
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 border border-slate-200 hover:border-brand-500 text-slate-700 hover:text-brand-500 text-sm font-semibold rounded-xl transition-all">
                            Login Guru
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                        </a>
                    @endauth
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="p-2 text-slate-500 hover:text-slate-800 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        {{-- Mobile Dropdown Menu --}}
        <div class="md:hidden border-t border-slate-100 bg-white" x-show="mobileMenuOpen" x-transition>
            <div class="px-4 py-3 space-y-1">
                <a href="#home" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Home</a>
                <a href="#tentang" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Tentang</a>
                <a href="#program" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Program</a>
                <a href="#prestasi" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Prestasi</a>
                <a href="#kontak" @click="mobileMenuOpen = false" class="block px-3 py-2 text-base font-medium text-slate-700 hover:bg-slate-50 rounded-lg">Kontak</a>
                
                <div class="pt-4 pb-2 border-t border-slate-100">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="w-full text-center inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-brand-500 text-white font-semibold rounded-lg text-sm">
                            Dashboard Guru
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full text-center inline-flex justify-center items-center gap-2 px-4 py-2.5 border border-slate-200 text-slate-700 font-semibold rounded-lg text-sm">
                            Login Guru
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ===== HERO SECTION ===== --}}
    <section id="home" class="relative bg-gradient-to-br from-brand-50 via-white to-slate-50 pt-10 pb-20 lg:pt-16 lg:pb-28 overflow-hidden">
        
        {{-- Background Graphic Elements --}}
        <div class="absolute inset-0 z-0 opacity-40">
            <div class="absolute top-20 right-[-10%] w-96 h-96 rounded-full bg-brand-200/40 blur-3xl"></div>
            <div class="absolute bottom-10 left-[-10%] w-96 h-96 rounded-full bg-orange-100 blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                {{-- Text Column --}}
                <div class="lg:col-span-6 space-y-6 text-center lg:text-left" data-aos="fade-right">
                    
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-brand-50 border border-brand-100 text-brand-700 rounded-full text-xs font-semibold uppercase tracking-wider mx-auto lg:mx-0">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A5.906 5.906 0 0 1 1 5.93a5.907 5.907 0 0 1 5.417-5.187 50.082 50.082 0 0 1 11.166 0A5.906 5.906 0 0 1 23 5.93a5.907 5.907 0 0 1-5.417 5.187 50.636 50.636 0 0 0-2.658.813m-9.926 0C6.14 10.3 8.014 10.5 10 10.522V12m0 0v1.5m0-1.5h1.5m-1.5 0H8.5" />
                        </svg>
                        <span>Profil Resmi Sekolah</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-none font-heading">
                        Membentuk Generasi <span class="text-brand-500">Cerdas</span>, Berkarakter, &amp; Berprestasi
                    </h1>

                    <p class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Selamat datang di <span class="font-semibold text-slate-800">SMAN 1 PLUTO</span>. Kami berkomitmen untuk menyelenggarakan pendidikan berkualitas tinggi yang memadukan keunggulan akademik dengan pembinaan akhlak mulia sejak dini.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="#kontak" 
                           class="w-full sm:w-auto text-center px-6 py-3.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold rounded-xl shadow-lg shadow-brand-500/20 hover:shadow-xl transition-all">
                            Pendaftaran Siswa Baru
                        </a>
                        <a href="#tentang" 
                           class="w-full sm:w-auto text-center px-6 py-3.5 bg-white border border-slate-200 hover:border-brand-300 text-slate-700 font-semibold rounded-xl transition-all">
                            Hubungi Kami
                        </a>
                    </div>

                </div>

                {{-- Illustration Column --}}
                <div class="lg:col-span-6 flex justify-center" data-aos="zoom-in" data-aos-delay="200">
                    <div class="relative w-full max-w-md sm:max-w-lg lg:max-w-none">
                        
                        {{-- Frame Accent --}}
                        <div class="absolute -inset-1.5 bg-gradient-to-r from-brand-500 to-orange-400 rounded-2xl blur opacity-15"></div>
                        
                        {{-- Custom Craft School Illustration SVG --}}
                        <div class="relative bg-white border border-slate-200 rounded-2xl p-6 shadow-sm overflow-hidden flex flex-col items-center justify-center">
                            
                            {{-- SVG School Building Illustration --}}
                            <svg viewBox="0 0 500 320" class="w-full h-auto text-slate-800" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Sky/Grid pattern -->
                                <defs>
                                    <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="#f1f5f9" stroke-width="1"/>
                                    </pattern>
                                </defs>
                                <rect width="500" height="320" fill="url(#grid)" />
                                
                                <!-- Sun -->
                                <circle cx="420" cy="60" r="25" fill="#fef08a" />
                                <circle cx="420" cy="60" r="35" fill="#fef08a" opacity="0.3" />

                                <!-- School Building Back Wall -->
                                <rect x="80" y="100" width="340" height="160" rx="8" fill="#e2e8f0" />
                                
                                <!-- Roof -->
                                <path d="M 60 100 L 250 30 L 440 100 Z" fill="#ea580c" />
                                <path d="M 230 30 L 250 30 L 440 100 L 420 100 Z" fill="#c2410c" />

                                <!-- Flagpole -->
                                <line x1="250" y1="120" x2="250" y2="280" stroke="#94a3b8" stroke-width="4" stroke-linecap="round" />
                                <!-- Flag (Indonesian Flag) -->
                                <rect x="250" y="125" width="45" height="15" fill="#ef4444" />
                                <rect x="250" y="140" width="45" height="15" fill="#ffffff" stroke="#e2e8f0" stroke-width="0.5" />
                                <circle cx="250" cy="120" r="4" fill="#fbbf24" />

                                <!-- Building Windows -->
                                <rect x="110" y="130" width="40" height="40" rx="4" fill="#bae6fd" stroke="#94a3b8" stroke-width="2" />
                                <rect x="110" y="190" width="40" height="40" rx="4" fill="#bae6fd" stroke="#94a3b8" stroke-width="2" />
                                
                                <rect x="350" y="130" width="40" height="40" rx="4" fill="#bae6fd" stroke="#94a3b8" stroke-width="2" />
                                <rect x="350" y="190" width="40" height="40" rx="4" fill="#bae6fd" stroke="#94a3b8" stroke-width="2" />

                                <!-- Entrance Column -->
                                <rect x="200" y="180" width="100" height="80" rx="4" fill="#f8fafc" stroke="#cbd5e1" stroke-width="2" />
                                <path d="M 190 180 L 250 140 L 310 180 Z" fill="#ea580c" />

                                <!-- Door -->
                                <rect x="230" y="205" width="40" height="55" rx="2" fill="#7c2d12" />
                                <circle cx="238" cy="235" r="2" fill="#fbbf24" />
                                <circle cx="262" cy="235" r="2" fill="#fbbf24" />

                                <!-- Trees -->
                                <circle cx="60" cy="240" r="30" fill="#22c55e" />
                                <circle cx="80" cy="250" r="25" fill="#16a34a" />
                                <rect x="55" y="260" width="10" height="30" fill="#78350f" />
                                
                                <circle cx="440" cy="240" r="30" fill="#22c55e" />
                                <circle cx="420" cy="250" r="25" fill="#16a34a" />
                                <rect x="435" y="260" width="10" height="30" fill="#78350f" />

                                <!-- Ground -->
                                <rect x="20" y="280" width="460" height="15" rx="7" fill="#475569" />
                            </svg>

                            <div class="mt-4 flex items-center justify-between w-full border-t border-slate-100 pt-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-xs">
                                        <svg class="w-4 h-4 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <span class="block text-xs font-semibold text-slate-800">Akreditasi</span>
                                        <span class="text-[0.65rem] text-slate-400">Predikat A Unggul</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="block text-xs font-semibold text-slate-800">Est. 2011</span>
                                    <span class="text-[0.65rem] text-slate-400">Pluto</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== ABOUT SCHOOL SECTION ===== --}}
    <section id="tentang" class="py-20 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                {{-- Left: Description --}}
                <div class="lg:col-span-7 space-y-6" data-aos="fade-right">
                    
                    <div class="flex items-center gap-2 text-brand-500 font-bold text-sm uppercase tracking-wider">
                        <span class="w-6 h-0.5 bg-brand-500"></span>
                        Profil Sekolah
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight font-heading">
                        Membangun Akhlak Mulia dan Keunggulan Akademis
                    </h2>

                    <p class="text-slate-600 leading-relaxed">
                        Sejak didirikan 15 tahun yang lalu, SMAN 1 PLUTO terus berdedikasi menciptakan lingkungan belajar yang kondusif, interaktif, dan penuh kasih sayang. Kami percaya bahwa setiap anak memiliki bakat unik yang harus diasah secara optimal.
                    </p>

                    <p class="text-slate-600 leading-relaxed">
                        Dengan kurikulum terpadu, sarana pendukung digital, serta tenaga pendidik yang kompeten and berdedikasi, kami siap mendampingi putra-putri Anda menapak jalan menuju masa depan yang gemilang.
                    </p>

                    {{-- Accreditation Banner --}}
                    <div class="flex items-center gap-4 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        <div class="w-12 h-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center font-bold text-xl flex-shrink-0">
                            A
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Terakreditasi A (Sangat Baik)</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Berdasarkan keputusan Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M).</p>
                        </div>
                    </div>

                </div>

                {{-- Right: Statistics Cards --}}
                <div class="lg:col-span-5 grid grid-cols-2 gap-4" data-aos="fade-left">
                    
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center space-y-1 hover:border-brand-500 transition-colors">
                        <span class="block text-4xl font-extrabold text-brand-500 font-heading">300+</span>
                        <span class="block text-sm font-semibold text-slate-700">Siswa Aktif</span>
                        <span class="text-xs text-slate-400">Tahun ajaran berjalan</span>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center space-y-1 hover:border-brand-500 transition-colors">
                        <span class="block text-4xl font-extrabold text-brand-500 font-heading">25</span>
                        <span class="block text-sm font-semibold text-slate-700">Guru &amp; Staf</span>
                        <span class="text-xs text-slate-400">Kompeten &amp; Tersertifikasi</span>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center space-y-1 hover:border-brand-500 transition-colors">
                        <span class="block text-4xl font-extrabold text-brand-500 font-heading">15</span>
                        <span class="block text-sm font-semibold text-slate-700">Tahun Berdiri</span>
                        <span class="text-xs text-slate-400">Dedikasi tiada henti</span>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center space-y-1 hover:border-brand-500 transition-colors">
                        <span class="block text-4xl font-extrabold text-brand-500 font-heading">A</span>
                        <span class="block text-sm font-semibold text-slate-700">Akreditasi</span>
                        <span class="text-xs text-slate-400">Nilai kualitas unggul</span>
                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- ===== VISION & MISSION SECTION ===== --}}
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-xl mx-auto mb-16 space-y-3" data-aos="fade-up">
                <div class="text-brand-500 font-bold text-sm uppercase tracking-wider">Arah &amp; Tujuan</div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight font-heading">Visi dan Misi Sekolah</h2>
                <p class="text-slate-400 text-sm">Landasan utama bagi kami dalam mendampingi tumbuh kembang murid.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                {{-- Visi Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-8 hover:border-brand-500 transition-colors flex flex-col justify-between" data-aos="fade-right">
                    <div class="space-y-6">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <div class="space-y-3">
                            <h3 class="text-xl font-bold text-slate-900 font-heading">Visi Kami</h3>
                            <p class="text-slate-600 leading-relaxed text-base italic">
                                "Menjadi lembaga pendidikan dasar yang unggul dalam melahirkan insan yang bertaqwa, cerdas, berkarakter mulia, serta siap menghadapi kemajuan teknologi informasi pada era global."
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Misi Card --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-8 hover:border-brand-500 transition-colors" data-aos="fade-left">
                    <div class="space-y-6">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-xl font-bold text-slate-900 font-heading">Misi Kami</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-semibold flex-shrink-0 mt-0.5">1</span>
                                    <span class="text-slate-600 text-sm">Menanamkan nilai-nilai keagamaan dan pembiasaan akhlak mulia sejak dini.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-semibold flex-shrink-0 mt-0.5">2</span>
                                    <span class="text-slate-600 text-sm">Menyelenggarakan pembelajaran saintifik yang kreatif, menyenangkan, dan efektif.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-semibold flex-shrink-0 mt-0.5">3</span>
                                    <span class="text-slate-600 text-sm">Membekali siswa dengan pemahaman dasar teknologi informasi dan literasi digital.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center text-xs font-semibold flex-shrink-0 mt-0.5">4</span>
                                    <span class="text-slate-600 text-sm">Menjalin kemitraan yang harmonis dengan orang tua dan masyarakat sekitar.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== FEATURED PROGRAMS SECTION ===== --}}
    <section id="program" class="py-20 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-xl mx-auto mb-16 space-y-3" data-aos="fade-up">
                <div class="text-brand-500 font-bold text-sm uppercase tracking-wider">Kurikulum &amp; Kegiatan</div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight font-heading">Program Unggulan</h2>
                <p class="text-slate-400 text-sm">Program khusus yang dirancang untuk mengoptimalkan potensi siswa secara holistik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- Program 1 --}}
                <div class="border border-slate-200 hover:border-brand-500 rounded-2xl p-6 transition-colors space-y-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Literasi Digital</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Mengenalkan teknologi secara bijak dan sehat, membimbing siswa menggunakan komputer dasar untuk keperluan belajar kreatif.
                    </p>
                </div>

                {{-- Program 2 --}}
                <div class="border border-slate-200 hover:border-brand-500 rounded-2xl p-6 transition-colors space-y-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Tahfidz</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Program bimbingan menghafal Al-Qur'an secara rutin dengan tajwid yang benar guna membentuk generasi qur'ani yang shalih.
                    </p>
                </div>

                {{-- Program 3 --}}
                <div class="border border-slate-200 hover:border-brand-500 rounded-2xl p-6 transition-colors space-y-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 9.5M3 15V9.5" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Pramuka</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Membina kemandirian, kedisiplinan, kerjasama tim, kepemimpinan, dan cinta tanah air melalui ekstrakurikuler kepramukaan.
                    </p>
                </div>

                {{-- Program 4 --}}
                <div class="border border-slate-200 hover:border-brand-500 rounded-2xl p-6 transition-colors space-y-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 0 0 .495-7.467 5.99 5.99 0 0 0-1.925 3.546 5.974 5.974 0 0 1-2.133-1A3.75 3.75 0 0 0 12 18Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Olahraga</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Pelatihan rutin cabang olahraga seperti futsal, bulu tangkis, dan atletik demi menjaga kebugaran jasmani murid.
                    </p>
                </div>

                {{-- Program 5 --}}
                <div class="border border-slate-200 hover:border-brand-500 rounded-2xl p-6 transition-colors space-y-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.599-3.75A11.952 11.952 0 0 1 12 2.707Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Teknologi Informasi</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Pengenalan konsep logika dasar, pemrograman visual (scratch), dan perangkat lunak produktivitas penunjang materi sekolah.
                    </p>
                </div>

                {{-- Program 6 --}}
                <div class="border border-slate-200 hover:border-brand-500 rounded-2xl p-6 transition-colors space-y-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-1.178-.759l-1.59-.499a3 3 0 0 0-2.078.107l-1.22.56c-.459.21-.611.756-.318 1.157l1.125 1.532a3 3 0 0 0 1.566 1.04l1.8.4a3 3 0 0 0 2.524-1.01l1.533-1.84a3 3 0 0 0 .56-2.078l-.499-1.59a3 3 0 0 0-.759-1.178L9.53 16.122Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25a9 9 0 1 1 11.25 11.25" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Seni dan Budaya</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Menggali potensi bakat seni melalui seni tari tradisional, menggambar, mewarnai, serta seni vokal dan ansambel musik.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== DIGITAL DISCIPLINE HIGHLIGHT (DisiplinKu) ===== --}}
    <section class="py-20 bg-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-96 h-96 rounded-full bg-brand-500 blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                {{-- Text Left --}}
                <div class="lg:col-span-6 space-y-6" data-aos="fade-right">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-brand-500/10 border border-brand-500/20 text-brand-400 rounded-full text-xs font-semibold uppercase tracking-wider">
                        <svg class="w-3.5 h-3.5 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m10.5-5.25v1.5M21 8.25h-1.5m-3 12.75v-1.5m-10.5 0v-1.5M3 15.75h1.5m15 0H21M12 7.875c-2.278 0-4.125 1.847-4.125 4.125s1.847 4.125 4.125 4.125 4.125-1.847 4.125-4.125S14.278 7.875 12 7.875Z" />
                        </svg>
                        <span>Smart School Feature</span>
                    </div>
                    
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-heading leading-tight">
                        Monitoring Kehadiran dan Kedisiplinan Siswa Secara Digital
                    </h2>
                    
                    <p class="text-slate-300 leading-relaxed text-sm sm:text-base">
                        SMAN 1 PLUTO menggunakan sistem <span class="font-semibold text-brand-400">DisiplinKu</span> untuk membantu guru memantau kehadiran siswa secara real-time dan mendukung proses pembinaan kedisiplinan melalui teknologi digital cerdas.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-500/20 flex items-center justify-center text-brand-400 flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold">AI Discipline Classification</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Klasifikasi otomatis status kedisiplinan siswa berbasis Machine Learning.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-brand-500/20 flex items-center justify-center text-brand-400 flex-shrink-0">
                                <svg class="w-4 h-4 text-brand-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold">Real-time Absensi</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Input absensi di kelas terhubung langsung ke server database.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mockup Right --}}
                <div class="lg:col-span-6 flex justify-center" data-aos="zoom-in" data-aos-delay="200">
                    <div class="relative w-full max-w-md bg-stone-900 border border-stone-800 rounded-2xl p-4 shadow-2xl">
                        
                        {{-- Top Window bar --}}
                        <div class="flex items-center gap-1.5 pb-3 border-b border-stone-800 mb-4">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            <span class="text-[0.65rem] text-slate-500 ml-2 font-mono">disiplinku.sman1pluto.sch.id</span>
                        </div>

                        {{-- Mockup Content --}}
                        <div class="space-y-4">
                            
                            {{-- Stats --}}
                            <div class="grid grid-cols-3 gap-2">
                                <div class="bg-stone-800/80 p-2.5 rounded-lg border border-stone-800">
                                    <span class="block text-[0.6rem] text-stone-500 uppercase">Hadir</span>
                                    <span class="text-xs font-bold text-green-500">95.4%</span>
                                </div>
                                <div class="bg-stone-800/80 p-2.5 rounded-lg border border-stone-800">
                                    <span class="block text-[0.6rem] text-stone-500 uppercase">Sakit/Izin</span>
                                    <span class="text-xs font-bold text-amber-500">3.2%</span>
                                </div>
                                <div class="bg-stone-800/80 p-2.5 rounded-lg border border-stone-800">
                                    <span class="block text-[0.6rem] text-stone-500 uppercase">Alpa</span>
                                    <span class="text-xs font-bold text-red-500">1.4%</span>
                                </div>
                            </div>

                            {{-- Student List Sample --}}
                            <div class="bg-stone-800/40 border border-stone-800/80 rounded-lg p-3 space-y-2">
                                <div class="flex items-center justify-between text-[0.7rem] text-stone-500 border-b border-stone-800/60 pb-1.5 font-medium">
                                    <span>NAMA SISWA</span>
                                    <span>STATUS DISIPLIN</span>
                                </div>
                                
                                <div class="flex items-center justify-between text-xs py-1">
                                    <span class="text-slate-300 font-medium">Amar Slebew</span>
                                    <span class="text-[0.65rem] font-semibold text-green-500 bg-green-500/10 px-2 py-0.5 rounded-full border border-green-500/20">Sangat Disiplin</span>
                                </div>

                                <div class="flex items-center justify-between text-xs py-1">
                                    <span class="text-slate-300 font-medium">Budiman Hermawan</span>
                                    <span class="text-[0.65rem] font-semibold text-yellow-500 bg-yellow-500/10 px-2 py-0.5 rounded-full border border-yellow-500/20">Cukup Disiplin</span>
                                </div>

                                <div class="flex items-center justify-between text-xs py-1">
                                    <span class="text-slate-300 font-medium">Reza Arap</span>
                                    <span class="text-[0.65rem] font-semibold text-red-500 bg-red-500/10 px-2 py-0.5 rounded-full border border-red-500/20">Bermasalah</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== ACHIEVEMENTS SECTION ===== --}}
    <section id="prestasi" class="py-20 bg-slate-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-xl mx-auto mb-16 space-y-3" data-aos="fade-up">
                <div class="text-brand-500 font-bold text-sm uppercase tracking-wider">Koleksi Prestasi</div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight font-heading">Prestasi Sekolah</h2>
                <p class="text-slate-400 text-sm">Bukti nyata dedikasi dan perjuangan siswa-siswi SMAN 1 PLUTO.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                {{-- Achievement 1 --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 hover:border-brand-500 transition-colors" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-6.75a1.125 1.125 0 0 0-1.125 1.125v3.375m9 0h-9M9 10.5a3 3 0 1 1-6 0v-3h6v3Zm12 0a3 3 0 1 1-6 0v-3h6v3Z" />
                        </svg>
                    </div>
                    <span class="block text-xs font-semibold text-brand-600 uppercase">Juara 1 &middot; Akademik</span>
                    <h3 class="text-base font-bold text-slate-900 leading-snug">Olimpiade Matematika Kabupaten</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Diraih oleh Ananda Ahmad Farhan pada ajang bergengsi tingkat kabupaten tahun 2025.
                    </p>
                </div>

                {{-- Achievement 2 --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 hover:border-brand-500 transition-colors" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                    </div>
                    <span class="block text-xs font-semibold text-brand-600 uppercase">Juara 2 &middot; Olahraga</span>
                    <h3 class="text-base font-bold text-slate-900 leading-snug">Turnamen Futsal se-Kecamatan</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Tim futsal putra sekolah berhasil menyabet medali perak setelah perjuangan sengit di final.
                    </p>
                </div>

                {{-- Achievement 3 --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 hover:border-brand-500 transition-colors" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-1.178-.759l-1.59-.499a3 3 0 0 0-2.078.107l-1.22.56c-.459.21-.611.756-.318 1.157l1.125 1.532a3 3 0 0 0 1.566 1.04l1.8.4a3 3 0 0 0 2.524-1.01l1.533-1.84a3 3 0 0 0 .56-2.078l-.499-1.59a3 3 0 0 0-.759-1.178L9.53 16.122Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25a9 9 0 1 1 11.25 11.25" />
                        </svg>
                    </div>
                    <span class="block text-xs font-semibold text-brand-600 uppercase">Juara 1 &middot; Kesenian</span>
                    <h3 class="text-base font-bold text-slate-900 leading-snug">Lomba Menggambar Provinsi</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Karya Ananda Siti Humaira menyabet gelar terbaik tingkat provinsi pada ajang FLS2N.
                    </p>
                </div>

                {{-- Achievement 4 --}}
                <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 hover:border-brand-500 transition-colors" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-brand-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.15-.469.82-.469.97 0l2.361 7.26h7.682c.48 0 .68.617.292.903l-6.216 4.516 2.361 7.26c.15.469-.38.857-.79.57L12 18.77l-6.215 4.516c-.41.287-.94-.101-.79-.57l2.362-7.26-6.216-4.516c-.38-.286-.18-.903.292-.903h7.682l2.361-7.26Z" />
                        </svg>
                    </div>
                    <span class="block text-xs font-semibold text-brand-600 uppercase">Penghargaan &middot; Sekolah</span>
                    <h3 class="text-base font-bold text-slate-900 leading-snug">Sekolah Ramah Anak Nasional</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        Penghargaan resmi kementerian atas dedikasi menyajikan sekolah aman, sehat, dan kondusif.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== FOOTER ===== --}}
    <footer id="kontak" class="bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                
                {{-- Col 1: About --}}
                <div class="space-y-4" data-slate-300>
                    <a href="#home" class="flex items-center gap-3">
                        <span class="text-white font-bold text-base tracking-tight">SMAN 1 PLUTO</span>
                    </a>
                    <p class="text-xs leading-relaxed">
                        Penyelenggara pendidikan menengah atas yang unggul dalam melahirkan siswa-siswi cerdas, taqwa, berkarakter mulia, serta melek literasi digital di era global.
                    </p>
                </div>

                {{-- Col 2: Quick Links --}}
                <div class="space-y-4">
                    <h4 class="text-white font-bold text-sm tracking-wide uppercase">Tautan Pintar</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#home" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#tentang" class="hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#program" class="hover:text-white transition-colors">Program Unggulan</a></li>
                        <li><a href="#prestasi" class="hover:text-white transition-colors">Koleksi Prestasi</a></li>
                    </ul>
                </div>

                {{-- Col 3: Contact Info --}}
                <div class="space-y-4">
                    <h4 class="text-white font-bold text-sm tracking-wide uppercase">Informasi Kontak</h4>
                    <ul class="space-y-3.5 text-xs leading-relaxed">
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-brand-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <span>Jl. Raya Pluto Raya No. 1, Antariksa, Banten.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-brand-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.186-4.164-6.988-6.988l1.293-.97c.362-.272.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <span>(021) 12345678</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-brand-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <span>info@sman1pluto.sch.id</span>
                        </li>
                    </ul>
                </div>

                {{-- Col 4: Social Media --}}
                <div class="space-y-4">
                    <h4 class="text-white font-bold text-sm tracking-wide uppercase">Ikuti Kami</h4>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                            f
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                            t
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                            ig
                        </a>
                        <a href="#" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-500 hover:text-white flex items-center justify-center transition-colors">
                            yt
                        </a>
                    </div>
                </div>

            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
                <p>&copy; {{ date('Y') }} SMAN 1 PLUTO. Hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-white">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-white">Syarat &amp; Ketentuan</a>
                </div>
            </div>

        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
        });
    </script>
</body>
</html>
