@extends('layouts.admin')

@section('title', 'Laporan Referral')

@section('content')

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Pohon Jaringan (Referral)</h2>
        <p class="text-gray-400 text-sm">Lihat siapa leader yang paling aktif mengajak member baru.</p>
    </div>

    <div class="space-y-4">
        @forelse($leaders as $leader)
            <div class="bg-[#141625] border border-gray-800 rounded-2xl overflow-hidden transition hover:border-cyan-500/30">
                
                <details class="group">
                    <summary class="flex items-center justify-between p-6 cursor-pointer list-none">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center font-bold text-white shadow-lg">
                                {{ substr($leader->name, 0, 1) }}
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-bold text-white group-hover:text-cyan-400 transition">{{ $leader->name }}</h3>
                                <p class="text-xs text-gray-400">Kode: <span class="font-mono text-yellow-500">{{ $leader->referral_code }}</span></p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <div class="text-right">
                                <p class="text-xs text-gray-500">Total Downline</p>
                                <p class="text-xl font-bold text-white">{{ $leader->referrals_count }} <span class="text-sm font-normal text-gray-500">Member</span></p>
                            </div>
                            <span class="transition group-open:rotate-180">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </span>
                        </div>
                    </summary>

                    <div class="border-t border-gray-800 bg-black/20 p-6 animate-fade-in-down">
                        <h4 class="text-sm font-bold text-gray-400 mb-4 uppercase tracking-wider">Daftar Member yang diajak:</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($leader->referrals as $downline)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-[#0B0C15] border border-gray-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs text-white">
                                            {{ substr($downline->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-white">{{ $downline->name }}</p>
                                            <p class="text-[10px] text-gray-500">Join: {{ $downline->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs px-2 py-1 rounded {{ $downline->is_active ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                        {{ $downline->is_active ? 'Aktif' : 'Banned' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </details>
            </div>
        @empty
            <div class="p-8 text-center text-gray-500 bg-[#141625] rounded-2xl">
                Belum ada data referral.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $leaders->links() }}
    </div>

@endsection