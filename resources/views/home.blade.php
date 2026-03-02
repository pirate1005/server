@extends('layouts.app')

@section('content')

<div class="relative py-20 lg:py-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center">
        
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 text-xs font-semibold uppercase tracking-wider mb-8 animate-float">
            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
            Server IBM Batch 2026 Tersedia
        </div>

        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-tight mb-6">
            Miliki Server Digital <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 animate-gradient">
                Profit Tiap Hari.
            </span>
        </h1>
        
        <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
            Sistem penyewaan server otomatis. Kerjakan misi video harian, input kode unik, dan tarik keuntungan Anda langsung ke dompet digital.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#server-list" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold rounded-xl shadow-[0_10px_40px_-10px_rgba(6,182,212,0.5)] hover:shadow-[0_20px_60px_-15px_rgba(6,182,212,0.6)] hover:-translate-y-1 transition-all duration-300">
                Mulai Sewa Server 🚀
            </a>
            <a href="#about-us" class="w-full sm:w-auto px-8 py-4 bg-white/5 border border-white/10 text-white font-semibold rounded-xl hover:bg-white/10 transition backdrop-blur-sm">
                Pelajari Cara Kerja
            </a>
        </div>

        <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-white/5 pt-12">
            <div>
                <p class="text-3xl font-bold text-white mb-1">25K+</p>
                <p class="text-sm text-gray-500">Active Members</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-white mb-1">Rp 12M+</p>
                <p class="text-sm text-gray-500">Total Payout</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-white mb-1">500+</p>
                <p class="text-sm text-gray-500">Server Units</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-white mb-1">24/7</p>
                <p class="text-sm text-gray-500">Support System</p>
            </div>
        </div>
    </div>
</div>


@if(isset($about) && $about)
<div id="about-us" class="relative py-24 bg-[#0B0C15] border-t border-gray-800 overflow-hidden">
    <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-900/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-900/10 rounded-full blur-3xl -ml-20 -mb-20"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            
            <div class="flex-1 space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-gray-300 text-xs font-bold uppercase tracking-widest">
                    <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Informasi Platform
                </div>
                
                <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight">
                    {{ $about->title }}
                </h2>
                
                <div class="text-gray-400 text-lg leading-relaxed space-y-4">
                    {!! nl2br(e($about->content)) !!}
                </div>
            </div>

            @if($about->image_path)
            <div class="flex-1 w-full lg:w-1/2">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-gray-800 group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500/20 to-purple-500/20 mix-blend-overlay group-hover:opacity-0 transition duration-700 z-10"></div>
                    
                    <img src="{{ asset($about->image_path) }}" alt="{{ $about->title }}" class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-700 relative z-0">
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endif


