<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Investment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // 1. LAPORAN REFERRAL (POHON JARINGAN)
    public function referrals()
    {
        // Cari user yang punya downline, urutkan dari yang terbanyak
        $leaders = User::withCount('referrals')
                    ->having('referrals_count', '>', 0)
                    ->orderByDesc('referrals_count')
                    ->paginate(10); // Ambil 10 Leader teratas per halaman

        // Load detail downline-nya
        foreach ($leaders as $leader) {
            $leader->load('referrals');
        }

        return view('admin.reports.referrals', compact('leaders'));
    }

    // 2. LAPORAN SERVER (BEST SELLER & EXPIRING)
    public function servers()
    {
        // A. Server Paling Laku (Chart Data)
        // Hitung jumlah investasi per produk
        $popularServers = Investment::select('product_id', DB::raw('count(*) as total_sold'))
                            ->groupBy('product_id')
                            ->orderByDesc('total_sold')
                            ->with('product') // Eager load nama produk
                            ->take(5)
                            ->get();

        $chartLabels = $popularServers->map(fn($item) => $item->product->name);
        $chartData = $popularServers->pluck('total_sold');

        // B. Server Mau Expired (Dalam 5 Hari ke depan)
        $expiringInvestments = Investment::with(['user', 'product'])
                                ->where('status', 'active')
                                ->whereBetween('end_date', [now(), now()->addDays(5)])
                                ->orderBy('end_date', 'asc')
                                ->get();

        // C. Ringkasan Total
        $totalActive = Investment::where('status', 'active')->count();
        $totalRevenue = Investment::where('status', 'active')->with('product')->get()->sum(function($i) {
            return $i->product->price;
        });

        return view('admin.reports.servers', compact('chartLabels', 'chartData', 'expiringInvestments', 'totalActive', 'totalRevenue'));
    }
}