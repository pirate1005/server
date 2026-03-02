<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - MLS Server AI</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/icon1.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="bg-[#0B0C15] text-white min-h-screen flex items-center justify-center relative py-10 overflow-x-hidden">

    <div class="absolute top-[-10%] right-[20%] w-96 h-96 bg-purple-500/20 rounded-full blur-[128px]"></div>
    <div class="absolute bottom-[-10%] left-[20%] w-96 h-96 bg-cyan-500/20 rounded-full blur-[128px]"></div>

    <div class="w-full max-w-lg p-8 glass rounded-3xl shadow-2xl relative z-10 mx-4">
        
        <div class="text-center mb-8 flex flex-col items-center">
            
            <a href="{{ url('/') }}" class="inline-block mb-4 hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('assets/img/logo3nobg.png') }}" alt="Logo MLS" class="w-16 h-16 object-contain drop-shadow-[0_0_15px_rgba(6,182,212,0.5)]">
            </a>

            <h2 class="text-3xl font-bold mb-2">Buat Akun Baru</h2>
            <p class="text-gray-400 text-sm">Bergabunglah dengan ribuan investor server lainnya.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-400 text-sm font-medium mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                        class="w-full px-4 py-3 rounded-xl bg-black/30 border border-gray-700 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none text-white transition" placeholder="John Doe">
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-gray-400 text-sm font-medium mb-2">No WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}" required 
                        class="w-full px-4 py-3 rounded-xl bg-black/30 border border-gray-700 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none text-white transition" placeholder="0812...">
                    @error('whatsapp') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-400 text-sm font-medium mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                    class="w-full px-4 py-3 rounded-xl bg-black/30 border border-gray-700 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none text-white transition" placeholder="nama@email.com">
                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-400 text-sm font-medium mb-2">Kode Referral (Opsional)</label>
                <input type="text" name="referral_code" value="{{ request('ref') ?? old('referral_code') }}" 
                    class="w-full px-4 py-3 rounded-xl bg-yellow-500/10 border border-yellow-500/30 focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 outline-none text-yellow-400 placeholder-yellow-500/50 transition" placeholder="Contoh: A8X991">
                @error('referral_code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                <p class="text-xs text-gray-500 mt-1">*Masukkan kode pengundang Anda jika ada.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-400 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-3 rounded-xl bg-black/30 border border-gray-700 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none text-white transition" placeholder="••••••••">
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-8">
                <label class="block text-gray-400 text-sm font-medium mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required 
                    class="w-full px-4 py-3 rounded-xl bg-black/30 border border-gray-700 focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none text-white transition" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-[0_0_20px_rgba(6,182,212,0.3)] hover:shadow-[0_0_25px_rgba(6,182,212,0.5)] transition transform active:scale-95">
                Daftar Sekarang
            </button>

            <div class="mt-6 text-center text-sm text-gray-400">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-white font-bold hover:text-cyan-400 transition hover:underline">Masuk disini</a>
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