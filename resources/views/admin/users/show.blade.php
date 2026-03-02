@extends('layouts.admin')

@section('title', 'Detail User: ' . $user->name)

@section('content')

    <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white text-sm mb-6 inline-block">&larr; Kembali ke List</a>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="space-y-6">
            <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6 text-center">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-cyan-500 to-blue-600 rounded-full flex items-center justify-center text-4xl font-bold text-white mb-4 shadow-lg shadow-cyan-500/30">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                <p class="text-sm text-cyan-400 font-mono mb-4">{{ $user->role == 'owner' ? '👑 OWNER VIP' : '👤 MEMBER REGULER' }}</p>
                
                <div class="grid grid-cols-2 gap-4 text-left bg-black/20 p-4 rounded-xl border border-gray-700/50">
                    <div>
                        <p class="text-xs text-gray-500">Saldo Dompet</p>
                        <p class="text-lg font-bold text-white">Rp {{ number_format($user->wallet->balance ?? 0) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Status Akun</p>
                        <p class="text-sm font-bold {{ $user->is_active ? 'text-green-500' : 'text-red-500' }}">
                            {{ $user->is_active ? 'AKTIF' : 'DIBLOKIR' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">Informasi Jaringan</h3>
                <div class="space-y-4">
                    <div class="flex justify-between border-b border-gray-800 pb-2">
                        <span class="text-gray-400">Kode Referral</span>
                        <span class="text-white font-mono">{{ $user->referral_code }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-800 pb-2">
                        <span class="text-gray-400">Diajak Oleh (Upline)</span>
                        <span class="text-cyan-400 font-bold">
                            {{ $user->upline->name ?? 'Tidak Ada (Pusat)' }}
                        </span>
                    </div>
                    <div class="flex justify-between border-b border-gray-800 pb-2">
                        <span class="text-gray-400">Jumlah Downline</span>
                        <span class="text-white font-bold">{{ $user->referrals->count() }} Orang</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">Tindakan Manual (Admin Action)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 rounded-xl border font-bold transition {{ $user->is_active ? 'border-red-500/50 text-red-500 hover:bg-red-500 hover:text-white' : 'border-green-500/50 text-green-500 hover:bg-green-500 hover:text-white' }}">
                            {{ $user->is_active ? '⛔ Blokir Akun' : '✅ Aktifkan Akun' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" onsubmit="return confirm('Password akan direset jadi 12345678. Lanjutkan?');">
                        @csrf
                        <button type="submit" class="w-full py-3 rounded-xl border border-yellow-500/50 text-yellow-500 hover:bg-yellow-500 hover:text-black font-bold transition">
                            🔑 Reset Password
                        </button>
                    </form>

                    <button onclick="document.getElementById('balanceModal').classList.remove('hidden')" class="w-full py-3 rounded-xl border border-cyan-500/50 text-cyan-500 hover:bg-cyan-500 hover:text-black font-bold transition">
                        💰 Edit Saldo
                    </button>
                </div>
            </div>

            <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6">
                <h3 class="text-lg font-bold text-white mb-4">10 Transaksi Terakhir</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="text-gray-500 border-b border-gray-700">
                            <tr>
                                <th class="pb-2">Tanggal</th>
                                <th class="pb-2">Tipe</th>
                                <th class="pb-2">Jumlah</th>
                                <th class="pb-2">Ket</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse($transactions as $trx)
                            <tr>
                                <td class="py-3 text-gray-400">{{ $trx->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 capitalize">{{ $trx->type }}</td>
                                <td class="py-3 font-bold {{ in_array($trx->type, ['deposit', 'daily_profit', 'referral_bonus']) ? 'text-green-500' : 'text-red-500' }}">
                                    {{ in_array($trx->type, ['deposit', 'daily_profit', 'referral_bonus']) ? '+' : '-' }}
                                    Rp {{ number_format($trx->amount) }}
                                </td>
                                <td class="py-3 text-gray-500 text-xs truncate max-w-[150px]">{{ $trx->description }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="py-4 text-center text-gray-500">Belum ada transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div id="balanceModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#141625] w-full max-w-md rounded-2xl border border-gray-800 p-6">
            <h3 class="text-xl font-bold text-white mb-4">Edit Saldo Manual</h3>
            <p class="text-sm text-gray-400 mb-4">Gunakan fitur ini hanya untuk keadaan darurat/koreksi. Semua perubahan akan dicatat di log transaksi.</p>
            
            <form action="{{ route('admin.users.update-balance', $user->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-400 text-sm mb-1">Nominal Penyesuaian</label>
                    <input type="number" name="amount" placeholder="Contoh: 50000 atau -50000" required
                        class="w-full bg-black/30 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-cyan-500 outline-none">
                    <p class="text-xs text-gray-500 mt-1">*Gunakan tanda minus (-) untuk mengurangi saldo.</p>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-400 text-sm mb-1">Alasan / Catatan (Wajib)</label>
                    <textarea name="note" required placeholder="Contoh: Koreksi deposit tgl 20..."
                        class="w-full bg-black/30 border border-gray-700 rounded-lg px-4 py-2 text-white focus:border-cyan-500 outline-none"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('balanceModal').classList.add('hidden')" class="w-full py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-bold">Batal</button>
                    <button type="submit" class="w-full py-2 bg-cyan-600 hover:bg-cyan-500 rounded-lg text-white font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection