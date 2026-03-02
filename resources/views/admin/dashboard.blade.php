@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="p-6 rounded-2xl bg-[#141625] border border-gray-800">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-400 text-sm">Total Omset</p>
                    <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalDeposit/1000000, 1) }}Jt</h3>
                </div>
                <div class="p-2 bg-green-500/10 rounded-lg text-green-500">💰</div>
            </div>
            <div class="w-full bg-gray-700 h-1.5 rounded-full overflow-hidden">
                <div class="bg-green-500 h-full w-[70%]"></div>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-[#141625] border border-gray-800">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-400 text-sm">Total Member</p>
                    <h3 class="text-2xl font-bold text-white">{{ $totalMembers }}</h3>
                </div>
                <div class="p-2 bg-blue-500/10 rounded-lg text-blue-500">👥</div>
            </div>
            <p class="text-xs text-blue-400 mt-2">+Active User</p>
        </div>

        <div class="p-6 rounded-2xl bg-[#141625] border border-gray-800">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-400 text-sm">Server Aktif</p>
                    <h3 class="text-2xl font-bold text-white">{{ $activeServers }}</h3>
                </div>
                <div class="p-2 bg-purple-500/10 rounded-lg text-purple-500">🖥️</div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Running 24/7</p>
        </div>

        <div class="p-6 rounded-2xl bg-[#141625] border border-gray-800">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-gray-400 text-sm">Owner VIP</p>
                    <h3 class="text-2xl font-bold text-yellow-400">{{ $totalOwners }}</h3>
                </div>
                <div class="p-2 bg-yellow-500/10 rounded-lg text-yellow-500">👑</div>
            </div>
            <p class="text-xs text-yellow-500/80 mt-2">Level Tertinggi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 p-6 rounded-2xl bg-[#141625] border border-gray-800">
            <h3 class="text-lg font-bold mb-6">Grafik Deposit (7 Hari)</h3>
            <div id="chartIncome"></div>
        </div>
        <div class="p-6 rounded-2xl bg-[#141625] border border-gray-800">
            <h3 class="text-lg font-bold mb-6">Ratio Member</h3>
            <div id="chartUsers" class="flex justify-center"></div>
        </div>
    </div>

    <div class="p-6 rounded-2xl bg-[#141625] border border-gray-800">
        <h3 class="text-lg font-bold mb-6">Transaksi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-gray-400 text-sm border-b border-gray-800">
                        <th class="py-3">User</th>
                        <th class="py-3">Jenis</th>
                        <th class="py-3">Jumlah</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach($latestTransactions as $trx)
                    <tr class="border-b border-gray-800/50 hover:bg-gray-800/30 transition">
                        <td class="py-4 font-medium">{{ $trx->user->name }}</td>
                        <td class="py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold uppercase {{ $trx->type == 'deposit' ? 'bg-green-500/10 text-green-500' : 'bg-red-500/10 text-red-500' }}">
                                {{ $trx->type }}
                            </span>
                        </td>
                        <td class="py-4 font-bold text-white">Rp {{ number_format($trx->amount) }}</td>
                        <td class="py-4">
                            <span class="text-{{ $trx->status == 'success' ? 'green' : ($trx->status == 'pending' ? 'yellow' : 'red') }}-500 capitalize">
                                {{ $trx->status }}
                            </span>
                        </td>
                        <td class="py-4 text-gray-400">{{ $trx->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Config Chart Income
    var optionsIncome = {
        series: [{ name: 'Total Deposit', data: @json($chartTotals) }],
        chart: { type: 'area', height: 300, toolbar: { show: false }, background: 'transparent' },
        colors: ['#06b6d4'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.1, stops: [0, 90, 100] } },
        dataLabels: { enabled: false },
        xaxis: { 
            categories: @json($chartDates), 
            labels: { style: { colors: '#9ca3af' } },
            axisBorder: { show: false }, axisTicks: { show: false } 
        },
        yaxis: { labels: { style: { colors: '#9ca3af' } } },
        grid: { borderColor: '#1f2937' },
        theme: { mode: 'dark' }
    };
    new ApexCharts(document.querySelector("#chartIncome"), optionsIncome).render();

    // Config Chart Users
    var optionsUsers = {
        series: [{{ $totalMembers }}, {{ $totalOwners }}],
        labels: ['Member Biasa', 'Owner VIP'],
        chart: { type: 'donut', height: 300, background: 'transparent' },
        colors: ['#3b82f6', '#eab308'],
        plotOptions: { pie: { donut: { size: '70%' } } },
        dataLabels: { enabled: false },
        legend: { position: 'bottom', labels: { colors: '#fff' } },
        stroke: { show: false }
    };
    new ApexCharts(document.querySelector("#chartUsers"), optionsUsers).render();
</script>
@endpush