@extends('layouts.user')

@section('title', 'Akun Saya')

@section('content')

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Pengaturan Akun</h2>
        <p class="text-gray-400 text-sm">Update data diri dan informasi pembayaran.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl text-sm font-bold animate-pulse">
            ✅ {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-500 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-6 max-w-2xl mx-auto">

        <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6">
            <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <i class="ph-fill ph-user-circle text-cyan-400"></i> Data Diri & Bank
            </h3>
            
            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="flex flex-col items-center gap-6 mb-8 border-b border-gray-800 pb-8">
                    
                    <div class="relative w-48 h-48 group">
                        
                        <img id="preview-img" 
                             src="{{ $user->photo_profile ?? '#' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-cyan-500 shadow-2xl shadow-cyan-500/30 {{ $user->photo_profile ? '' : 'hidden' }}">

                        <div id="preview-initials" 
                             class="w-full h-full rounded-full bg-gray-800 flex items-center justify-center text-6xl font-bold text-white border-4 border-gray-700 {{ $user->photo_profile ? 'hidden' : '' }}">
                            {{ substr($user->name, 0, 1) }}
                        </div>

                        <label class="absolute bottom-2 right-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white p-3 rounded-full cursor-pointer hover:scale-110 transition shadow-lg border-4 border-[#141625]">
                            <i class="ph-bold ph-camera text-xl"></i>
                            <input type="file" name="photo_profile" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>

                    <div class="text-center">
                        <p class="text-xl font-bold text-white mb-1">Foto Profil</p>
                        <p class="text-sm text-gray-400 mb-3">Klik ikon kamera untuk mengganti.</p>
                        <span class="inline-block px-4 py-1 bg-yellow-500/10 border border-yellow-500/30 rounded-full text-xs text-yellow-500 font-bold">
                            Maksimal Upload: 10 MB
                        </span>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 outline-none transition">
                    </div>
                    
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Email (Tidak bisa diubah)</label>
                        <input type="email" value="{{ $user->email }}" disabled class="w-full bg-[#0B0C15]/50 border border-gray-800 rounded-xl px-4 py-3 text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ $user->whatsapp }}" class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 outline-none transition">
                    </div>

                    <div class="pt-6 border-t border-gray-800">
                        <p class="text-yellow-500 text-sm font-bold mb-4 flex items-center gap-2 bg-yellow-500/5 p-3 rounded-lg border border-yellow-500/20">
                            <i class="ph-fill ph-bank text-lg"></i> Rekening Pencairan (Withdraw)
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="text-xs text-gray-400 mb-1 block">Nama Bank / E-Wallet</label>
                                <input type="text" name="bank_name" value="{{ $user->bank_name }}" placeholder="Contoh: BCA / DANA" class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 outline-none transition">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">Nomor Rekening</label>
                                <input type="number" name="account_number" value="{{ $user->account_number }}" placeholder="08xxxxx / 123xxxx" class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 outline-none transition">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400 mb-1 block">Atas Nama</label>
                                <input type="text" name="account_holder" value="{{ $user->account_holder }}" placeholder="Nama Pemilik" class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 outline-none transition">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold text-lg rounded-xl transition shadow-xl shadow-cyan-900/30 transform active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <i class="ph-fill ph-lock-key text-red-400"></i> Keamanan
            </h3>

            <form action="{{ route('user.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-red-500 outline-none transition">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Password Baru</label>
                        <input type="password" name="password" class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-red-500 outline-none transition">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-red-500 outline-none transition">
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full py-3 bg-gray-800 hover:bg-gray-700 border border-gray-600 text-white font-bold rounded-xl transition">
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center pt-4 pb-12">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500 font-bold text-sm hover:underline">
                    Keluar dari Aplikasi
                </button>
            </form>
            <p class="text-gray-600 text-xs mt-2">Versi Aplikasi 1.0.0</p>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    // FUNGSI PREVIEW GAMBAR (LANGSUNG MUNCUL)
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = document.getElementById('preview-img');
                var initials = document.getElementById('preview-initials');

                // Update src gambar
                img.src = e.target.result;
                
                // Tampilkan img, sembunyikan inisial
                img.classList.remove('hidden');
                if(initials) {
                    initials.classList.add('hidden');
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush