@extends('layouts.user')

@section('title', 'Server Saya')

@section('content')

    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Portofolio Server</h2>
            <p class="text-gray-400 text-sm">Monitor aset dan progress kontrak Anda.</p>
        </div>
        <a href="{{ route('user.products.index') }}" class="bg-cyan-600 hover:bg-cyan-500 text-white px-4 py-2 rounded-xl text-sm font-bold shadow-lg shadow-cyan-900/20 transition">
            + Sewa Baru
        </a>
    </div>

    <div class="space-y-6 pb-20">
        @forelse($investments as $inv)
            @php
                // Pakai Timezone Asia/Jakarta
                $startDate = \Carbon\Carbon::parse($inv->start_date)->timezone('Asia/Jakarta');
                $endDate = \Carbon\Carbon::parse($inv->end_date)->timezone('Asia/Jakarta');
                $now = now()->timezone('Asia/Jakarta');

                $totalDays = $startDate->diffInDays($endDate);
                
                // Hari berjalan (cegah minus atau lebih dari total)
                $daysRunning = max(0, min($totalDays, $startDate->diffInDays($now)));
                
                // Persentase
                $progress = $totalDays > 0 ? ($daysRunning / $totalDays) * 100 : 0;
                
                // PERBAIKAN: Hitung Total Cuan Langsung dari Database
                $totalEarned = \App\Models\DailyClaim::where('investment_id', $inv->id)
                                                     ->where('status', 'success')
                                                     ->sum('amount');
            @endphp

            <div class="relative bg-[#141625] border {{ $inv->status == 'active' ? 'border-cyan-500/30' : 'border-gray-800' }} rounded-2xl p-5 overflow-hidden transition hover:-translate-y-1">
                
                @if($inv->status == 'active')
                    <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                @endif

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $inv->product->image ?? 'https://via.placeholder.com/50' }}" class="w-12 h-12 rounded-lg bg-gray-800 object-cover">
                            <div>
                                <h3 class="font-bold text-white text-lg">{{ $inv->product->name }}</h3>
                                <p class="text-xs text-gray-400">ID: #INV-{{ str_pad($inv->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        
                        @if($inv->status == 'active')
                            <span class="bg-green-500/10 text-green-500 px-3 py-1 rounded-full text-xs font-bold border border-green-500/20 blink-soft">
                                ● Running
                            </span>
                        @elseif($inv->status == 'pending')
                            <span class="bg-yellow-500/10 text-yellow-500 px-3 py-1 rounded-full text-xs font-bold border border-yellow-500/20">
                                ● Pending
                            </span>
                        @else
                            <span class="bg-red-500/10 text-red-500 px-3 py-1 rounded-full text-xs font-bold border border-red-500/20">
                                ● Expired
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4 bg-black/20 p-3 rounded-xl border border-gray-700/30">
                        <div>
                            <p class="text-[10px] text-gray-500 uppercase">Profit Harian</p>
                            <p class="text-sm font-bold text-cyan-400">Rp {{ number_format($inv->product->daily_income, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] text-gray-500 uppercase">Total Didapat</p>
                            <p class="text-sm font-bold text-green-400">Rp {{ number_format($totalEarned, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="flex justify-between text-xs text-gray-400 mb-1">
                            <span>Progress Kontrak</span>
                            <span>{{ floor($daysRunning) }} / {{ $totalDays }} Hari</span>
                        </div>
                        <div class="w-full bg-gray-700 h-2 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-cyan-500 to-blue-500 h-full rounded-full transition-all duration-1000" style="width: {{ $progress }}%"></div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-1 text-right">
                            Berakhir: {{ $endDate->translatedFormat('d F Y H:i') }} WIB
                        </p>
                    </div>

                    @if($inv->status == 'active')
                        <a href="{{ route('user.missions.index') }}" class="block w-full py-3 bg-white text-black font-bold text-center rounded-xl hover:bg-gray-200 transition shadow-lg mt-4">
                            <i class="ph-fill ph-play-circle align-middle"></i> Akses Misi Harian
                        </a>
                    @elseif($inv->status == 'expired')
                        <a href="{{ route('user.products.index') }}" class="block w-full py-3 bg-gray-700 text-gray-300 font-bold text-center rounded-xl hover:bg-gray-600 transition mt-4">
                            🔄 Perpanjang Sewa
                        </a>
                    @endif
                </div>
            </div>

        @empty
            <div class="text-center py-16 bg-[#141625] rounded-2xl border border-gray-800 border-dashed">
                <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-500">
                    <i class="ph-fill ph-hard-drives text-3xl"></i>
                </div>
                <h3 class="text-white font-bold mb-2">Belum Ada Server</h3>
                <p class="text-gray-400 text-sm mb-6 max-w-xs mx-auto">Anda belum menyewa server apapun. Mulai sewa server sekarang untuk dapat profit.</p>
                <a href="{{ route('user.products.index') }}" class="px-6 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-xl shadow-lg transition">
                    Lihat Daftar Server
                </a>
            </div>
        @endforelse
    </div>

    <style>
        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .blink-soft {
            animation: pulse-soft 2s infinite;
        }
    </style>

@endsection