@extends('layouts.admin')

@section('title', 'Manajemen Iklan')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Daftar Iklan / Banner</h2>
        <button onclick="openModal('createModal')" class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-black font-bold rounded-xl transition shadow-lg shadow-cyan-500/20">
            + Tambah Iklan
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-500 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#141625] border border-gray-800 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-800/50 text-gray-400 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Judul / Info</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($banners as $banner)
                    <tr class="hover:bg-gray-800/30 transition">
                        <td class="px-6 py-4">
                            <img src="{{ asset($banner->image_path) }}" class="h-16 w-32 object-cover rounded-lg border border-gray-700">
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-white">{{ $banner->title ?? 'Tanpa Judul' }}</p>
                            <a href="{{ $banner->target_url ?? '#' }}" target="_blank" class="text-xs text-cyan-400 hover:underline">
                                {{ $banner->target_url ?? 'Tidak ada link target' }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            @if($banner->is_active) 
                                <span class="bg-green-500/10 text-green-500 px-3 py-1 rounded-full text-xs font-bold border border-green-500/20">Aktif</span> 
                            @else 
                                <span class="bg-red-500/10 text-red-500 px-3 py-1 rounded-full text-xs font-bold border border-red-500/20">Mati</span> 
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick='openEditModal(@json($banner))' class="p-2 bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white rounded-lg transition">
                                    ✏️
                                </button>
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus iklan ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada iklan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="createModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#141625] w-full max-w-lg rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Tambah Iklan Baru</h3>
                <button onclick="closeModal('createModal')" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Gambar Iklan <span class="text-red-500">*</span></label>
                    <input type="file" name="image" required class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-cyan-500/10 file:text-cyan-400 border border-gray-700 rounded-lg">
                    <p class="text-[10px] text-gray-500 mt-1">Disarankan gambar format landscape (memanjang).</p>
                </div>
                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Judul Iklan (Opsional)</label>
                    <input type="text" name="title" placeholder="Contoh: Promo Spesial!" class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                </div>
                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Link Target (Opsional)</label>
                    <input type="url" name="target_url" placeholder="https://..." class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                </div>
                <div class="mb-6 bg-black/20 p-4 rounded-lg">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" checked class="w-4 h-4 accent-cyan-500">
                        <span class="text-sm text-gray-300">Tampilkan Iklan Ini</span>
                    </label>
                </div>
                <button type="submit" class="w-full py-3 bg-cyan-500 hover:bg-cyan-600 text-black font-bold rounded-xl transition">Simpan Iklan</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#141625] w-full max-w-lg rounded-2xl border border-gray-800 shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Edit Iklan</h3>
                <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-cyan-500/10 file:text-cyan-400 border border-gray-700 rounded-lg">
                </div>
                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Judul Iklan (Opsional)</label>
                    <input type="text" id="edit_title" name="title" class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                </div>
                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Link Target (Opsional)</label>
                    <input type="url" id="edit_url" name="target_url" class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                </div>
                <div class="mb-6 bg-black/20 p-4 rounded-lg">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="edit_active" name="is_active" class="w-4 h-4 accent-cyan-500">
                        <span class="text-sm text-gray-300">Tampilkan Iklan Ini</span>
                    </label>
                </div>
                <button type="submit" class="w-full py-3 bg-cyan-500 hover:bg-cyan-600 text-black font-bold rounded-xl transition">Update Iklan</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function openEditModal(banner) {
        let form = document.getElementById('editForm');
        form.action = '/admin/banners/' + banner.id;

        document.getElementById('edit_title').value = banner.title || '';
        document.getElementById('edit_url').value = banner.target_url || '';
        document.getElementById('edit_active').checked = banner.is_active;

        openModal('editModal');
    }
</script>
@endpush