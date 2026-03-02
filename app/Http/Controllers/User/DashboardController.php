<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\Banner; // Tambahkan ini

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Data Dashboard Utama
        $activeServers = Investment::where('user_id', $user->id)->where('status', 'active')->count();
        $totalProfit = Transaction::where('user_id', $user->id)->where('type', 'daily_profit')->sum('amount');
        
        // Ambil 5 Transaksi Terakhir User Sendiri
        $recentTransactions = Transaction::where('user_id', $user->id)->latest()->take(5)->get();

        // --- AMBIL DATA BANNER/IKLAN AKTIF ---
        $banners = Banner::where('is_active', true)->latest()->get();

        // --- FITUR LIVE NOTIFIKASI (HYBRID) ---
        $publicTrx = Transaction::with('user')
                        ->where('status', 'success')
                        ->where('user_id', '!=', $user->id) 
                        ->latest()
                        ->take(10)
                        ->get()
                        ->map(function($trx) {
                            $nameParts = explode(' ', $trx->user->name);
                            $maskedName = $nameParts[0] . ' ' . substr($nameParts[1] ?? '', 0, 1) . '***';
                            
                            $action = '';
                            if($trx->type == 'deposit') $action = 'Deposit';
                            elseif($trx->type == 'withdraw') $action = 'Withdraw';
                            elseif($trx->type == 'daily_profit') $action = 'Profit Misi';
                            else $action = 'Transaksi';

                            return [
                                'name' => $maskedName,
                                'action' => $action,
                                'amount' => 'Rp ' . number_format($trx->amount, 0, ',', '.'),
                                'time' => $trx->created_at->diffForHumans(),
                                'avatar' => $trx->user->photo_profile ?? null
                            ];
                        });

        // Pastikan variabel $banners dikirim ke view
        return view('user.dashboard', compact('user', 'activeServers', 'totalProfit', 'recentTransactions', 'publicTrx', 'banners'));
    }
}