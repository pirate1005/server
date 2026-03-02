<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - MLS Server AI</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon1.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="bg-[#0B0C15] text-white h-screen flex items-center justify-center relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-cyan-500/20 rounded-full blur-[128px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-500/20 rounded-full blur-[128px]"></div>

    <div class="w-full max-w-md p-8 glass rounded-3xl shadow-2xl relative z-10 mx-4">
        
        <div class="text-center mb-8 flex flex-col items-center">
            
            <a href="{{ url('/') }}" class="inline-block mb-4 hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('assets/img/logo3nobg.png') }}" alt="Logo MLS" class="w-16 h-16 object-contain drop-shadow-[0_0_15px_rgba(6,182,212,0.5)]">
            </a>

            <h2 class="text-3xl font-bold mb-2">Selamat Datang</h2>
            <p class="text-gray-400 text-sm">Masuk untuk mengelola aset server Anda.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-400 text-center bg-green-500/10 py-2 rounded-lg border border-green-500/20">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-gray-400 text-sm font-medium mb-2">Email Address</label>
                <input type="email" name="email" required autofocus 
                    class="w-full px-4 py-3 rounded-xl bg-black/30 border border-gray-700 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 text-white placeholder-gray-600 transition outline-none"
                    placeholder="nama@email.com" value="{{ old('email') }}">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-400 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-3 rounded-xl bg-black/30 border border-gray-700 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 text-white placeholder-gray-600 transition outline-none"
                    placeholder="••••••••">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between mb-8">
                <label class="flex items-center cursor-pointer group">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-gray-800 border-gray-700 text-cyan-500 focus:ring-cyan-500 cursor-pointer accent-cyan-500">
                    <span class="ml-2 text-sm text-gray-400 group-hover:text-gray-300 transition">Ingat Saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-cyan-400 hover:text-cyan-300 transition">Lupa Password?</a>
                @endif
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.5)] transition transform active:scale-95">
                Masuk Sekarang
            </button>

            <div class="mt-6 text-center text-sm text-gray-400">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-white font-bold hover:text-cyan-400 transition hover:underline">Daftar disini</a>
            </div>
        </form>
        
        <div class="mt-8 text-center">
             <a href="{{ url('/') }}" class="text-xs text-gray-500 hover:text-gray-300 transition flex items-center justify-center gap-1">
                 <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                 Kembali ke Beranda
             </a>
        </div>
    </div>
</body>
</html>