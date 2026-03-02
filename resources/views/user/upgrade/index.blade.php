@extends('layouts.user')

@section('title', 'Status Owner VIP')

@section('content')

    @if($user->role == 'owner')
        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-white">Kartu Identitas Owner</h2>
            <p class="text-gray-400 text-sm">Kartu keanggotaan resmi komunitas investasi server.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto mb-10 font-sans">

            <div class="relative w-full aspect-[1.586/1] rounded-2xl overflow-hidden shadow-2xl shadow-yellow-600/20 transform transition hover:scale-[1.02] duration-300 border border-yellow-500/40 group bg-black">
                
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-black to-gray-900"></div>
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
                
                <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-yellow-300 via-yellow-500 to-yellow-600"></div>
                <div class="absolute top-0 right-10 w-32 h-full bg-gradient-to-l from-white/5 to-transparent skew-x-12"></div>

                <div class="relative z-10 p-6 md:p-8 flex flex-col justify-between h-full pl-8">
                    
                    <div class="flex justify-between items-start">
                        <img src="{{ asset('assets/img/logo1.png') }}" alt="Logo" class="h-10 object-contain drop-shadow-md">
                        <div class="text-right">
                            <h3 class="text-white font-bold tracking-widest text-xs uppercase opacity-80">Official Member Card</h3>
                            <div class="h-0.5 w-12 bg-yellow-500 ml-auto mt-1"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <h1 class="text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-yellow-400 to-yellow-600 tracking-tighter filter drop-shadow-sm">
                            OWNER
                        </h1>
                        <span class="bg-yellow-500 text-black text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider mt-2">VIP Access</span>
                    </div>

                    <div class="flex items-end justify-between">
                        <div>
                            <p class="text-[9px] text-gray-400 uppercase tracking-widest mb-0.5">Nama Anggota</p>
                            <p class="text-white text-lg font-bold uppercase tracking-wide truncate max-w-[200px]">{{ $user->name }}</p>
                            
                            <div class="flex gap-4 mt-2">
                                <div>
                                    <p class="text-[8px] text-gray-500 uppercase">Member ID</p>
                                    <p class="text-gray-300 font-mono text-xs">{{ str_pad(80102 + $user->id, 6, '0', STR_PAD_LEFT) }}</p>
                                </div>
                                <div>
                                    <p class="text-[8px] text-gray-500 uppercase">Valid Thru</p>
                                    <p class="text-gray-300 font-mono text-xs">LIFETIME</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-20 h-20 rounded-lg border border-yellow-500/30 p-1 bg-gradient-to-br from-gray-800 to-black shadow-lg">
                            @if($user->photo_profile)
                                <img src="{{ $user->photo_profile }}" class="w-full h-full rounded object-cover grayscale hover:grayscale-0 transition duration-500">
                            @else
                                <div class="w-full h-full rounded bg-gray-800 flex items-center justify-center text-white font-bold text-2xl">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative w-full aspect-[1.586/1] rounded-2xl overflow-hidden shadow-2xl shadow-black transform transition hover:scale-[1.02] duration-300 border border-gray-800 bg-[#0f0f0f]">
                
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-10"></div>

                <div class="relative z-10 flex flex-col h-full">
                    
                    <div class="w-full h-10 bg-gradient-to-r from-gray-800 to-gray-900 border-b border-gray-700 flex items-center px-6">
                        <p class="text-[9px] text-gray-400 tracking-widest uppercase">www.investasi-server.com</p>
                    </div>

                    <div class="px-6 py-6 flex-1 flex gap-6 items-center">
                        
                        <div class="bg-white p-2 rounded-lg shadow-inner">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ route('register') }}?ref={{ $user->referral_code }}" class="w-24 h-24">
                        </div>

                        <div class="flex-1 flex flex-col justify-between h-full py-1">
                            <div>
                                <p class="text-white font-bold text-sm mb-1">Syarat & Ketentuan</p>
                                <p class="text-[9px] text-gray-500 leading-relaxed text-justify">
                                    Kartu ini adalah bukti keanggotaan resmi Owner. Kartu ini tidak dapat dipindahtangankan. Gunakan kode QR di samping untuk verifikasi status keanggotaan atau referral link.
                                </p>
                            </div>

                            <div>
                                <p class="text-[8px] text-gray-600 uppercase mb-1">Authorized Signature</p>
                                <div class="h-8 bg-gray-200 rounded flex items-center px-3">
                                    <p class="font-cursive text-black text-sm opacity-80">{{ $user->name }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="w-full h-2 bg-gradient-to-r from-yellow-600 via-yellow-400 to-yellow-600"></div>
                </div>
            </div>

        </div>

        <div class="max-w-md mx-auto space-y-3 px-4">
            <button onclick="window.print()" class="w-full py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                <i class="ph-bold ph-download-simple"></i> Simpan Kartu (PDF/Print)
            </button>
        </div>

    @else

        <div class="text-center mb-8 pt-4">
            <div class="relative w-24 h-24 mx-auto mb-4">
                <div class="absolute inset-0 bg-yellow-500/20 rounded-full blur-xl animate-pulse"></div>
                <div class="relative bg-gradient-to-tr from-yellow-400 to-orange-500 rounded-full w-full h-full flex items-center justify-center shadow-lg shadow-yellow-500/30">
                    <i class="ph-fill ph-crown text-4xl text-white"></i>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-white">Upgrade ke Owner</h2>
            <p class="text-gray-400 text-sm max-w-xs mx-auto">Dapatkan Kartu Eksklusif dan Profit Maksimal.</p>
        </div>

        <div class="bg-[#141625] border border-yellow-500/30 rounded-2xl p-6 mb-8 relative overflow-hidden max-w-lg mx-auto">
            <div class="absolute top-0 right-0 bg-yellow-500 text-black text-xs font-bold px-3 py-1 rounded-bl-xl">PREMIUM</div>
            
            <div class="text-center mb-6">
                <p class="text-gray-400 text-sm mb-1">Harga Upgrade</p>
                <h3 class="text-3xl font-bold text-white">Rp 500.000</h3>
                <p class="text-xs text-yellow-500 mt-1">Sekali bayar, aktif selamanya</p>
            </div>

            <form id="form-upgrade" action="{{ route('user.upgrade.store') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmUpgrade()" class="w-full py-3 bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-400 hover:to-orange-500 text-black font-bold rounded-xl shadow-lg shadow-orange-900/20 transition transform active:scale-95">
                    Beli Status Owner Sekarang
                </button>
            </form>
        </div>

    @endif

@endsection

@push('scripts')
<style>
    /* Font Signature */
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap');
    .font-cursive { font-family: 'Dancing Script', cursive; }

    /* CSS Khusus Print */
    @media print {
        body * { visibility: hidden; }
        .grid, .grid * { visibility: visible; }
        .grid { position: absolute; left: 0; top: 0; width: 100%; }
        button { display: none; }
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>
<script>
    // Logic Upgrade
    function confirmUpgrade() {
        let balance = {{ $user->wallet->balance ?? 0 }};
        let price = 500000;
        if(balance < price) {
            Swal.fire({
                icon: 'error', title: 'Saldo Kurang', text: 'Saldo Anda tidak cukup.',
                background: '#1f2937', color: '#fff', confirmButtonColor: '#0891b2'
            }).then((r) => { if (r.isConfirmed) window.location.href = "{{ route('user.wallet') }}"; });
            return;
        }
        Swal.fire({
            title: 'Konfirmasi Bayar', text: "Upgrade akun seharga Rp 500.000?", icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Bayar', confirmButtonColor: '#eab308',
            background: '#1f2937', color: '#fff'
        }).then((r) => { if (r.isConfirmed) document.getElementById('form-upgrade').submit(); });
    }
</script>
@endpush