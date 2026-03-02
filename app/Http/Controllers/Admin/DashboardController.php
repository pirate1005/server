<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Investment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. STATISTIK KARTU (Cards)
        $totalMembers = User::where('role', '!=', 'admin')->count();
        $totalOwners = User::where('role', 'owner')->count();

        // Hitung Total Deposit Masuk (Omset)
        $totalDeposit = Transaction::where('type', 'deposit')
                                    ->where('status', 'success')
                                    ->sum('amount');

        // Hitung Server yang sedang Aktif jalan
        $activeServers = Investment::where('status', 'active')->count();


        // 2. DATA CHART: Transaksi 7 Hari Terakhir
        $chartData = Transaction::select(
                            DB::raw('DATE(created_at) as date'), 
                            DB::raw('SUM(amount) as total')
                        )
                        ->where('type', 'deposit') // Hanya deposit yg dihitung grafiknya
                        ->where('status', 'success')
                        ->where('created_at', '>=', Carbon::now()->subDays(7))
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();

        // Format Data untuk JS
        $chartDates = $chartData->pluck('date')->toArray();
        $chartTotals = $chartData->pluck('total')->toArray();

        // 3. DATA TABEL: 5 Transaksi Terakhir
        $latestTransactions = Transaction::with('user')
                                ->latest()
                                ->limit(5)
                                ->get();

        return view('admin.dashboard', compact(
            'totalMembers', 
            'totalOwners', 
            'totalDeposit', 
            'activeServers',
            'chartDates',
            'chartTotals',
            'latestTransactions'
        ));
    }
}