@extends('layouts.user')

@section('title', 'Ruang Misi')

@section('content')

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Misi Harian</h2>
        <p class="text-gray-400 text-sm">Fokus! Kode muncul satu per satu dan akan menghilang. Catat secepatnya!</p>
    </div>

    <div class="space-y-8 pb-24">
        @forelse($investments as $inv)
            
            @php
                $isClaimedToday = $inv->dailyClaims->count() > 0;
                
                // Proses Link YouTube
                $videoUrl = $inv->daily_video_url;
                if(str_contains($videoUrl, 'watch?v=')) {
                    $videoUrl = str_replace('watch?v=', 'embed/', $videoUrl);
                } elseif(str_contains($videoUrl, 'youtu.be/')) {
                    $videoUrl = str_replace('youtu.be/', 'www.youtube.com/embed/', $videoUrl);
                }
                // Tambah controls=0 agar user tidak bisa skip video
                $videoUrl .= '?enablejsapi=1&rel=0&modestbranding=1';
            @endphp

            <div class="bg-[#141625] border border-gray-800 rounded-2xl overflow-hidden shadow-xl" id="mission-{{ $inv->id }}">
                
                <div class="p-4 border-b border-gray-800 flex justify-between items-center bg-black/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-cyan-500">
                            <i class="ph-fill ph-monitor-play text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm">{{ $inv->product->name }}</h3>
                            <p class="text-xs text-gray-500">Reward: <span class="text-green-400 font-bold">Rp {{ number_format($inv->product->daily_income, 0, ',', '.') }}</span></p>
                        </div>
                    </div>
                    
                    @if($isClaimedToday)
                        <span class="bg-green-500/10 text-green-500 px-3 py-1 rounded-full text-xs font-bold border border-green-500/20 flex items-center gap-1">
                            <i class="ph-bold ph-check"></i> Selesai
                        </span>
                    @else
                        <span class="bg-gray-800 text-gray-400 px-3 py-1 rounded-full text-xs font-bold border border-gray-700 flex items-center gap-1" id="status-badge-{{ $inv->id }}">
                            <i class="ph-fill ph-eye-slash"></i> <span id="status-text-{{ $inv->id }}">Menunggu..</span>
                        </span>
                    @endif
                </div>

                <div class="relative w-full aspect-video bg-black group overflow-hidden">
                    @if($inv->daily_video_url)
                        <iframe class="w-full h-full" src="{{ $videoUrl }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        
                        @if(!$isClaimedToday)
                            
                            {{-- 1. AREA "HANTU" MUNCUL KODE (Overlay Transparan) --}}
                            <div id="ghost-overlay-{{ $inv->id }}" class="absolute inset-0 z-10 flex items-center justify-center pointer-events-none">
                                </div>

                            {{-- 2. TOMBOL MULAI (Overlay Awal) --}}
                            <div id="start-overlay-{{ $inv->id }}" class="absolute inset-0 bg-black/90 z-20 flex flex-col items-center justify-center backdrop-blur-sm">
                                <i class="ph-duotone ph-lock-key text-4xl text-gray-500 mb-2"></i>
                                <p class="text-gray-300 text-sm mb-6 text-center max-w-xs px-4">
                                    Kode akan muncul <b>satu per satu</b> secara acak lalu <b>menghilang</b>. Jangan sampai terlewat!
                                </p>
                                <button onclick="startGhostMode({{ $inv->id }}, '{{ $inv->daily_video_key }}')" 
                                    class="group relative px-8 py-3 bg-cyan-600 hover:bg-cyan-500 text-white rounded-xl font-bold shadow-lg shadow-cyan-500/20 transition transform hover:scale-105 flex items-center gap-2">
                                    <i class="ph-fill ph-play"></i> Mulai Misi
                                </button>
                            </div>

                        @endif

                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-500">
                            <i class="ph-duotone ph-video-camera-slash text-4xl mb-2"></i>
                            <p class="text-sm">Video belum tersedia.</p>
                        </div>
                    @endif
                </div>

                <div class="p-5">
                    @if($isClaimedToday)
                        <div class="text-center py-4">
                            <h3 class="text-white font-bold text-lg">Misi Selesai</h3>
                            <p class="text-gray-400 text-sm">Profit sudah masuk ke saldo Anda.</p>
                        </div>
                    @else
                        @if($inv->daily_video_url)
                            <form action="{{ route('user.missions.claim', $inv->id) }}" method="POST">
                                @csrf
                                <label class="text-xs text-gray-500 mb-2 block ml-1">Ketik kode yang muncul di sini:</label>
                                <div class="flex gap-2">
                                    <input type="text" name="video_key" id="input-key-{{ $inv->id }}" required placeholder="_ _ _ _ _" autocomplete="off"
                                        class="flex-1 bg-black/30 border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 outline-none uppercase tracking-[0.5em] font-bold text-center transition focus:ring-1 focus:ring-cyan-500/50 placeholder-gray-700">
                                    
                                    <button type="submit" class="bg-cyan-600 hover:bg-cyan-500 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-cyan-900/20 transition flex items-center gap-2">
                                        Klaim
                                    </button>
                                </div>
                                <p class="text-[10px] text-gray-600 mt-2 text-center">*Jika terlewat, Anda harus refresh halaman & ulang dari awal.</p>
                            </form>
                        @endif
                    @endif
                </div>

            </div>

        @empty
            <div class="text-center py-16 bg-[#141625] rounded-3xl border border-dashed border-gray-800">
                <i class="ph-fill ph-smiley-sad text-4xl text-gray-500 mb-4"></i>
                <h3 class="text-white font-bold text-xl">Tidak Ada Misi</h3>
                <p class="text-gray-400 text-sm mb-6 max-w-xs mx-auto">Sewa server dulu untuk membuka akses misi harian.</p>
                <a href="{{ route('user.products.index') }}" class="px-6 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-xl shadow-lg transition">
                    Sewa Server Sekarang
                </a>
            </div>
        @endforelse
    </div>

