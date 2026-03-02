@extends('layouts.user')

@section('title', 'Sewa Server')

@section('content')

    <div class="relative bg-gradient-to-r from-indigo-900 to-purple-900 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl -mr-16 -mt-16"></div>
        <div class="relative z-10">
            <span class="bg-purple-500 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider mb-2 inline-block">Marketplace</span>
            <h2 class="text-3xl font-bold text-white mb-2">Pilih Server Investasi</h2>
            <p class="text-indigo-200 text-sm max-w-md">Sewa server cloud mining berkinerja tinggi. Dapatkan profit harian otomatis langsung ke dompet Anda.</p>
        </div>
        <i class="ph-duotone ph-shopping-cart text-8xl text-white/5 absolute bottom-4 right-4"></i>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-24">
        @forelse($products as $product)
            
            @php
                $totalReturn = $product->daily_income * $product->contract_days;
                $roi = (($totalReturn - $product->price) / $product->price) * 100;
                $isVip = $product->is_exclusive_for_owner;
                $isOwnerPack = $product->is_owner_product;
            @endphp

            <div class="group relative bg-[#141625] border border-gray-800 rounded-2xl overflow-hidden transition hover:-translate-y-2 hover:shadow-xl hover:shadow-cyan-500/10 flex flex-col h-full">
                
                @if($isVip)
                    <div class="absolute top-0 right-0 bg-gradient-to-r from-yellow-500 to-orange-500 text-black text-[10px] font-bold px-3 py-1 rounded-bl-xl z-20 shadow-lg">
                        👑 VIP ONLY
                    </div>
                @elseif($isOwnerPack)
                    <div class="absolute top-0 right-0 bg-gradient-to-r from-cyan-500 to-blue-500 text-black text-[10px] font-bold px-3 py-1 rounded-bl-xl z-20 shadow-lg">
                        🚀 AUTO OWNER
                    </div>
                @endif

                <div class="h-40 bg-gray-800 relative overflow-hidden">
                    <img src="{{ $product->image ?? 'https://via.placeholder.com/400x200?text=Server+Unit' }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#141625] to-transparent"></div>
                    
                    <div class="absolute bottom-4 left-4">
                        <p class="text-gray-400 text-xs">Harga Sewa</p>
                        <p class="text-white font-bold text-xl">Rp {{ number_format($product->price) }}</p>
                    </div>
                </div>

                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-lg font-bold text-white mb-1">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-500 mb-4 min-h-[40px] line-clamp-2">{{ $product->description ?? 'Server cloud mining dengan performa stabil dan profit harian terjamin.' }}</p>

                    <div class="grid grid-cols-2 gap-3 mb-6 bg-black/20 p-3 rounded-xl border border-gray-700/50">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase">Profit Harian</p>
                            <p class="text-sm font-bold text-cyan-400">Rp {{ number_format($product->daily_income) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase">Kontrak</p>
                            <p class="text-sm font-bold text-white">{{ $product->contract_days }} Hari</p>
                        </div>
                        <div class="col-span-2 border-t border-gray-700 pt-2 mt-1 flex justify-between items-center">
                            <p class="text-[10px] text-gray-400 uppercase">Total Profit (Estimasi)</p>
                            <p class="text-sm font-bold text-green-400">Rp {{ number_format($totalReturn) }} <span class="text-[10px] text-gray-500">({{ round($roi) }}%)</span></p>
                        </div>
                    </div>

                    @if($product->bonus_reward)
                        <div class="flex items-center gap-2 mb-4 bg-yellow-500/5 border border-yellow-500/20 p-2 rounded-lg">
                            <i class="ph-fill ph-gift text-yellow-500"></i>
                            <p class="text-xs text-yellow-200">Bonus: <span class="font-bold">{{ $product->bonus_reward }}</span></p>
                        </div>
                    @endif

                    <div class="mt-auto">
                        <form action="{{ route('user.products.buy', $product->id) }}" method="POST" id="form-buy-{{ $product->id }}">
                            @csrf
                            <button type="button" onclick="confirmBuy('{{ $product->name }}', {{ $product->price }}, {{ $product->id }})" 
                                class="w-full py-3 rounded-xl font-bold transition shadow-lg flex items-center justify-center gap-2
                                {{ $isVip ? 'bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-500 hover:to-orange-500 text-white shadow-orange-900/20' : 'bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white shadow-cyan-900/20' }}">
                                {{ $isVip ? 'Sewa VIP' : 'Sewa Sekarang' }} <i class="ph-bold ph-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20">
                <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-500">
                    <i class="ph-fill ph-hard-drives text-4xl"></i>
                </div>
                <h3 class="text-white font-bold text-xl">Stok Habis</h3>
                <p class="text-gray-400">Belum ada server yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

@endsection

@push('scripts')
<script>
    function confirmBuy(name, price, id) {
        let balance = {{ Auth::user()->wallet->balance ?? 0 }};

        // 1. Cek Saldo Client Side
        if (balance < price) {
            Swal.fire({
                icon: 'error',
                title: 'Saldo Tidak Cukup',
                text: 'Harga sewa Rp ' + new Intl.NumberFormat('id-ID').format(price) + '. Saldo Anda kurang.',
                background: '#1f2937', color: '#fff',
                confirmButtonText: 'Isi Saldo Dulu',
                confirmButtonColor: '#0891b2',
                showCancelButton: true,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('user.wallet') }}";
                }
            });
            return;
        }

        // 2. Konfirmasi Pembelian
        Swal.fire({
            title: 'Konfirmasi Sewa',
            html: "Anda akan menyewa <strong>" + name + "</strong><br>seharga <strong>Rp " + new Intl.NumberFormat('id-ID').format(price) + "</strong>",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Bayar',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#0891b2',
            background: '#1f2937', color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-buy-' + id).submit();
            }
        });
    }

    // Notifikasi Sukses/Gagal dari Controller
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", background: '#1f2937', color: '#fff', timer: 2000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", background: '#1f2937', color: '#fff' });
    @endif
</script>
@endpush