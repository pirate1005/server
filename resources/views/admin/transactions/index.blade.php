@extends('layouts.admin')

@section('title', 'Kelola Transaksi')

@section('content')

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Permintaan Deposit & Withdraw</h2>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs uppercase">
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">User</th>
                        <th class="p-4">Tipe</th>
                        <th class="p-4">Jumlah</th>
                        <th class="p-4">Info / Bukti</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50/50">
                            <td class="p-4 text-sm text-gray-600">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td class="p-4">
                                <p class="font-bold text-gray-800 text-sm">{{ $trx->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $trx->user->email }}</p>
                            </td>
                            <td class="p-4">
                                @if($trx->type == 'deposit')
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-bold">Deposit</span>
                                @else
                                    <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-bold">Withdraw</span>
                                @endif
                            </td>
                            <td class="p-4 font-bold text-gray-800">
                                Rp {{ number_format($trx->amount) }}
                            </td>
                            <td class="p-4">
                                @if($trx->type == 'deposit' && $trx->payment_proof)
                                    <a href="{{ asset($trx->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline text-xs flex items-center gap-1">
                                        <i class="ph-bold ph-image"></i> Lihat Bukti
                                    </a>
                                @elseif($trx->type == 'withdraw')
                                    <div class="text-xs text-gray-600">
                                        <p class="font-bold">{{ $trx->user->bank_name }}</p>
                                        <p>{{ $trx->user->account_number }}</p>
                                        <p>a.n {{ $trx->user->account_holder }}</p>
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="p-4">
                                @if($trx->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-bold">Pending</span>
                                @elseif($trx->status == 'success')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Success</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Failed</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                @if($trx->status == 'pending')
                                    <div class="flex justify-end gap-2">
                                        <form action="{{ route('admin.transactions.approve', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin setujui transaksi ini?');">
                                            @csrf
                                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded text-xs font-bold transition">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.transactions.reject', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin tolak transaksi ini?');">
                                            @csrf
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs font-bold transition">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500">Belum ada transaksi deposit/withdraw.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>

@endsection