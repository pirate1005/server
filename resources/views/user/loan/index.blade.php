@extends('layouts.user')

@section('title', 'Layanan Pinjaman')

@section('content')

    <div class="mb-8">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white text-sm flex items-center gap-2 mb-4 transition">
            <i class="ph-bold ph-arrow-left"></i> Kembali ke Dashboard
        </a>
        <h2 class="text-3xl font-bold text-white">Layanan Pinjaman</h2>
        <p class="text-gray-400 text-sm mt-1">Dapatkan dana instan untuk ekspansi server Anda.</p>
    </div>

    <div class="bg-[#141625] border border-gray-800 rounded-3xl p-6 md:p-8 shadow-2xl relative overflow-hidden max-w-2xl mx-auto">
        
        <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl -mr-20 -mt-20"></div>

        <div class="relative z-10 text-center mb-8">
            <div class="w-20 h-20 bg-orange-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-orange-500/20">
                <i class="ph-fill ph-vault text-4xl text-orange-400"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Masukkan Kode Persetujuan</h3>
            <p class="text-sm text-gray-400 max-w-md mx-auto">
                Fitur pinjaman saat ini bersifat eksklusif. Anda memerlukan <span class="text-orange-400 font-bold">Kode Unik</span> dari Admin untuk mengajukan limit pinjaman.
            </p>
        </div>

        <form action="{{ route('user.loan.submit') }}" method="POST" class="relative z-10">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-300 mb-2 uppercase tracking-wider text-center">Ketik Kode Unik</label>
                <input type="text" name="unique_code" required placeholder="Contoh: LMS-XXX-XXX" autocomplete="off"
                    class="w-full bg-[#0B0C15] border-2 border-gray-700 rounded-xl px-6 py-4 text-white text-center text-xl tracking-[0.2em] font-bold focus:border-orange-500 outline-none transition placeholder-gray-700 uppercase">
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-500 hover:to-red-500 text-white font-bold text-lg rounded-xl shadow-[0_0_20px_rgba(249,115,22,0.3)] transition transform hover:scale-[1.02]">
                Verifikasi Kode
            </button>
            
            <p class="text-center text-xs text-gray-500 mt-6">
                Belum punya kode? <a href="https://wa.me/6281234567890" target="_blank" class="text-orange-400 hover:underline">Hubungi CS</a>
            </p>
        </form>
    </div>

@endsection

@push('scripts')
<script>
    // Menangkap Pesan Sukses / Error dari Controller
    @if(session('success'))
        Swal.fire({ 
            icon: 'success', 
            title: 'Berhasil!', 
            text: "{{ session('success') }}", 
            background: '#1f2937', 
            color: '#fff', 
            confirmButtonColor: '#10b981',
            customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold' }
        });
    @endif

    @if(session('error'))
        Swal.fire({ 
            icon: 'error', 
            title: 'Gagal!', 
            text: "{{ session('error') }}", 
            background: '#1f2937', 
            color: '#fff', 
            confirmButtonColor: '#ef4444',
            customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold' }
        });
    @endif
</script>
@endpush