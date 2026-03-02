@extends('layouts.admin')

@section('title', 'Laporan Server')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="p-6 rounded-2xl bg-gradient-to-r from-cyan-900/40 to-[#141625] border border-cyan-500/20">
            <h3 class="text-gray-400 text-sm">Total Unit Server Aktif</h3>
            <p class="text-3xl font-bold text-white mt-2">{{ $totalActive }} <span class="text-lg text-cyan-400">Unit</span></p>
        </div>
        <div class="p-6 rounded-2xl bg-gradient-to-r from-purple-900/40 to-[#141625] border border-purple-500/20">
            <h3 class="text-gray-400 text-sm">Estimasi Nilai Aset User</h3>
            <p class="text-3xl font-bold text-white mt-2">Rp {{ number_format($totalRevenue/1000000, 1) }} <span class="text-lg text-purple-400">Juta</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 bg-[#141625] border border-gray-800 rounded-2xl p-6">
            <h3 class="font-bold text-white mb-6">🏆 Server Terlaris</h3>
            <div id="chartPopular"></div>
        </div>

        <div class="lg:col-span-2 bg-[#141625] border border-gray-800 rounded-2xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-white">⚠️ Kontrak Segera Habis (5 Hari)</h3>
                <span class="text-xs bg-red-500/10 text-red-500 px-2 py-1 rounded font-bold">{{ $expiringInvestments->count() }} Alert</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-gray-500 bg-black/20">
                        <tr>
                            <th class="p-3 rounded-l-lg">User</th>
                            <th class="p-3">Server</th>
                            <th class="p-3">Berakhir Pada</th>
                            <th class="p-3 text-right rounded-r-lg">Sisa Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($expiringInvestments as $inv)
                        <tr>
                            <td class="p-3 font-bold text-white">{{ $inv->user->name }}</td>
                            <td class="p-3 text-cyan-400">{{ $inv->product->name }}</td>
                            <td class="p-3 text-gray-400">{{ $inv->end_date->format('d M Y') }}</td>
                            <td class="p-3 text-right">
                                @php
                                    $daysLeft = now()->diffInDays($inv->end_date, false);
                                @endphp
                                @if($daysLeft <= 1)
                                    <span class="text-red-500 font-bold blink">HARI INI!</span>
                                @else
                                    <span class="text-yellow-500 font-bold">{{ ceil($daysLeft) }} Hari</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="p-6 text-center text-gray-500">Aman. Tidak ada kontrak yang habis dalam 5 hari ke depan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Config Chart Server Terlaris
    var optionsPopular = {
        series: [{
            name: 'Terjual',
            data: @json($chartData)
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            background: 'transparent'
        },
        plotOptions: {
            bar: { borderRadius: 4, horizontal: true, barHeight: '50%' }
        },
        colors: ['#06b6d4'],
        dataLabels: { enabled: true },
        xaxis: {
            categories: @json($chartLabels),
            labels: { style: { colors: '#fff' } }
        },
        yaxis: {
            labels: { style: { colors: '#fff' } }
        },
        grid: { show: false },
        theme: { mode: 'dark' }
    };
    new ApexCharts(document.querySelector("#chartPopular"), optionsPopular).render();
</script>
<style>
    @keyframes blink { 50% { opacity: 0; } }
    .blink { animation: blink 1s linear infinite; }
</style>
@endpush