@extends('layouts.user')

@section('title', 'Dompet Saya')

@section('content')

    <div class="relative w-full h-48 bg-gradient-to-br from-cyan-600 to-blue-900 rounded-3xl p-6 shadow-2xl shadow-cyan-900/20 overflow-hidden mb-8 group">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-white/20 transition duration-700"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-black/20 rounded-full blur-2xl -ml-10 -mb-10"></div>
        
        <div class="relative z-10 flex flex-col justify-between h-full">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-cyan-100/80 text-sm font-medium tracking-wider mb-1">TOTAL SALDO AKTIF</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">
                        Rp {{ number_format($user->wallet->balance ?? 0, 0, ',', '.') }}
                    </h2>
                </div>
                <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center">
                    <i class="ph-fill ph-wallet text-xl text-white"></i>
                </div>
            </div>
            
            <div class="flex items-end justify-between">
                <div class="flex items-center gap-2 bg-black/20 backdrop-blur-sm px-3 py-1.5 rounded-lg border border-white/10">
                    <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    <span class="text-xs text-white font-medium">Sistem Aman & Terenkripsi</span>
                </div>
                <i class="ph-fill ph-shield-check text-4xl text-white/10"></i>
            </div>
        </div>
    </div>

    <div class="flex bg-[#141625] p-1.5 rounded-2xl mb-8 border border-gray-800 shadow-inner max-w-xl mx-auto">
        <button onclick="switchTab('deposit')" id="btn-deposit" class="flex-1 py-3 rounded-xl text-sm font-bold transition-all duration-300 bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg flex items-center justify-center gap-2 transform scale-105">
            <i class="ph-bold ph-arrow-down"></i> Isi Saldo
        </button>
        <button onclick="switchTab('withdraw')" id="btn-withdraw" class="flex-1 py-3 rounded-xl text-sm font-bold transition-all duration-300 text-gray-400 hover:text-white hover:bg-white/5 flex items-center justify-center gap-2">
            <i class="ph-bold ph-arrow-up"></i> Tarik Dana
        </button>
        <button onclick="switchTab('transfer')" id="btn-transfer" class="flex-1 py-3 rounded-xl text-sm font-bold transition-all duration-300 text-gray-400 hover:text-white hover:bg-white/5 flex items-center justify-center gap-2">
            <i class="ph-bold ph-paper-plane-right"></i> Kirim Saldo
        </button>
    </div>

    <div id="tab-deposit" class="block animate-fade-in">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-xl relative overflow-hidden text-center group">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 via-white to-red-500"></div>
                    <h3 class="text-gray-800 font-bold text-lg mb-1">Scan QRIS</h3>
                    <p class="text-gray-500 text-xs mb-4">Mendukung Semua E-Wallet & Mobile Banking</p>
                    <div class="relative inline-block w-full">
                        <div class="absolute inset-0 bg-gradient-to-tr from-cyan-400 to-blue-600 rounded-xl blur-lg opacity-20 group-hover:opacity-40 transition"></div>
                        <img src="{{ asset('assets/img/qris.jpeg') }}" class="relative w-full max-w-[220px] h-auto mx-auto rounded-xl border-4 border-gray-100 shadow-sm object-contain" alt="QRIS Code">
                    </div>
                    <div class="mt-4 flex justify-center gap-2">
                         <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/1200px-QRIS_logo.svg.png" class="h-6 opacity-70">
                         <span class="text-xs text-gray-400 self-center">| Otomatis & Cepat</span>
                    </div>
                </div>

                <div class="bg-[#1a1d2d] rounded-2xl p-6 border border-gray-700 relative overflow-hidden">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Bank Transfer</p>
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('assets/img/neo.png') }}" class="h-6 bg-white rounded p-0.5">
                                <span class="text-white font-bold">Neo Commerce</span>
                            </div>
                        </div>
                        <button onclick="copyRek()" class="text-cyan-400 hover:text-white bg-cyan-500/10 hover:bg-cyan-500 px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1">
                            <i class="ph-bold ph-copy"></i> Salin
                        </button>
                    </div>
                    <div class="bg-black/30 rounded-xl p-4 border border-dashed border-gray-600 mb-2">
                        <p class="text-2xl font-mono text-white tracking-widest text-center" id="rek-admin">5859459267000072</p>
                    </div>
                    <p class="text-center text-xs text-gray-500">a.n <span class="text-gray-300">L.M.Sofyan</span></p>
                </div>
            </div>

            <div class="lg:col-span-3">
                <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6 lg:p-8 h-full">
                    <h3 class="text-xl font-bold text-white mb-2">Konfirmasi Deposit</h3>
                    <p class="text-gray-400 text-sm mb-6">Silakan transfer sesuai nominal, lalu upload bukti transfer di bawah ini.</p>
                    <form id="form-deposit" action="{{ route('user.wallet.deposit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Nominal Deposit (Rp)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                                <input type="text" id="depo-amount" name="amount" required placeholder="137.000" 
                                    class="input-rupiah w-full bg-[#0B0C15] border border-gray-700 rounded-xl py-4 pl-12 pr-4 text-white text-lg font-bold focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition placeholder-gray-600">
                            </div>
                            <div class="flex justify-between mt-2">
                                <p class="text-[10px] text-gray-500">*Min: Rp 137.000 (Sesuai harga server)</p>
                                <div class="flex gap-2">
                                    <button type="button" onclick="fillAmount('depo-amount', 137000)" class="text-[10px] bg-gray-800 hover:bg-gray-700 text-gray-300 px-2 py-1 rounded transition">137rb</button>
                                    <button type="button" onclick="fillAmount('depo-amount', 500000)" class="text-[10px] bg-gray-800 hover:bg-gray-700 text-gray-300 px-2 py-1 rounded transition">500rb</button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <label class="block text-gray-400 text-xs font-bold uppercase mb-2">Bukti Transfer</label>
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-700 border-dashed rounded-xl cursor-pointer bg-[#0B0C15] hover:bg-gray-800/50 hover:border-cyan-500 transition group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="ph-duotone ph-cloud-arrow-up text-3xl text-gray-500 group-hover:text-cyan-400 mb-2 transition"></i>
                                    <p class="text-xs text-gray-400 group-hover:text-gray-300"><span class="font-bold">Klik untuk upload</span> screenshot</p>
                                </div>
                                <input type="file" name="payment_proof" class="hidden" onchange="previewFile(this)">
                            </label>
                            <p id="file-name" class="text-xs text-cyan-400 mt-2 text-center hidden"></p>
                        </div>
                        <button type="button" onclick="confirmDeposit()" class="w-full py-4 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-bold text-lg rounded-xl transition shadow-lg shadow-cyan-900/20 transform active:scale-[0.98]">
                            Kirim Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="tab-withdraw" class="hidden animate-fade-in">
        <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6 mb-8 max-w-3xl mx-auto">
            <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <i class="ph-fill ph-money text-red-400"></i> Tarik Dana
            </h3>

            @if(!$user->bank_name || !$user->account_number)
                <div class="bg-red-500/10 border border-red-500/30 p-8 rounded-2xl text-center">
                    <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4 text-red-500">
                        <i class="ph-fill ph-warning-circle text-3xl"></i>
                    </div>
                    <h4 class="text-white font-bold text-lg mb-2">Rekening Belum Diatur</h4>
                    <p class="text-gray-400 text-sm mb-6 max-w-sm mx-auto">Untuk keamanan, mohon lengkapi data rekening bank Anda di menu profil sebelum melakukan penarikan.</p>
                    <a href="{{ route('user.profile') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-bold rounded-xl transition shadow-lg shadow-red-900/20">
                        <i class="ph-bold ph-gear"></i> Atur Rekening
                    </a>
                </div>
            @else
                <div class="flex items-center gap-4 mb-8 bg-black/20 p-5 rounded-xl border border-gray-700">
                    <div class="w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center border border-gray-600">
                        <i class="ph-fill ph-bank text-2xl text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-400 text-xs mb-1">Rekening Tujuan:</p>
                        <p class="text-white font-bold text-base">{{ $user->bank_name }} - {{ $user->account_number }}</p>
                        <p class="text-gray-500 text-sm">a.n {{ $user->account_holder }}</p>
                    </div>
                    <a href="{{ route('user.profile') }}" class="text-cyan-400 text-xs hover:text-white border border-cyan-500/30 px-3 py-1.5 rounded-lg hover:bg-cyan-500/10 transition">Ubah</a>
                </div>

                <form id="form-withdraw" action="{{ route('user.wallet.withdraw') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label class="text-gray-400 text-xs font-bold uppercase mb-2 block">Nominal Penarikan</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                            <input type="text" id="wd-amount" name="amount" required placeholder="50.000" 
                                class="input-rupiah w-full bg-[#0B0C15] border border-gray-700 rounded-xl py-4 pl-12 pr-4 text-white text-lg font-bold focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition">
                        </div>
                        <div class="flex justify-between items-center mt-3 px-1">
                            <span class="text-xs text-gray-500">Saldo Tersedia:</span>
                            <span class="text-sm font-bold text-white">Rp {{ number_format($user->wallet->balance) }}</span>
                        </div>
                        <div class="flex justify-end gap-2 mt-2">
                            <button type="button" onclick="fillAmount('wd-amount', 50000)" class="text-[10px] bg-gray-800 hover:bg-gray-700 text-gray-300 px-2 py-1 rounded transition">50rb</button>
                            <button type="button" onclick="fillAmount('wd-amount', 100000)" class="text-[10px] bg-gray-800 hover:bg-gray-700 text-gray-300 px-2 py-1 rounded transition">100rb</button>
                            <button type="button" onclick="fillMaxWithdraw()" class="text-[10px] bg-cyan-500/20 text-cyan-400 hover:bg-cyan-500 hover:text-white px-2 py-1 rounded transition border border-cyan-500/30 font-bold">MAX</button>
                        </div>
                    </div>
                    <button type="button" onclick="confirmWithdraw()" class="w-full py-4 bg-red-600 hover:bg-red-500 text-white font-bold text-lg rounded-xl transition shadow-lg shadow-red-900/20 transform active:scale-[0.98]">
                        Ajukan Penarikan
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div id="tab-transfer" class="hidden animate-fade-in">
        <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6 mb-8 max-w-3xl mx-auto">
            <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                <i class="ph-fill ph-paper-plane-right text-blue-400"></i> Kirim Saldo ke User Lain
            </h3>

            <form id="form-transfer" action="{{ route('user.wallet.transfer') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="text-gray-400 text-xs font-bold uppercase mb-2 block">Email Penerima</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="ph-bold ph-user"></i></span>
                        <input type="email" name="email" id="tf-email" required placeholder="Contoh: budi@gmail.com" 
                            class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl py-4 pl-12 pr-4 text-white font-bold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="text-gray-400 text-xs font-bold uppercase mb-2 block">Nominal Kirim (Rp)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">Rp</span>
                        <input type="text" id="tf-amount" name="amount" required placeholder="10.000" 
                            class="input-rupiah w-full bg-[#0B0C15] border border-gray-700 rounded-xl py-4 pl-12 pr-4 text-white text-lg font-bold focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition">
                    </div>
                    <div class="flex justify-between items-center mt-3 px-1">
                        <span class="text-xs text-gray-500">Saldo Tersedia:</span>
                        <span class="text-sm font-bold text-white">Rp {{ number_format($user->wallet->balance) }}</span>
                    </div>
                </div>

                <button type="button" onclick="confirmTransfer()" class="w-full py-4 bg-blue-600 hover:bg-blue-500 text-white font-bold text-lg rounded-xl transition shadow-lg shadow-blue-900/20 transform active:scale-[0.98]">
                    Konfirmasi Kirim
                </button>
            </form>
        </div>
    </div>


    <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-white text-lg">Riwayat Transaksi</h3>
        <span class="text-xs text-gray-500 bg-gray-800 px-2 py-1 rounded">Terbaru</span>
    </div>

    <div class="space-y-3 pb-24">
        @forelse($transactions as $trx)
            <div class="group flex justify-between items-center bg-[#141625] p-4 rounded-xl border border-gray-800 hover:border-gray-600 hover:bg-[#1a1d2d] transition duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center 
                        {{ in_array($trx->type, ['deposit', 'daily_profit', 'transfer_received']) ? 'bg-green-500/10 text-green-500 group-hover:bg-green-500 group-hover:text-white' : 
                          ($trx->type == 'transfer' ? 'bg-blue-500/10 text-blue-500 group-hover:bg-blue-500 group-hover:text-white' : 'bg-red-500/10 text-red-500 group-hover:bg-red-500 group-hover:text-white') }} transition duration-300">
                        @if($trx->type == 'deposit') <i class="ph-bold ph-arrow-down text-xl"></i>
                        @elseif($trx->type == 'withdraw') <i class="ph-bold ph-arrow-up text-xl"></i>
                        @elseif($trx->type == 'transfer') <i class="ph-bold ph-paper-plane-right text-xl"></i>
                        @elseif($trx->type == 'transfer_received') <i class="ph-bold ph-download-simple text-xl"></i>
                        @else <i class="ph-bold ph-coins text-xl"></i> @endif
                    </div>
                    <div>
                        <p class="text-white text-sm font-bold capitalize">{{ str_replace('_', ' ', $trx->type) }}</p>
                        <p class="text-gray-500 text-[10px]">{{ $trx->created_at->format('d M Y • H:i') }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold {{ in_array($trx->type, ['deposit', 'daily_profit', 'transfer_received']) ? 'text-green-500' : 'text-white' }}">
                        {{ in_array($trx->type, ['deposit', 'daily_profit', 'transfer_received']) ? '+' : '-' }}
                        Rp {{ number_format($trx->amount) }}
                    </p>
                    <span class="text-[10px] uppercase font-bold tracking-wider {{ $trx->status == 'success' ? 'text-green-500' : ($trx->status == 'pending' ? 'text-yellow-500' : 'text-red-500') }}">
                        {{ $trx->status }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-[#141625] rounded-2xl border border-gray-800 border-dashed">
                <p class="text-gray-500 text-sm">Belum ada riwayat transaksi.</p>
            </div>
        @endforelse
        
        <div class="mt-4">{{ $transactions->links() }}</div>
    </div>

@endsection

@push('scripts')
<script>
    // Ambil total saldo user dari PHP ke Variabel JS
    const userBalance = {{ $user->wallet->balance ?? 0 }};
    const minSaldoSisa = 100000; // Minimal Saldo yang harus tersisa

    function switchTab(tab) {
        const btnDefault = "flex-1 py-3 rounded-xl text-sm font-bold transition-all duration-300 text-gray-400 hover:text-white hover:bg-white/5 flex items-center justify-center gap-2";
        
        document.getElementById('tab-deposit').classList.add('hidden');
        document.getElementById('tab-withdraw').classList.add('hidden');
        document.getElementById('tab-transfer').classList.add('hidden');
        
        document.getElementById('btn-deposit').className = btnDefault;
        document.getElementById('btn-withdraw').className = btnDefault;
        document.getElementById('btn-transfer').className = btnDefault;

        if (tab === 'deposit') {
            document.getElementById('tab-deposit').classList.remove('hidden');
            document.getElementById('btn-deposit').className = "flex-1 py-3 rounded-xl text-sm font-bold transition-all duration-300 bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow-lg flex items-center justify-center gap-2 transform scale-105";
        } else if (tab === 'withdraw') {
            document.getElementById('tab-withdraw').classList.remove('hidden');
            document.getElementById('btn-withdraw').className = "flex-1 py-3 rounded-xl text-sm font-bold transition-all duration-300 bg-gradient-to-r from-red-600 to-orange-600 text-white shadow-lg flex items-center justify-center gap-2 transform scale-105";
        } else {
            document.getElementById('tab-transfer').classList.remove('hidden');
            document.getElementById('btn-transfer').className = "flex-1 py-3 rounded-xl text-sm font-bold transition-all duration-300 bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg flex items-center justify-center gap-2 transform scale-105";
        }
    }

    function copyRek() {
        navigator.clipboard.writeText(document.getElementById('rek-admin').innerText);
        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
            background: '#1f2937', color: '#fff',
            didOpen: (toast) => { toast.addEventListener('mouseenter', Swal.stopTimer); toast.addEventListener('mouseleave', Swal.resumeTimer); }
        });
        Toast.fire({ icon: 'success', title: 'Nomor Rekening disalin!' });
    }

    function formatRupiah(angka) {
        let number_string = angka.toString().replace(/[^,\d]/g, ''),
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

    document.querySelectorAll('.input-rupiah').forEach(function(input) {
        input.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value);
        });
    });

    // Helper isi otomatis input berdasarkan ID elemen
    function fillAmount(elementId, val) {
        document.getElementById(elementId).value = formatRupiah(val);
    }

    // Tombol MAX Withdraw (Sisa saldo minimal 100rb)
    function fillMaxWithdraw() {
        let maxTarik = userBalance - minSaldoSisa;
        if(maxTarik > 0) {
            fillAmount('wd-amount', maxTarik);
        } else {
            Swal.fire({ icon: 'error', title: 'Saldo Tidak Cukup', text: 'Saldo aktif Anda kurang dari batas minimum yang bisa ditarik.', background: '#1f2937', color: '#fff' });
        }
    }

    function previewFile(input) {
        const file = input.files[0];
        if (file) {
            const fileNameDisplay = document.getElementById('file-name');
            fileNameDisplay.textContent = 'File terpilih: ' + file.name;
            fileNameDisplay.classList.remove('hidden');
        }
    }

    // ==========================================
    // DEPOSIT SUBMIT
    // ==========================================
    function confirmDeposit() {
        const inputElement = document.getElementById('depo-amount');
        const rawValue = inputElement.value.replace(/\./g, '');
        const amount = parseFloat(rawValue);
        const file = document.querySelector('input[name="payment_proof"]').value;

        if(!amount || amount < 137000) {
            Swal.fire({ icon: 'error', title: 'Nominal Salah', text: 'Minimal deposit Rp 137.000', background: '#1f2937', color: '#fff' });
            return;
        }
        if(!file) {
            Swal.fire({ icon: 'error', title: 'Bukti Kosong', text: 'Harap upload bukti transfer', background: '#1f2937', color: '#fff' });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi', text: "Data sudah benar?", icon: 'question',
            showCancelButton: true, confirmButtonText: 'Ya, Kirim', cancelButtonText: 'Batal',
            background: '#1f2937', color: '#fff'
        }).then((result) => { 
            if (result.isConfirmed) {
                inputElement.value = rawValue;
                document.getElementById('form-deposit').submit(); 
            }
        });
    }

    // ==========================================
    // WITHDRAW SUBMIT (Dengan Validasi Sisa 100rb)
    // ==========================================
    function confirmWithdraw() {
        const inputElement = document.getElementById('wd-amount');
        const rawValue = inputElement.value.replace(/\./g, '');
        let amount = parseFloat(rawValue);

        if(!amount || amount < 50000) {
            Swal.fire({ icon: 'error', title: 'Nominal Salah', text: 'Minimal penarikan Rp 50.000', background: '#1f2937', color: '#fff' });
            return;
        }

        // VALIDASI SISA SALDO 100.000
        let sisaSaldo = userBalance - amount;
        if (sisaSaldo < minSaldoSisa) {
            Swal.fire({ 
                icon: 'error', 
                title: 'Transaksi Ditolak', 
                text: `Saldo minimal yang harus tersisa di dompet adalah Rp 100.000. Saldo Anda saat ini: Rp ${formatRupiah(userBalance)}. Maksimal penarikan: Rp ${formatRupiah(userBalance - minSaldoSisa)}.`, 
                background: '#1f2937', color: '#fff' 
            });
            return;
        }

        const userRole = "{{ $user->role ?? 'member' }}";
        let ppnRate = userRole === 'owner' ? 0 : 0.12; 
        let afiliasiRate = 0.02; 
        let adminRate = 0.21; 
        let totalPersen = (ppnRate + afiliasiRate + adminRate) * 100; 

        let ppnAmount = amount * ppnRate;
        let afiliasiAmount = amount * afiliasiRate;
        let adminAmount = amount * adminRate;

        let totalPotongan = ppnAmount + afiliasiAmount + adminAmount;
        let sisaSetelahPajak = amount - totalPotongan;

        let formatRp = (num) => new Intl.NumberFormat('id-ID').format(num);

        let ppnHtml = userRole === 'owner' 
            ? `<div class="flex justify-between mb-1 text-green-400"><span>PPN (12%)</span><span class="font-bold border border-green-500 px-1 rounded text-[10px]">GRATIS</span></div>`
            : `<div class="flex justify-between mb-1 text-red-400"><span>PPN (12%)</span><span>- Rp ${formatRp(ppnAmount)}</span></div>`;

        Swal.fire({
            title: 'Konfirmasi Penarikan',
            html: `
                <div class="text-left text-sm text-gray-300 mt-4 bg-black/20 p-4 rounded-xl border border-gray-700">
                    <p class="mb-3 text-xs leading-relaxed text-gray-400">
                        Penarikan dana dikenakan potongan biaya layanan sebesar <b class="${userRole === 'owner' ? 'text-yellow-400' : 'text-red-400'}">${totalPersen}%</b> dengan rincian:
                    </p>
                    ${ppnHtml}
                    <div class="flex justify-between mb-1 text-red-400">
                        <span class="pr-2">Afiliasi Owner (2%)</span>
                        <span>- Rp ${formatRp(afiliasiAmount)}</span>
                    </div>
                    <div class="flex justify-between mb-1 text-red-400">
                        <span class="pr-2">Administrasi (21%)</span>
                        <span>- Rp ${formatRp(adminAmount)}</span>
                    </div>
                    <div class="border-t border-gray-600 my-3 pt-3 flex justify-between items-center">
                        <span class="font-bold text-white">Estimasi Diterima</span>
                        <span class="text-green-400 font-bold text-lg">Rp ${formatRp(sisaSetelahPajak)}</span>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-2 text-center">*Sisa saldo dompet Anda setelah ini: Rp ${formatRp(sisaSaldo)}</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Tarik Sekarang',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#ef4444',
            background: '#1f2937', color: '#fff',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl shadow-lg', cancelButton: 'rounded-xl' }
        }).then((result) => { 
            if (result.isConfirmed) {
                inputElement.value = rawValue;
                document.getElementById('form-withdraw').submit(); 
            }
        });
    }

    // ==========================================
    // TRANSFER SUBMIT (Dengan Validasi Sisa 100rb)
    // ==========================================
    function confirmTransfer() {
        const inputElement = document.getElementById('tf-amount');
        const rawValue = inputElement.value.replace(/\./g, '');
        let amount = parseFloat(rawValue);
        const email = document.getElementById('tf-email').value;

        if(!email) {
            Swal.fire({ icon: 'error', title: 'Email Kosong', text: 'Harap masukkan email penerima.', background: '#1f2937', color: '#fff' });
            return;
        }
        if(!amount || amount < 10000) {
            Swal.fire({ icon: 'error', title: 'Nominal Salah', text: 'Minimal transfer Rp 10.000', background: '#1f2937', color: '#fff' });
            return;
        }

        // VALIDASI SISA SALDO 100.000
        let sisaSaldo = userBalance - amount;
        if (sisaSaldo < minSaldoSisa) {
            Swal.fire({ 
                icon: 'error', 
                title: 'Transaksi Ditolak', 
                text: `Saldo minimal yang harus tersisa di dompet adalah Rp 100.000. Saldo Anda saat ini: Rp ${formatRupiah(userBalance)}. Maksimal transfer: Rp ${formatRupiah(userBalance - minSaldoSisa)}.`, 
                background: '#1f2937', color: '#fff' 
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Transfer',
            text: `Saldo Anda akan dipotong sebesar Rp ${formatRupiah(amount)} dan ditahan hingga disetujui Admin. Lanjutkan pengiriman ke ${email}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kirim',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#2563eb',
            background: '#1f2937', color: '#fff',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl shadow-lg', cancelButton: 'rounded-xl' }
        }).then((result) => { 
            if (result.isConfirmed) {
                inputElement.value = rawValue;
                document.getElementById('form-transfer').submit(); 
            }
        });
    }

    // Flash Messages
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", background: '#1f2937', color: '#fff', confirmButtonColor: '#0891b2' });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", background: '#1f2937', color: '#fff', confirmButtonColor: '#ef4444' });
    @endif
    @if($errors->any())
        Swal.fire({ icon: 'error', title: 'Validasi Gagal', html: '<ul class="text-left text-sm list-disc pl-4">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>', background: '#1f2937', color: '#fff' });
    @endif
</script>
<style>
    @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
</style>
@endpush