<div id="server-list" class="relative py-24 bg-[#141625]/50 border-t border-gray-800">
    <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-cyan-500/50 to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Pilih Paket Server</h2>
                <p class="text-gray-400 max-w-lg">
                    Tersedia berbagai spesifikasi server mulai dari entry-level hingga kelas enterprise khusus Owner.
                </p>
            </div>
            <div class="flex gap-2 p-1 bg-white/5 rounded-lg border border-white/10">
                <button class="px-4 py-2 text-xs font-bold bg-cyan-600 rounded text-white">All Servers</button>
                <button class="px-4 py-2 text-xs font-bold text-gray-400 hover:text-white transition">VIP Only</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
                @php
                    $isOwner = $product->is_owner_product;
                    $isExclusive = $product->is_exclusive_for_owner;
                    
                    // Card Styling Logic
                    if($isOwner) {
                        $cardBorder = 'border-yellow-500/30 hover:border-yellow-500/60 shadow-[0_0_30px_-5px_rgba(234,179,8,0.15)]';
                        $bgGradient = 'bg-gradient-to-b from-yellow-500/5 to-transparent';
                        $btnColor = 'bg-yellow-500 text-black hover:bg-yellow-400 shadow-[0_0_20px_rgba(234,179,8,0.4)]';
                        $iconColor = 'text-yellow-400 bg-yellow-400/10 border-yellow-500/20';
                    } elseif($isExclusive) {
                        $cardBorder = 'border-purple-500/30 hover:border-purple-500/60 shadow-[0_0_30px_-5px_rgba(168,85,247,0.15)]';
                        $bgGradient = 'bg-gradient-to-b from-purple-500/5 to-transparent';
                        $btnColor = 'bg-purple-600 text-white hover:bg-purple-500 shadow-[0_0_20px_rgba(168,85,247,0.4)]';
                        $iconColor = 'text-purple-400 bg-purple-400/10 border-purple-500/20';
                    } else {
                        $cardBorder = 'border-white/10 hover:border-cyan-500/50 hover:shadow-[0_0_30px_-5px_rgba(6,182,212,0.15)]';
                        $bgGradient = 'bg-white/[0.02]';
                        $btnColor = 'bg-white text-black hover:bg-cyan-50 shadow-[0_0_15px_rgba(255,255,255,0.2)]';
                        $iconColor = 'text-cyan-400 bg-cyan-400/10 border-cyan-500/20';
                    }

                    // --- LOGIKA FORMAT ANGKA PROFIT PINTAR ---
                    $profit = $product->daily_income;
                    if ($profit >= 1000000) {
                        $formattedProfit = ($profit % 1000000 === 0) 
                                           ? number_format($profit / 1000000, 0) . ' Juta'
                                           : number_format($profit / 1000000, 1, ',', '.') . ' Juta';
                    } elseif ($profit >= 1000) {
                        $formattedProfit = number_format($profit / 1000, 0) . 'rb';
                    } else {
                        $formattedProfit = number_format($profit);
                    }
                @endphp

                <div class="group relative rounded-3xl border {{ $cardBorder }} {{ $bgGradient }} backdrop-blur-sm p-8 transition-all duration-300 hover:-translate-y-2 flex flex-col h-full overflow-hidden">
                    
                    <div class="absolute -inset-px bg-gradient-to-r from-cyan-500 to-purple-500 rounded-3xl opacity-0 group-hover:opacity-10 transition duration-500 -z-10"></div>

                    <div class="flex justify-between items-start mb-6">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl border {{ $iconColor }}">
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/50' }}" class="w-8 h-8 object-contain drop-shadow-lg">
                        </div>
                        
                        @if($isOwner)
                            <span class="px-3 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 text-[10px] font-bold uppercase tracking-wider">
                                🔥 Auto Owner
                            </span>
                        @elseif($isExclusive)
                            <span class="px-3 py-1 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[10px] font-bold uppercase tracking-wider">
                                🔒 VIP Only
                            </span>
                        @endif
                    </div>

                    <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-400 text-sm mb-6 line-clamp-2">{{ $product->description }}</p>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="p-4 rounded-2xl bg-black/20 border border-white/5">
                            <p class="text-xs text-gray-500 mb-1">Profit Harian</p>
                            <p class="text-sm font-bold {{ $isOwner ? 'text-yellow-400' : ($isExclusive ? 'text-purple-400' : 'text-cyan-400') }}">
                                Rp {{ $formattedProfit }}
                            </p>
                        </div>
                        <div class="p-4 rounded-2xl bg-black/20 border border-white/5">
                            <p class="text-xs text-gray-500 mb-1">Durasi</p>
                            <p class="text-sm font-bold text-white">{{ $product->contract_days }} Hari</p>
                        </div>
                        <div class="col-span-2 p-4 rounded-2xl bg-black/20 border border-white/5 flex justify-between items-center">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga Sewa</p>
                                <p class="text-base font-bold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 mb-1">Total Return</p>
                                <p class="text-base font-bold text-green-400">Rp {{ number_format(($product->daily_income * $product->contract_days), 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    @if($product->bonus_reward)
                        <div class="mb-6 flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-yellow-500/10 to-transparent border-l-2 border-yellow-500">
                            <span class="text-xl">🎁</span>
                            <div>
                                <p class="text-[10px] text-yellow-500 font-bold uppercase">Bonus Reward</p>
                                <p class="text-xs text-gray-300">{{ $product->bonus_reward }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-auto">
                        @auth
                            @php
                                $isLocked = $isExclusive && auth()->user()->role == 'member';
                            @endphp

                            @if($isLocked)
                                <button disabled class="w-full py-4 rounded-xl bg-white/5 border border-white/10 text-gray-500 font-bold cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Terkunci (Khusus Owner)
                                </button>
                            @else
                                <form action="{{ route('order.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button class="w-full py-4 rounded-xl font-bold transition-all duration-300 {{ $btnColor }} flex items-center justify-center gap-2 group-hover:scale-[1.02]">
                                        Sewa Sekarang
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4-4m4-4H3"></path></svg>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center py-4 rounded-xl border border-white/20 hover:border-white text-gray-300 hover:text-white font-bold transition bg-white/5 hover:bg-white/10">
                                Login untuk Sewa
                            </a>
                        @endauth
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection