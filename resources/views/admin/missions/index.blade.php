@extends('layouts.admin')

@section('title', 'Manajemen Misi Harian')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white">Atur Misi Video</h2>
            <p class="text-gray-400 text-sm">Update link video dan kunci jawaban untuk member setiap hari.</p>
        </div>
        <a href="{{ route('admin.missions.logs') }}" class="px-6 py-2 bg-gray-800 hover:bg-gray-700 text-white font-bold rounded-xl border border-gray-700 transition">
            📜 Lihat Log Absensi
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl flex items-center gap-3">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($products as $product)
            <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6 hover:border-cyan-500/30 transition group">
                
                <div class="flex items-center gap-4 mb-4">
                    <img src="{{ $product->image ?? 'https://via.placeholder.com/50' }}" class="w-12 h-12 rounded-lg bg-gray-700 object-cover">
                    <div>
                        <h3 class="font-bold text-lg text-white group-hover:text-cyan-400 transition">{{ $product->name }}</h3>
                        <p class="text-xs text-gray-500">{{ $product->contract_days }} Hari Kontrak</p>
                    </div>
                </div>

                <div class="bg-black/20 rounded-xl p-4 mb-6 border border-white/5">
                    <p class="text-xs text-gray-500 mb-1">Status Misi Saat Ini:</p>
                    @php
                        $sample = \App\Models\Investment::where('product_id', $product->id)->where('status', 'active')->first();
                    @endphp

                    @if($sample && $sample->daily_video_key)
                        <div class="flex justify-between items-center">
                            <span class="text-green-400 text-sm font-bold">Terupdate</span>
                            <span class="text-xs bg-gray-700 px-2 py-1 rounded text-white font-mono">Key: {{ $sample->daily_video_key }}</span>
                        </div>
                    @else
                        <span class="text-red-400 text-sm italic">Belum disetting / Tidak ada user aktif</span>
                    @endif
                </div>

                <button onclick='openMissionModal(@json($product))' class="w-full py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold rounded-xl shadow-lg shadow-cyan-500/20 transition">
                    🎥 Set Misi Hari Ini
                </button>
            </div>
        @endforeach
    </div>

    <div id="missionModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#141625] w-full max-w-lg rounded-2xl border border-gray-800 shadow-2xl">
            <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white">Update Misi: <span id="modalProductName" class="text-cyan-400"></span></h3>
                <button onclick="document.getElementById('missionModal').classList.add('hidden')" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form action="{{ route('admin.missions.update') }}" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">

                <div class="mb-4">
                    <label class="text-sm text-gray-400 mb-2 block">Link Video (YouTube/Lainnya)</label>
                    <input type="url" name="video_url" required placeholder="https://youtube.com/watch?v=..." 
                        class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 outline-none">
                    <p class="text-xs text-gray-500 mt-2">Pastikan video berisi "Kode Unik" di menit tertentu.</p>
                </div>

                <div class="mb-6">
                    <label class="text-sm text-gray-400 mb-2 block">Kunci Jawaban (Kode Unik)</label>
                    <input type="text" name="video_key" required placeholder="Contoh: CUAN2026" 
                        class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white font-bold tracking-widest focus:border-cyan-500 outline-none uppercase">
                    <p class="text-xs text-gray-500 mt-2">User harus memasukkan kode ini agar saldo cair.</p>
                </div>

                <button type="submit" class="w-full py-3 bg-green-500 hover:bg-green-600 text-black font-bold rounded-xl transition">
                    🚀 Sebar Misi ke Member
                </button>
            </form>
        </div>
    </div>

    <script>
        function openMissionModal(product) {
            document.getElementById('modalProductId').value = product.id;
            document.getElementById('modalProductName').innerText = product.name;
            document.getElementById('missionModal').classList.remove('hidden');
        }
    </script>

@endsection