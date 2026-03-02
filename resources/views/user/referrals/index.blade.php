@extends('layouts.user')

@section('title', 'Undang Teman')

@section('content')

    <div class="text-center mb-8 pt-4">
        <div class="relative w-24 h-24 mx-auto mb-4">
            <div class="absolute inset-0 bg-green-500/20 rounded-full blur-xl animate-pulse"></div>
            <div class="relative bg-gradient-to-tr from-green-400 to-cyan-500 rounded-full w-full h-full flex items-center justify-center shadow-lg shadow-green-500/30">
                <i class="ph-fill ph-gift text-4xl text-white animate-bounce-slow"></i>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-white">Program Referral</h2>
        <p class="text-gray-400 text-sm max-w-xs mx-auto">Dapatkan komisi dari setiap teman yang Anda undang.</p>
    </div>

    @if($user->role == 'owner')

        <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6 mb-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl -mr-10 -mt-10"></div>

            <label class="text-xs text-gray-400 uppercase font-bold mb-2 block">Kode Referral Anda</label>
            
            <div class="flex gap-2 mb-4">
                <div class="relative flex-1">
                    <input type="text" id="ref-code" value="{{ $user->referral_code }}" readonly 
                        class="w-full bg-black/30 border border-gray-700 text-center text-cyan-400 font-mono font-bold text-xl rounded-xl py-3 tracking-widest focus:outline-none">
                </div>
                <button onclick="copyToClipboard('{{ $user->referral_code }}')" class="bg-gray-700 hover:bg-gray-600 text-white px-4 rounded-xl transition">
                    <i class="ph-bold ph-copy"></i>
                </button>
            </div>

            <button onclick="shareLink()" class="w-full py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white font-bold rounded-xl shadow-lg shadow-green-900/20 flex items-center justify-center gap-2 transition">
                <i class="ph-bold ph-share-network"></i> Bagikan Link Pendaftaran
            </button>
            
            <input type="hidden" id="ref-link" value="{{ route('register') }}?ref={{ $user->referral_code }}">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-[#141625] p-4 rounded-2xl border border-gray-800 text-center">
                <p class="text-gray-400 text-xs mb-1">Total Teman</p>
                <p class="text-2xl font-bold text-white">{{ $referrals->count() }} <span class="text-sm font-normal text-gray-500">Orang</span></p>
            </div>
            <div class="bg-[#141625] p-4 rounded-2xl border border-gray-800 text-center">
                <p class="text-gray-400 text-xs mb-1">Status Akun</p>
                <p class="text-sm font-bold text-yellow-400 mt-1">
                    👑 OWNER VIP
                </p>
            </div>
        </div>

        <h3 class="font-bold text-white mb-4 pl-2 border-l-4 border-green-500">Daftar Teman (Downline)</h3>
        <div class="space-y-3 pb-24">
            @forelse($referrals as $ref)
                <div class="flex items-center justify-between bg-[#141625] p-4 rounded-xl border border-gray-800 hover:border-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center text-white font-bold">
                            {{ substr($ref->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-white text-sm font-bold">{{ $ref->name }}</p>
                            <p class="text-gray-500 text-[10px]">Gabung: {{ $ref->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($ref->is_active)
                            <span class="bg-green-500/10 text-green-500 px-2 py-1 rounded text-[10px] font-bold border border-green-500/20">AKTIF</span>
                        @else
                            <span class="bg-red-500/10 text-red-500 px-2 py-1 rounded text-[10px] font-bold border border-red-500/20">BANNED</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-[#141625]/50 rounded-2xl border border-gray-800 border-dashed">
                    <i class="ph-duotone ph-users-three text-4xl text-gray-600 mb-3"></i>
                    <p class="text-gray-400 text-sm">Belum ada teman yang bergabung.</p>
                    <p class="text-gray-600 text-xs mt-1">Ayo bagikan kodemu sekarang!</p>
                </div>
            @endforelse
        </div>

    @else

        <div class="bg-[#141625] border border-gray-800 rounded-2xl p-8 text-center relative overflow-hidden">
            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6 relative z-10">
                <i class="ph-fill ph-lock-key text-4xl text-gray-500"></i>
            </div>

            <h3 class="text-xl font-bold text-white mb-2">Fitur Terkunci</h3>
            <p class="text-gray-400 text-sm mb-6 leading-relaxed">
                Maaf, akses kode referral dan komisi hanya tersedia khusus untuk Member berstatus <span class="text-yellow-500 font-bold">OWNER VIP</span>.
            </p>

            <div class="space-y-3">
                <a href="{{ route('user.upgrade') }}" class="block w-full py-3 bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-400 hover:to-orange-500 text-black font-bold rounded-xl shadow-lg shadow-orange-900/20 transition transform active:scale-95">
                    Upgrade ke Owner Sekarang
                </a>
                <a href="{{ route('dashboard') }}" class="block w-full py-3 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl transition">
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
        </div>

    @endif


    @if($user->role == 'owner')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text);
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Kode Referral disalin!',
                showConfirmButton: false,
                timer: 3000,
                background: '#1f2937',
                color: '#fff'
            });
        }

        function shareLink() {
            var link = document.getElementById('ref-link').value;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Gabung CloudMax',
                    text: 'Ayo sewa server dan dapatkan profit harian! Gunakan kode: {{ $user->referral_code }}',
                    url: link,
                })
                .then(() => console.log('Successful share'))
                .catch((error) => console.log('Error sharing', error));
            } else {
                navigator.clipboard.writeText(link);
                Swal.fire({
                    icon: 'success',
                    title: 'Link Disalin!',
                    text: 'Bagikan link ini ke teman Anda.',
                    background: '#1f2937',
                    color: '#fff'
                });
            }
        }
    </script>
    @endif

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-bounce-slow { animation: bounce-slow 2s infinite ease-in-out; }
    </style>

@endsection