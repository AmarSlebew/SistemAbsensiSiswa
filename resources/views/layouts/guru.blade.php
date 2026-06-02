<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' — ' : '' }}Disiplinku</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        * { font-family: 'Inter', sans-serif; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.875rem;
            border-radius: 0.625rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #94a3b8;
            transition: all 0.15s ease;
            text-decoration: none;
            position: relative;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.07); color: #e2e8f0; }
        .sidebar-link.active { background: linear-gradient(135deg, #4f46e5, #6366f1); color: #fff; box-shadow: 0 4px 12px rgba(99,102,241,0.4); }
        .sidebar-link.disabled { opacity: 0.45; pointer-events: none; }

        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="h-full bg-slate-50" x-data="{ sidebarOpen: false }">

<div class="flex h-full min-h-screen">

    {{-- ===================== SIDEBAR OVERLAY (mobile) ===================== --}}
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-20 lg:hidden"
        style="display:none">
    </div>

    {{-- ===================== SIDEBAR ===================== --}}
    <aside
        class="fixed inset-y-0 left-0 z-30 w-64 flex flex-col lg:static lg:translate-x-0 transition-transform duration-300 ease-in-out"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        <div class="flex flex-col h-full" style="background: linear-gradient(180deg, #0f172a 0%, #1e293b 60%, #1e293b 100%);">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-5 py-[1.125rem] border-b border-white/10 flex-shrink-0">
                <div>
                    <div class="text-white font-bold text-base leading-tight">Disiplinku</div>
                    <div class="text-slate-500 text-xs">Sistem Absensi Siswa</div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">
                <p class="text-[0.65rem] font-semibold text-slate-600 uppercase tracking-widest px-3 mb-3">Menu Utama</p>

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                    <svg class="w-[1.1rem] h-[1.1rem] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                {{-- Input Absensi --}}
                <a href="#" class="sidebar-link disabled" id="nav-absensi">
                    <svg class="w-[1.1rem] h-[1.1rem] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Input Absensi
                    <span class="ml-auto text-[0.65rem] px-1.5 py-0.5 rounded-full bg-slate-700 text-slate-400">Soon</span>
                </a>

                {{-- Rekap Absensi --}}
                <a href="#" class="sidebar-link disabled" id="nav-rekap">
                    <svg class="w-[1.1rem] h-[1.1rem] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Rekap Absensi
                    <span class="ml-auto text-[0.65rem] px-1.5 py-0.5 rounded-full bg-slate-700 text-slate-400">Soon</span>
                </a>

                {{-- Hasil Klasifikasi --}}
                <a href="#" class="sidebar-link disabled" id="nav-klasifikasi">
                    <svg class="w-[1.1rem] h-[1.1rem] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Hasil Klasifikasi
                    <span class="ml-auto text-[0.65rem] px-1.5 py-0.5 rounded-full bg-slate-700 text-slate-400">Soon</span>
                </a>

            </nav>

            {{-- User Profile --}}
            <div class="px-3 py-4 border-t border-white/10 flex-shrink-0">
                <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-white/5 transition-colors">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-semibold flex-shrink-0"
                         style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</div>
                        <div class="text-slate-500 text-xs">Guru</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" id="btn-logout"
                                class="text-slate-500 hover:text-red-400 transition-colors p-1 rounded-lg hover:bg-white/5"
                                title="Keluar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </aside>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden">

        {{-- Mobile Top Bar --}}
        <header class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 flex items-center gap-3 flex-shrink-0 sticky top-0 z-10">
            <button @click="sidebarOpen = true" id="btn-mobile-menu"
                    class="p-1.5 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                     style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                    </svg>
                </div>
                <span class="font-bold text-slate-800">Disiplinku</span>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

</div>

@stack('scripts')
</body>
</html>
