<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Dashboard') - LMS Server</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon1.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Hilangkan scrollbar di mobile tapi konten tetap bisa discroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Custom Style SweetAlert Dark Mode */
        div:where(.swal2-container) div:where(.swal2-popup) {
            background: #1f2937 !important;
            border: 1px solid #374151;
            color: #fff !important;
            border-radius: 1rem;
        }
        div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
            background-color: #0891b2 !important; /* cyan-600 */
            box-shadow: none !important;
        }
        div:where(.swal2-container) button:where(.swal2-styled).swal2-cancel {
            background-color: #ef4444 !important; /* red-500 */
            box-shadow: none !important;
        }
    </style>
</head>
<body class="bg-[#0B0C15] text-white flex h-screen overflow-hidden">

    <aside class="hidden md:flex w-72 bg-[#141625] border-r border-gray-800 flex-col flex-shrink-0 transition-all duration-300">
        <div class="h-20 flex items-center px-8 border-b border-gray-800">
            <span class="text-xl font-bold tracking-wide">LMS<span class="text-cyan-400">Server AI</span></span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto no-scrollbar">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('dashboard') ? 'bg-cyan-500/10 text-cyan-400' : 'text-gray-400 hover:text-white' }}">
                <i class="{{ request()->routeIs('dashboard') ? 'ph-fill' : 'ph' }} ph-house text-xl"></i> Home
            </a>

            <a href="{{ route('user.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('user.products.*') ? 'bg-cyan-500/10 text-cyan-400' : 'text-gray-400 hover:text-white' }}">
                <i class="{{ request()->routeIs('user.products.*') ? 'ph-fill' : 'ph' }} ph-shopping-cart text-xl"></i> Sewa Server
            </a>

            <a href="{{ route('user.servers') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('user.servers') ? 'bg-cyan-500/10 text-cyan-400' : 'text-gray-400 hover:text-white' }}">
                <i class="{{ request()->routeIs('user.servers') ? 'ph-fill' : 'ph' }} ph-hard-drives text-xl"></i> Server Saya
            </a>

            <a href="{{ route('user.missions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('user.missions.*') ? 'bg-cyan-500/10 text-cyan-400' : 'text-gray-400 hover:text-white' }}">
                <i class="{{ request()->routeIs('user.missions.*') ? 'ph-fill' : 'ph' }} ph-play-circle text-xl"></i> Misi Harian
            </a>

            <a href="{{ route('user.wallet') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('user.wallet') ? 'bg-cyan-500/10 text-cyan-400' : 'text-gray-400 hover:text-white' }}">
                <i class="{{ request()->routeIs('user.wallet') ? 'ph-fill' : 'ph' }} ph-wallet text-xl"></i> Dompet
            </a>

            <a href="{{ route('user.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('user.profile') ? 'bg-cyan-500/10 text-cyan-400' : 'text-gray-400 hover:text-white' }}">
                <i class="{{ request()->routeIs('user.profile') ? 'ph-fill' : 'ph' }} ph-user text-xl"></i> Akun
            </a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full py-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-lg font-bold transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <main class="flex-1 overflow-y-auto bg-[#0B0C15] p-4 pb-24 md:p-8 md:pb-8 no-scrollbar">
            @yield('content')
        </main>
    </div>

    <nav class="md:hidden fixed bottom-0 w-full bg-[#141625]/90 backdrop-blur-lg border-t border-gray-800 z-50 pb-safe">
        <div class="flex justify-around items-center h-16">
            
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 w-full {{ request()->routeIs('dashboard') ? 'text-cyan-400' : 'text-gray-500' }}">
                <i class="{{ request()->routeIs('dashboard') ? 'ph-fill' : 'ph' }} ph-house text-2xl"></i>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>

            <a href="{{ route('user.products.index') }}" class="flex flex-col items-center gap-1 w-full {{ request()->routeIs('user.products.*') || request()->routeIs('user.servers') ? 'text-cyan-400' : 'text-gray-500' }}">
                <i class="{{ request()->routeIs('user.products.*') || request()->routeIs('user.servers') ? 'ph-fill' : 'ph' }} ph-hard-drives text-2xl"></i>
                <span class="text-[10px] font-medium">Sewa</span>
            </a>

            <div class="relative -top-5">
                <a href="{{ route('user.missions.index') }}" class="w-14 h-14 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-full flex items-center justify-center shadow-lg shadow-cyan-500/30 text-white transform active:scale-95 transition border-4 border-[#0B0C15]">
                    <i class="ph-fill ph-play-circle text-3xl"></i>
                </a>
            </div>

            <a href="{{ route('user.wallet') }}" class="flex flex-col items-center gap-1 w-full {{ request()->routeIs('user.wallet') ? 'text-cyan-400' : 'text-gray-500' }}">
                <i class="{{ request()->routeIs('user.wallet') ? 'ph-fill' : 'ph' }} ph-wallet text-2xl"></i>
                <span class="text-[10px] font-medium">Dompet</span>
            </a>

            <a href="{{ route('user.profile') }}" class="flex flex-col items-center gap-1 w-full {{ request()->routeIs('user.profile') ? 'text-cyan-400' : 'text-gray-500' }}">
                <i class="{{ request()->routeIs('user.profile') ? 'ph-fill' : 'ph' }} ph-user text-2xl"></i>
                <span class="text-[10px] font-medium">Saya</span>
            </a>

        </div>
    </nav>

    @stack('scripts')
</body>
</html>