<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Digital Server Solutions')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon1.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    },
                    colors: {
                        dark: {
                            900: '#0B0C15',
                            800: '#141625',
                            700: '#1E2136'
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                            '33%': {
                                transform: 'translate(30px, -50px) scale(1.1)'
                            },
                            '66%': {
                                transform: 'translate(-20px, 20px) scale(0.9)'
                            },
                            '100%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                        },
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Efek Noise Halus di Background */
        .bg-noise {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
        }
    </style>
</head>

<body
    class="bg-dark-900 text-white flex flex-col min-h-screen antialiased selection:bg-cyan-500 selection:text-black overflow-x-hidden relative">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:4rem_4rem]">
        </div>
        <div class="absolute inset-0 bg-dark-900/40 bg-noise mix-blend-overlay"></div>
        <div class="absolute top-0 -left-4 w-96 h-96 bg-cyan-500/20 rounded-full blur-[128px] animate-blob"></div>
        <div
            class="absolute bottom-0 -right-4 w-96 h-96 bg-purple-500/20 rounded-full blur-[128px] animate-blob animation-delay-2000">
        </div>
    </div>

    <nav class="fixed top-0 w-full z-50 transition-all duration-300 py-4">
        <div class="max-w-7xl mx-auto px-4">
            <div
                class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl px-6 h-16 flex items-center justify-between shadow-2xl shadow-black/20">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">

                    <img src="{{ asset('assets/img/logo3nobg.png') }}" alt="Logo MLS"
                        class="w-10 h-10 object-contain group-hover:scale-110 transition duration-300">

                    <span
                        class="font-bold text-lg tracking-tight text-white group-hover:text-cyan-100 transition">LMS<span
                            class="text-cyan-400">Server AI</span></span>
                </a>

                <div class="hidden md:flex items-center space-x-1">
                    <a href="#"
                        class="px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition">Beranda</a>
                    <a href="#server-list"
                        class="px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition">Server</a>
                    <a href="#"
                        class="px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 rounded-full transition">Misi
                        Harian</a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-5 py-2 text-sm font-semibold bg-white/10 hover:bg-white/20 border border-white/10 rounded-full transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-400 hover:text-white transition px-2">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2 text-sm font-bold bg-white text-black rounded-full hover:bg-cyan-50 transition shadow-[0_0_15px_rgba(255,255,255,0.3)]">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow relative z-10 pt-24">
        @yield('content')
    </main>

    <footer class="relative z-10 mt-32 border-t border-white/5 bg-black/40 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left">
                    <h3 class="font-bold text-xl mb-2">LMS<span class="text-cyan-400">Server</span></h3>
                    <p class="text-gray-500 text-sm">Platform aset digital terpercaya dengan sistem otomatisasi.</p>
                </div>
                <p class="text-gray-600 text-sm">© 2026 PT LMS Digital Solutions. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>