@endsection

@push('scripts')
<script>
    // --- LOGIKA GHOST MODE (MUNCUL - HILANG - ACAK) --- //

    function startGhostMode(id, fullCode) {
        // 1. Hilangkan Overlay Start
        const startOverlay = document.getElementById(`start-overlay-${id}`);
        startOverlay.classList.add('fade-out'); // Tambah animasi css
        setTimeout(() => startOverlay.classList.add('hidden'), 500);

        // 2. Update Status
        const statusText = document.getElementById(`status-text-${id}`);
        const statusBadge = document.getElementById(`status-badge-${id}`);
        statusText.innerText = "Perhatikan Layar!";
        statusBadge.className = "bg-red-500/10 text-red-400 px-3 py-1 rounded-full text-xs font-bold border border-red-500/20 flex items-center gap-1 animate-pulse";

        // 3. Persiapan Variabel
        const overlay = document.getElementById(`ghost-overlay-${id}`);
        const letters = fullCode.split('');
        let currentStep = 0;

        // --- FUNGSI REKURSIF UNTUK MENGATUR WAKTU ---
        function scheduleNextLetter() {
            if (currentStep >= letters.length) {
                // Selesai
                statusText.innerText = "Kode Lengkap!";
                statusBadge.className = "bg-green-500/10 text-green-500 px-3 py-1 rounded-full text-xs font-bold border border-green-500/20 flex items-center gap-1";
                return;
            }

            // 1. TENTUKAN WAKTU TUNGGU (RANDOM)
            // Ini jeda kosong antar huruf. Bikin agak lama biar deg-degan.
            // Minimal 5 detik, Maksimal 15 detik (bisa diatur sesuai panjang video)
            const waitTime = Math.floor(Math.random() * (15000 - 5000 + 1) + 5000); 

            setTimeout(() => {
                // 2. TAMPILKAN HURUF
                const letter = letters[currentStep];
                
                // Bikin elemen visual huruf
                const span = document.createElement('div');
                span.innerText = letter;
                span.className = "text-6xl md:text-8xl font-black text-cyan-400 drop-shadow-[0_0_15px_rgba(34,211,238,0.8)] scale-0 transition-transform duration-300 ease-out";
                
                // Masukkan ke layar
                overlay.innerHTML = ''; // Bersihkan yg lama (jaga-jaga)
                overlay.appendChild(span);

                // Efek Pop-Up (Masuk)
                setTimeout(() => { span.classList.remove('scale-0'); span.classList.add('scale-100'); }, 50);

                // 3. HILANGKAN HURUF SETELAH BEBERAPA DETIK (DISPLAY TIME)
                // Huruf cuma nongol 3 detik, terus hilang!
                setTimeout(() => {
                    span.classList.remove('scale-100'); 
                    span.classList.add('scale-0', 'opacity-0'); // Efek keluar
                    
                    // Lanjut ke huruf berikutnya
                    currentStep++;
                    scheduleNextLetter(); // Panggil fungsi ini lagi (Looping)

                }, 3000); // Durasi huruf tampil di layar (3 Detik)

            }, waitTime);
        }

        // Mulai Loop Pertama
        scheduleNextLetter();
    }

    // Flash Message
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", background: '#1f2937', color: '#fff', confirmButtonColor: '#0891b2' });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", background: '#1f2937', color: '#fff', confirmButtonColor: '#ef4444' });
    @endif
</script>

<style>
    .fade-out {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        pointer-events: none;
    }
</style>
@endpush