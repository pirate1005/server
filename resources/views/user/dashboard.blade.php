@extends('layouts.user')

@section('title', 'Dashboard Saya')

@section('content')

    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-cyan-500 to-blue-600 p-[2px]">
                <div class="w-full h-full rounded-full bg-[#0B0C15] flex items-center justify-center overflow-hidden">
                    @if ($user->photo_profile)
                        <img src="{{ $user->photo_profile }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-white font-bold">{{ substr($user->name, 0, 1) }}</span>
                    @endif
                </div>
            </div>
            <div>
                <p class="text-gray-400 text-xs">Selamat Datang,</p>
                <h2 class="text-white font-bold text-lg leading-tight">{{ explode(' ', $user->name)[0] }}</h2>
            </div>
        </div>

        <button class="relative p-2 bg-gray-800 rounded-full text-gray-300 hover:text-white transition">
            <i class="ph ph-bell text-xl"></i>
            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-[#0B0C15] animate-ping"></span>
            <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-[#0B0C15]"></span>
        </button>
    </div>

    @if($banners->count() > 0)
    <div class="relative w-full mb-6 rounded-3xl overflow-hidden shadow-lg shadow-black/50 border border-gray-800 aspect-[21/9] md:aspect-[4/1]">
        
        <div id="banner-slideshow" class="w-full h-full relative">
            @foreach($banners as $index => $banner)
                <a href="{{ $banner->target_url ?? '#' }}" {{ $banner->target_url ? 'target="_blank"' : 'onclick="event.preventDefault()"' }} 
                   class="absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index == 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }} banner-slide">
                    
                    <img src="{{ asset($banner->image_path) }}" class="w-full h-full object-cover" alt="Promo {{ $index }}">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </a>
            @endforeach
        </div>

        <div class="absolute top-3 right-3 bg-black/60 backdrop-blur-md px-2 py-0.5 rounded text-[9px] text-gray-300 border border-white/10 uppercase tracking-widest z-20">
            Info / Promo
        </div>

        @if($banners->count() > 1)
        <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-20">
            @foreach($banners as $index => $banner)
                <div class="w-1.5 h-1.5 rounded-full transition-all duration-300 banner-dot {{ $index == 0 ? 'bg-cyan-400 w-3' : 'bg-white/40' }}"></div>
            @endforeach
        </div>
        @endif
    </div>
    @endif
    <div class="relative w-full h-48 bg-gradient-to-br from-cyan-600 to-blue-800 rounded-3xl p-6 shadow-2xl shadow-cyan-900/20 overflow-hidden mb-6 group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-white/20 transition duration-500"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/10 rounded-full blur-xl -ml-10 -mb-10"></div>

        <div class="relative z-10 flex flex-col justify-between h-full">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-cyan-100 text-sm font-medium">Saldo Dompet</p>
                    <h3 class="text-white text-3xl font-bold mt-1 tracking-tight">Rp {{ number_format($user->wallet->balance ?? 0, 0, ',', '.') }}</h3>
                </div>
                @if ($user->role == 'owner')
                    <span class="bg-yellow-400/20 text-yellow-300 border border-yellow-400/30 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                        <i class="ph-fill ph-crown"></i> OWNER
                    </span>
                @else
                    <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold backdrop-blur-md">MEMBER</span>
                @endif
            </div>

            <div class="flex gap-3 mt-4">
                <a href="{{ route('user.wallet') }}" class="flex-1 bg-white/20 hover:bg-white/30 backdrop-blur-sm py-2.5 rounded-xl flex items-center justify-center gap-2 text-white text-sm font-bold transition shadow-lg">
                    <i class="ph-fill ph-arrow-down"></i> Deposit
                </a>
                <a href="{{ route('user.wallet') }}" class="flex-1 bg-black/20 hover:bg-black/30 backdrop-blur-sm py-2.5 rounded-xl flex items-center justify-center gap-2 text-white text-sm font-bold transition shadow-lg">
                    <i class="ph-fill ph-arrow-up"></i> Withdraw
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-[#141625] p-4 rounded-2xl border border-gray-800 flex flex-col items-center text-center hover:border-gray-600 transition">
            <div class="w-10 h-10 rounded-full bg-purple-500/10 text-purple-400 flex items-center justify-center mb-2">
                <i class="ph-fill ph-hard-drives text-xl"></i>
            </div>
            <p class="text-gray-400 text-xs">Server Aktif</p>
            <p class="text-white font-bold text-lg">{{ $activeServers }} Unit</p>
        </div>
        <div class="bg-[#141625] p-4 rounded-2xl border border-gray-800 flex flex-col items-center text-center hover:border-gray-600 transition">
            <div class="w-10 h-10 rounded-full bg-green-500/10 text-green-400 flex items-center justify-center mb-2">
                <i class="ph-fill ph-money text-xl"></i>
            </div>
            <p class="text-gray-400 text-xs">Total Profit</p>
            <p class="text-white font-bold text-lg">Rp {{ number_format($totalProfit, 0, ',', '.') }}</p>
        </div>
    </div>

    <h3 class="text-white font-bold mb-4 flex items-center gap-2">
        <span class="w-1 h-5 bg-cyan-500 rounded-full"></span> Layanan Utama
    </h3>
    <div class="grid grid-cols-4 gap-4 mb-8">
        <a href="{{ route('user.products.index') }}" class="flex flex-col items-center gap-2 group">
            <div class="w-14 h-14 bg-gray-800 group-hover:bg-cyan-500/20 rounded-2xl flex items-center justify-center transition border border-gray-700 group-hover:border-cyan-500/50">
                <i class="ph-fill ph-shopping-cart text-2xl text-cyan-400"></i>
            </div>
            <span class="text-xs text-gray-400 text-center leading-tight group-hover:text-white transition">Sewa Server</span>
        </a>
        <a href="{{ route('user.upgrade') }}" class="flex flex-col items-center gap-2 group">
            <div class="w-14 h-14 bg-gray-800 group-hover:bg-yellow-500/20 rounded-2xl flex items-center justify-center transition border border-gray-700 group-hover:border-yellow-500/50">
                <i class="ph-fill ph-medal text-2xl text-yellow-400"></i>
            </div>
            <span class="text-xs text-gray-400 text-center leading-tight group-hover:text-white transition">Upgrade Owner</span>
        </a>
        <a href="{{ route('user.referrals') }}" class="flex flex-col items-center gap-2 group">
            <div class="w-14 h-14 bg-gray-800 group-hover:bg-green-500/20 rounded-2xl flex items-center justify-center transition border border-gray-700 group-hover:border-green-500/50">
                <i class="ph-fill ph-users-three text-2xl text-green-400"></i>
            </div>
            <span class="text-xs text-gray-400 text-center leading-tight group-hover:text-white transition">Undang Teman</span>
        </a>
        <a href="{{ route('user.support')}}" class="flex flex-col items-center gap-2 group">
            <div class="w-14 h-14 bg-gray-800 group-hover:bg-purple-500/20 rounded-2xl flex items-center justify-center transition border border-gray-700 group-hover:border-purple-500/50">
                <i class="ph-fill ph-headset text-2xl text-purple-400"></i>
            </div>
            <span class="text-xs text-gray-400 text-center leading-tight group-hover:text-white transition">Bantuan CS</span>
        </a>
    </div>

    <div class="flex justify-between items-center mb-4">
        <h3 class="text-white font-bold flex items-center gap-2">
            <span class="w-1 h-5 bg-purple-500 rounded-full"></span> Aktivitas Terakhir
        </h3>
        <a href="{{ route('user.wallet') }}" class="text-cyan-400 text-xs hover:text-white transition">Lihat Semua</a>
    </div>

    <div class="space-y-3 pb-24">
        @forelse($recentTransactions as $trx)
            <div class="flex justify-between items-center bg-[#141625] p-4 rounded-xl border border-gray-800 hover:border-gray-700 transition">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $trx->type == 'deposit' || $trx->type == 'daily_profit' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                        @if ($trx->type == 'deposit') <i class="ph-fill ph-arrow-down"></i>
                        @elseif($trx->type == 'withdraw') <i class="ph-fill ph-arrow-up"></i>
                        @elseif($trx->type == 'daily_profit') <i class="ph-fill ph-coins"></i>
                        @else <i class="ph-fill ph-shopping-bag"></i> @endif
                    </div>
                    <div>
                        <p class="text-white text-sm font-bold capitalize">{{ str_replace('_', ' ', $trx->type) }}</p>
                        <p class="text-gray-500 text-xs">{{ $trx->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold {{ $trx->type == 'deposit' || $trx->type == 'daily_profit' ? 'text-green-500' : 'text-white' }}">
                        {{ $trx->type == 'deposit' || $trx->type == 'daily_profit' ? '+' : '-' }}
                        Rp {{ number_format($trx->amount) }}
                    </p>
                    <span class="text-[10px] {{ $trx->status == 'success' ? 'text-green-500' : ($trx->status == 'pending' ? 'text-yellow-500' : 'text-red-500') }} uppercase font-bold">
                        {{ $trx->status }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 text-sm border border-dashed border-gray-800 rounded-xl">Belum ada transaksi.</div>
        @endforelse
    </div>

    <div id="live-toast" class="fixed top-24 right-4 z-50 transform translate-x-full transition-transform duration-500 ease-in-out pointer-events-none">
        <div class="bg-[#1f2937]/95 backdrop-blur-xl border-l-4 border-green-500 text-white px-4 py-3 rounded-r-xl shadow-2xl flex items-center gap-3 max-w-xs ring-1 ring-white/10">
            <div class="w-10 h-10 rounded-full bg-gray-700 flex-shrink-0 overflow-hidden relative">
                <img id="toast-img" src="" class="w-full h-full object-cover hidden">
                <div id="toast-initial" class="w-full h-full flex items-center justify-center font-bold text-gray-300 bg-gradient-to-br from-gray-700 to-gray-900">A</div>
                <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border border-gray-800"></div>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-0.5" id="toast-name">Seseorang</p>
                <p class="text-sm font-bold leading-tight flex flex-col">
                    <span id="toast-action" class="text-green-400">Deposit</span> 
                    <span id="toast-amount" class="text-white">Rp 100.000</span>
                </p>
            </div>
            <div class="absolute top-2 right-2 text-[9px] text-gray-500" id="toast-time">1d lalu</div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // --- SCRIPT BANNER SLIDESHOW ---
    @if(isset($banners) && $banners->count() > 1)
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.banner-slide');
            const dots = document.querySelectorAll('.banner-dot');
            let currentSlide = 0;
            const slideCount = slides.length;
            const interval = 4000; // Ganti gambar tiap 4 detik

            function nextSlide() {
                // Sembunyikan slide aktif
                slides[currentSlide].classList.remove('opacity-100', 'z-10');
                slides[currentSlide].classList.add('opacity-0', 'z-0');
                dots[currentSlide].classList.remove('bg-cyan-400', 'w-3');
                dots[currentSlide].classList.add('bg-white/40', 'w-1.5');

                // Pindah ke slide berikutnya
                currentSlide = (currentSlide + 1) % slideCount;

                // Tampilkan slide baru
                slides[currentSlide].classList.remove('opacity-0', 'z-0');
                slides[currentSlide].classList.add('opacity-100', 'z-10');
                dots[currentSlide].classList.remove('bg-white/40', 'w-1.5');
                dots[currentSlide].classList.add('bg-cyan-400', 'w-3');
            }

            // Jalankan interval
            setInterval(nextSlide, interval);
        });
    @endif


    // --- SCRIPT LIVE TOAST (TIDAK BERUBAH) ---
    const realTrx = @json($publicTrx ?? []);

    const dummyNames = [
        'Aditya P***', 'Budi S***', 'Citra L***', 'Dimas R***', 'Eka W***', 'Fajar N***', 'Gita A***', 'Hendi K***',
        'Indah P***', 'Joko S***', 'Kevin R***', 'Lina M***', 'Maya S***', 'Nanda K***', 'Oscar T***', 'Putri A***',
        'Rizky F***', 'Siti N***', 'Tono W***', 'Udin P***', 'Vina L***', 'Wawan H***', 'Yudi S***', 'Zainal A***',
        'Agus T***', 'Bayu K***', 'Candra W***', 'Dedi S***', 'Erik L***', 'Ferry N***', 'Galih P***', 'Heri S***',
        'Ilham R***', 'Jefri A***', 'Kiki M***', 'Lukman H***', 'Mamat S***', 'Novan K***', 'Oki P***', 'Pandu W***',
        'Qori A***', 'Rendi S***', 'Sandi G***', 'Teguh P***', 'Usman H***', 'Vicky L***', 'Wahyu K***', 'Yoga P***',
        'Sultan F***', 'Ratu A***', 'Bos M***', 'Juragan T***'
    ];

    const dummyActions = [
        { type: 'Deposit Sukses', color: 'text-green-400', range: [100000, 2000000], weight: 4 },
        { type: 'Withdraw Cair', color: 'text-orange-400', range: [50000, 500000], weight: 3 },
        { type: 'Sewa Server Mikro', color: 'text-cyan-400', range: [137000, 137000], weight: 2 },
        { type: 'Sewa Server Titanium', color: 'text-purple-400', range: [550000, 550000], weight: 1 },
        { type: 'Sewa Server Gold', color: 'text-yellow-400', range: [350000, 350000], weight: 1 },
        { type: 'Klaim Misi Harian', color: 'text-blue-400', range: [2500, 15000], weight: 5 },
        { type: 'Bonus Referral', color: 'text-pink-400', range: [10000, 50000], weight: 2 },
        { type: 'Upgrade Owner', color: 'text-yellow-500', range: [500000, 500000], weight: 1 }
    ];

    function formatRupiah(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function getRandomAction() {
        let totalWeight = dummyActions.reduce((sum, item) => sum + item.weight, 0);
        let random = Math.random() * totalWeight;
        for (let item of dummyActions) {
            if (random < item.weight) return item;
            random -= item.weight;
        }
        return dummyActions[0];
    }

    function showToast() {
        const toast = document.getElementById('live-toast');
        const img = document.getElementById('toast-img');
        const initial = document.getElementById('toast-initial');
        const nameEl = document.getElementById('toast-name');
        const actionEl = document.getElementById('toast-action');
        const amountEl = document.getElementById('toast-amount');
        const timeEl = document.getElementById('toast-time');
        const containerBorder = document.querySelector('#live-toast > div');

        let data = {};

        if (realTrx.length > 0 && Math.random() < 0.3) {
            const randIndex = Math.floor(Math.random() * realTrx.length);
            data = realTrx[randIndex];
            
            let colorClass = 'text-white';
            let borderColor = 'border-gray-500';

            if(data.action.includes('Deposit')) { colorClass = 'text-green-400'; borderColor = 'border-green-500'; }
            else if(data.action.includes('Withdraw')) { colorClass = 'text-orange-400'; borderColor = 'border-orange-500'; }
            else if(data.action.includes('Profit')) { colorClass = 'text-blue-400'; borderColor = 'border-blue-500'; }
            else { colorClass = 'text-cyan-400'; borderColor = 'border-cyan-500'; }

            actionEl.className = colorClass;
            containerBorder.className = `bg-[#1f2937]/95 backdrop-blur-xl border-l-4 ${borderColor} text-white px-4 py-3 rounded-r-xl shadow-2xl flex items-center gap-3 max-w-xs ring-1 ring-white/10`;

        } else {
            const randName = dummyNames[Math.floor(Math.random() * dummyNames.length)];
            const actionData = getRandomAction();
            const randAmount = Math.floor(Math.random() * (actionData.range[1] - actionData.range[0]) + actionData.range[0]);

            data = {
                name: randName,
                action: actionData.type,
                amount: formatRupiah(randAmount),
                time: 'Baru saja',
                avatar: null
            };

            actionEl.className = actionData.color;
            let borderColor = actionData.color.replace('text', 'border');
            containerBorder.className = `bg-[#1f2937]/95 backdrop-blur-xl border-l-4 ${borderColor} text-white px-4 py-3 rounded-r-xl shadow-2xl flex items-center gap-3 max-w-xs ring-1 ring-white/10`;
        }

        nameEl.innerText = data.name;
        actionEl.innerText = data.action;
        amountEl.innerText = data.amount;
        timeEl.innerText = data.time;

        if (data.avatar) {
            img.src = data.avatar;
            img.classList.remove('hidden');
            initial.classList.add('hidden');
        } else {
            img.classList.add('hidden');
            initial.classList.remove('hidden');
            initial.innerText = data.name.charAt(0);
            const colors = ['from-blue-600 to-cyan-600', 'from-purple-600 to-pink-600', 'from-green-600 to-emerald-600', 'from-orange-500 to-red-500'];
            const randomColor = colors[Math.floor(Math.random() * colors.length)];
            initial.className = `w-full h-full flex items-center justify-center font-bold text-white bg-gradient-to-br ${randomColor}`;
        }

        toast.classList.remove('translate-x-full');

        setTimeout(() => {
            toast.classList.add('translate-x-full');
        }, 3500);
    }

    function loopNotification() {
        const randomInterval = Math.floor(Math.random() * (7000 - 3000 + 1) + 3000);
        setTimeout(() => {
            showToast();
            loopNotification();
        }, randomInterval);
    }

    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(loopNotification, 1000); 
    });

</script>
@endpush