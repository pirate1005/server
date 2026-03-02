@extends('layouts.admin')

@section('title', 'Log Absensi Member')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white">Log Absensi & Klaim</h2>
            <p class="text-gray-400 text-sm">Riwayat pengerjaan misi harian member.</p>
        </div>
        <a href="{{ route('admin.missions.index') }}" class="text-gray-400 hover:text-white text-sm">
            &larr; Kembali ke Setting Misi
        </a>
    </div>

    <div class="bg-[#141625] border border-gray-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-800/50 text-gray-400 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Member</th>
                        <th class="px-6 py-4">Server</th>
                        <th class="px-6 py-4">Profit Cair</th>
                        <th class="px-6 py-4">Waktu Klaim</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-sm">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-800/30 transition">
                        <td class="px-6 py-4 font-mono text-gray-300">{{ $log->date->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-bold text-white">{{ $log->investment->user->name ?? 'User Terhapus' }}</td>
                        <td class="px-6 py-4 text-cyan-400">{{ $log->investment->product->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-green-400 font-bold">Rp {{ number_format($log->amount) }}</td>
                        <td class="px-6 py-4 text-gray-400">
                            {{ $log->claimed_at ? $log->claimed_at->format('H:i:s') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($log->status == 'success')
                                <span class="bg-green-500/10 text-green-500 px-2 py-1 rounded text-xs font-bold border border-green-500/20">SUKSES</span>
                            @elseif($log->status == 'expired')
                                <span class="bg-red-500/10 text-red-500 px-2 py-1 rounded text-xs font-bold border border-red-500/20">HANGUS</span>
                            @else
                                <span class="bg-yellow-500/10 text-yellow-500 px-2 py-1 rounded text-xs font-bold border border-yellow-500/20">PENDING</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data klaim misi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-800">
            {{ $logs->links() }}
        </div>
    </div>

@endsection