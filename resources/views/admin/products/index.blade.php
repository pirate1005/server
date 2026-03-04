@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-white">Daftar Server</h2>
        <button onclick="openModal('createModal')" class="px-6 py-2 bg-cyan-500 hover:bg-cyan-600 text-black font-bold rounded-xl transition shadow-lg shadow-cyan-500/20">
            + Tambah Server
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
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Profit</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-800/30 transition">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/50' }}" class="w-10 h-10 rounded-lg object-cover bg-gray-700">
                            <div>
                                <p class="font-bold text-white">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->contract_days }} Hari</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-cyan-400">Rp {{ number_format($product->daily_income, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @if($product->is_owner_product) <span class="text-[10px] bg-yellow-500/10 text-yellow-500 px-2 py-1 rounded border border-yellow-500/20">AUTO OWNER</span> @endif
                            @if($product->is_exclusive_for_owner) <span class="text-[10px] bg-purple-500/10 text-purple-500 px-2 py-1 rounded border border-purple-500/20">VIP</span> @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick='openEditModal(@json($product))' class="p-2 bg-blue-500/10 text-blue-500 hover:bg-blue-500 hover:text-white rounded-lg transition">
                                    ✏️
                                </button>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus server ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded-lg transition">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Data kosong.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="createModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#141625] w-full max-w-2xl rounded-2xl border border-gray-800 shadow-2xl overflow-y-auto max-h-[90vh]">
            <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Tambah Server Baru</h3>
                <button onclick="closeModal('createModal')" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6" onsubmit="return cleanRupiahBeforeSubmit(this)">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Nama Server</label>
                        <input type="text" name="name" required class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Harga (Rp)</label>
                        <input type="text" name="price" required class="input-rupiah w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white font-bold tracking-wider">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Profit Harian (Rp)</label>
                        <input type="text" name="daily_income" required class="input-rupiah w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white font-bold tracking-wider">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Durasi (Hari)</label>
                        <input type="number" name="contract_days" required class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Bonus Reward</label>
                    <input type="text" name="bonus_reward" class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Deskripsi</label>
                    <textarea name="description" rows="2" class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white"></textarea>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Gambar</label>
                    <input type="file" name="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-cyan-500/10 file:text-cyan-400 border border-gray-700 rounded-lg">
                </div>

                <div class="space-y-2 mb-6 bg-black/20 p-4 rounded-lg">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" checked class="w-4 h-4 accent-cyan-500">
                        <span class="text-sm text-gray-300">Aktifkan Produk</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_owner_product" class="w-4 h-4 accent-yellow-500">
                        <span class="text-sm text-yellow-500 font-bold">Auto Become Owner</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_exclusive_for_owner" class="w-4 h-4 accent-purple-500">
                        <span class="text-sm text-purple-500 font-bold">VIP Only</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 bg-cyan-500 hover:bg-cyan-600 text-black font-bold rounded-xl transition">Simpan</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#141625] w-full max-w-2xl rounded-2xl border border-gray-800 shadow-2xl overflow-y-auto max-h-[90vh]">
            <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Edit Server</h3>
                <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6" onsubmit="return cleanRupiahBeforeSubmit(this)">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Nama Server</label>
                        <input type="text" id="edit_name" name="name" required class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Harga (Rp)</label>
                        <input type="text" id="edit_price" name="price" required class="input-rupiah w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white font-bold tracking-wider">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Profit Harian (Rp)</label>
                        <input type="text" id="edit_income" name="daily_income" required class="input-rupiah w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white font-bold tracking-wider">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Durasi (Hari)</label>
                        <input type="number" id="edit_days" name="contract_days" required class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Bonus Reward</label>
                    <input type="text" id="edit_bonus" name="bonus_reward" class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white">
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Deskripsi</label>
                    <textarea id="edit_desc" name="description" rows="2" class="w-full bg-[#0B0C15] border border-gray-700 rounded-lg px-4 py-2 focus:border-cyan-500 outline-none text-white"></textarea>
                </div>

                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-1 block">Ganti Gambar (Opsional)</label>
                    <input type="file" name="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-cyan-500/10 file:text-cyan-400 border border-gray-700 rounded-lg">
                </div>

                <div class="space-y-2 mb-6 bg-black/20 p-4 rounded-lg">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="edit_active" name="is_active" class="w-4 h-4 accent-cyan-500">
                        <span class="text-sm text-gray-300">Aktifkan Produk</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="edit_owner_prod" name="is_owner_product" class="w-4 h-4 accent-yellow-500">
                        <span class="text-sm text-yellow-500 font-bold">Auto Become Owner</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="edit_vip_only" name="is_exclusive_for_owner" class="w-4 h-4 accent-purple-500">
                        <span class="text-sm text-purple-500 font-bold">VIP Only</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 bg-cyan-500 hover:bg-cyan-600 text-black font-bold rounded-xl transition">Update Perubahan</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // FUNGSI UNTUK MENGUBAH ANGKA JADI FORMAT TITIK (1.000.000)
    function formatRupiah(angka) {
        // PERBAIKAN: Hapus desimal (.00) bawaan database jika ada
        let angkaTanpaDesimal = angka.toString().split('.')[0]; 
        
        let number_string = angkaTanpaDesimal.replace(/[^,\d]/g, ''),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }

    // PASANG EVENT LISTENER KE SEMUA INPUT RUPIAH
    document.querySelectorAll('.input-rupiah').forEach(function(input) {
        input.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value);
        });
    });

    // FUNGSI UNTUK MEMBERSIHKAN TITIK SEBELUM FORM DISUBMIT KE SERVER
    function cleanRupiahBeforeSubmit(form) {
        let inputs = form.querySelectorAll('.input-rupiah');
        inputs.forEach(function(input) {
            // Hapus semua titik (1.000.000 jadi 1000000)
            input.value = input.value.replace(/\./g, '');
        });
        return true; 
    }

    // FUNGSI BUKA MODAL
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // FUNGSI UNTUK MENGISI DATA KE MODAL EDIT
    function openEditModal(product) {
        let form = document.getElementById('editForm');
        form.action = '/admin/products/' + product.id;

        document.getElementById('edit_name').value = product.name;
        
        // PERBAIKAN: Pastikan memanggil formatRupiah agar desimalnya terhapus & dikasih titik
        document.getElementById('edit_price').value = formatRupiah(product.price);
        document.getElementById('edit_income').value = formatRupiah(product.daily_income);
        
        document.getElementById('edit_days').value = product.contract_days;
        document.getElementById('edit_bonus').value = product.bonus_reward || '';
        document.getElementById('edit_desc').value = product.description || '';

        document.getElementById('edit_active').checked = product.is_active;
        document.getElementById('edit_owner_prod').checked = product.is_owner_product;
        document.getElementById('edit_vip_only').checked = product.is_exclusive_for_owner;

        openModal('editModal');
    }
</script>
@endpush