@extends('layouts.user')

@section('title', 'Pusat Bantuan')

@section('content')

    <div class="text-center mb-8 pt-4">
        <div class="w-20 h-20 bg-gradient-to-tr from-cyan-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-cyan-500/30 animate-bounce-slow">
            <i class="ph-fill ph-headset text-4xl text-white"></i>
        </div>
        <h2 class="text-2xl font-bold text-white">Butuh Bantuan?</h2>
        <p class="text-gray-400 text-sm">Tim kami siap membantu Anda 24/7.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        
        <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20butuh%20bantuan%20terkait%20akun%20saya." target="_blank" class="group relative bg-[#141625] border border-gray-800 hover:border-green-500/50 p-6 rounded-2xl flex items-center gap-4 transition overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-green-500/10 rounded-full blur-2xl -mr-6 -mt-6 transition group-hover:bg-green-500/20"></div>
            
            <div class="w-12 h-12 bg-green-500/20 text-green-500 rounded-xl flex items-center justify-center text-2xl">
                <i class="ph-fill ph-whatsapp-logo"></i>
            </div>
            <div>
                <h3 class="font-bold text-white group-hover:text-green-400 transition">WhatsApp Admin</h3>
                <p class="text-xs text-gray-400">Respon Cepat (Online)</p>
            </div>
            <i class="ph-bold ph-arrow-right ml-auto text-gray-500 group-hover:text-white"></i>
        </a>

        <a href="https://t.me/username_telegram_anda" target="_blank" class="group relative bg-[#141625] border border-gray-800 hover:border-blue-500/50 p-6 rounded-2xl flex items-center gap-4 transition overflow-hidden">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl -mr-6 -mt-6 transition group-hover:bg-blue-500/20"></div>

            <div class="w-12 h-12 bg-blue-500/20 text-blue-500 rounded-xl flex items-center justify-center text-2xl">
                <i class="ph-fill ph-telegram-logo"></i>
            </div>
            <div>
                <h3 class="font-bold text-white group-hover:text-blue-400 transition">Grup Telegram</h3>
                <p class="text-xs text-gray-400">Komunitas & Info</p>
            </div>
            <i class="ph-bold ph-arrow-right ml-auto text-gray-500 group-hover:text-white"></i>
        </a>

    </div>

    <h3 class="font-bold text-white mb-4 pl-2 border-l-4 border-cyan-500">Pertanyaan Umum (FAQ)</h3>
    
    <div class="space-y-3 pb-24">
        
        <details class="group bg-[#141625] border border-gray-800 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between p-4 cursor-pointer list-none bg-white/5 hover:bg-white/10 transition">
                <span class="text-sm font-bold text-gray-300 group-open:text-cyan-400">💰 Berapa lama proses Deposit?</span>
                <i class="ph-bold ph-caret-down text-gray-500 transition-transform group-open:rotate-180"></i>
            </summary>
            <div class="p-4 text-sm text-gray-400 border-t border-gray-700 leading-relaxed">
                Proses deposit biasanya memakan waktu <strong>1-15 menit</strong> setelah Anda mengunggah bukti transfer yang valid. Jika lebih dari itu, silakan hubungi Admin via WhatsApp.
            </div>
        </details>

        <details class="group bg-[#141625] border border-gray-800 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between p-4 cursor-pointer list-none bg-white/5 hover:bg-white/10 transition">
                <span class="text-sm font-bold text-gray-300 group-open:text-cyan-400">🏦 Kapan Withdraw (Penarikan) cair?</span>
                <i class="ph-bold ph-caret-down text-gray-500 transition-transform group-open:rotate-180"></i>
            </summary>
            <div class="p-4 text-sm text-gray-400 border-t border-gray-700 leading-relaxed">
    <i class="ph-fill ph-info text-orange-400 mr-1"></i> 
    Harap diperhatikan bahwa pencairan dana pinjaman memiliki masa tunggu operasional: <strong>40 hari kerja</strong> khusus untuk akun <strong>Owner</strong>, dan <strong>21 hari kerja</strong> bagi <strong>Member Biasa</strong>.
</div>
        </details>

        <details class="group bg-[#141625] border border-gray-800 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between p-4 cursor-pointer list-none bg-white/5 hover:bg-white/10 transition">
                <span class="text-sm font-bold text-gray-300 group-open:text-cyan-400">👑 Bagaimana cara jadi Owner?</span>
                <i class="ph-bold ph-caret-down text-gray-500 transition-transform group-open:rotate-180"></i>
            </summary>
            <div class="p-4 text-sm text-gray-400 border-t border-gray-700 leading-relaxed">
                Anda otomatis menjadi Owner VIP jika menyewa <strong>Server Khusus Owner</strong> atau memiliki total aset sewa minimal Rp 5.675.000.
            </div>
        </details>

        <details class="group bg-[#141625] border border-gray-800 rounded-xl overflow-hidden">
            <summary class="flex items-center justify-between p-4 cursor-pointer list-none bg-white/5 hover:bg-white/10 transition">
                <span class="text-sm font-bold text-gray-300 group-open:text-cyan-400">🔑 Lupa Password Akun?</span>
                <i class="ph-bold ph-caret-down text-gray-500 transition-transform group-open:rotate-180"></i>
            </summary>
            <div class="p-4 text-sm text-gray-400 border-t border-gray-700 leading-relaxed">
                Silakan hubungi Admin melalui WhatsApp dengan menyertakan Email dan Foto KTP untuk verifikasi reset password manual.
            </div>
        </details>

    </div>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s infinite ease-in-out;
        }
    </style>

@endsection