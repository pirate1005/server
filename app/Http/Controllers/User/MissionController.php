<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Investment;
use App\Models\DailyClaim;
use App\Models\Transaction;
use Carbon\Carbon;

class MissionController extends Controller
{
    // 1. HALAMAN LIST MISI
    public function index()
    {
        $user = Auth::user();

        // Ambil investasi yang AKTIF saja
        $investments = Investment::with(['product', 'dailyClaims' => function($q) {
                            // Ambil klaim HARI INI saja untuk pengecekan status
                            $q->whereDate('created_at', Carbon::today());
                        }])
                        ->where('user_id', $user->id)
                        ->where('status', 'active')
                        ->get();

        return view('user.missions.index', compact('investments'));
    }

    // 2. PROSES KLAIM MISI
    public function claim(Request $request, Investment $investment)
    {
        $request->validate([
            'video_key' => 'required|string',
        ]);

        $user = Auth::user();

        // A. Validasi Kepemilikan
        if ($investment->user_id != $user->id || $investment->status != 'active') {
            return back()->with('error', 'Akses ditolak atau kontrak sudah berakhir.');
        }

        // B. Cek Apakah Sudah Klaim Hari Ini?
        // Kita cek berdasarkan kolom 'date' atau 'created_at' hari ini
        $alreadyClaimed = DailyClaim::where('investment_id', $investment->id)
                            ->whereDate('created_at', Carbon::today())
                            ->exists();

        if ($alreadyClaimed) {
            return back()->with('error', 'Anda sudah mengklaim profit untuk server ini hari ini.');
        }

        // C. Cek Jawaban Kode
        if (strtoupper($request->video_key) !== strtoupper($investment->daily_video_key)) {
            return back()->with('error', 'Kode Kunci Salah! Tonton videonya dengan teliti.');
        }

        // Fallback jika profit null
        $amount = $investment->daily_profit ?? $investment->product->daily_income ?? 0;

        if ($amount <= 0) {
            return back()->with('error', 'Gagal Klaim: Data profit tidak valid.');
        }

        // D. PROSES CAIRKAN PROFIT (Atomic)
        DB::transaction(function () use ($user, $investment, $amount) {
            
            // 1. Catat di Tabel Klaim (PERBAIKAN DISINI)
            DailyClaim::create([
                'investment_id' => $investment->id,
                'amount' => $amount,
                'status' => 'success',
                'date' => now(),        // <--- MENAMBAHKAN FIELD DATE
                'claimed_at' => now(),
            ]);

            // 2. Tambah Saldo User
            $user->wallet->increment('balance', $amount);

            // 3. Catat Riwayat Transaksi
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'daily_profit',
                'amount' => $amount,
                'status' => 'success',
                'description' => "Profit Harian: {$investment->product->name}",
            ]);
        });

        return back()->with('success', 'Selamat! Profit harian berhasil diklaim.');
    }
}