@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white">Data Member</h2>
            <p class="text-gray-400 text-sm">Kelola akses dan data member terdaftar.</p>
        </div>
        <form action="{{ route('admin.users.index') }}" method="GET" class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / WA..." 
                class="bg-[#141625] border border-gray-700 text-white px-4 py-2 rounded-xl focus:border-cyan-500 outline-none w-64">
            <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-white">🔍</button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl">{{ session('success') }}</div>
    @endif

    <div class="bg-[#141625] border border-gray-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-800/50 text-gray-400 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4">Member</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Saldo</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800 text-sm">
                    @forelse($users as $u)
                    <tr class="hover:bg-gray-800/30 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center font-bold text-white">
                                    {{ substr($u->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-white">{{ $u->name }}</p>
                                    <p class="text-xs text-gray-500">Join: {{ $u->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-300">{{ $u->whatsapp }}</p>
                            <p class="text-xs text-gray-500">{{ $u->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($u->role == 'owner')
                                <span class="bg-yellow-500/10 text-yellow-500 px-2 py-1 rounded text-xs font-bold border border-yellow-500/20">OWNER VIP</span>
                            @else
                                <span class="bg-blue-500/10 text-blue-400 px-2 py-1 rounded text-xs font-bold border border-blue-500/20">MEMBER</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-white">
                            Rp {{ number_format($u->wallet->balance ?? 0) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($u->is_active)
                                <span class="text-green-500 text-xs font-bold">● Aktif</span>
                            @else
                                <span class="text-red-500 text-xs font-bold">● BANNED</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.users.show', $u->id) }}" class="px-3 py-1.5 bg-gray-700 hover:bg-cyan-600 hover:text-black text-white rounded-lg text-xs font-bold transition">
                                Detail / Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada user ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-800">{{ $users->links() }}</div>
    </div>

@endsection