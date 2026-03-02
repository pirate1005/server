<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load('wallet');

        // Ambil riwayat transaksi
        $transactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('user.wallet.index', compact('user', 'transactions'));
    }

    // PROSES DEPOSIT
    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:137000', // Update Min Deposit
            'payment_proof' => 'required|image|max:2048',
        ]);

        // Upload Gambar
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        Transaction::create([
            'user_id' => Auth::id(),
            'type' => 'deposit',
            'amount' => $request->amount,
            'status' => 'pending', // Menunggu Admin
            'payment_proof' => '/storage/' . $path,
            'description' => 'Top Up Saldo via Transfer Bank',
        ]);

        return back()->with('success', 'Permintaan Deposit berhasil dikirim! Mohon tunggu konfirmasi Admin.');
    }

    // PROSES WITHDRAW
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // Cek apakah user sudah isi data bank?
        if (!$user->bank_name || !$user->account_number) {
            return back()->with('error', 'Harap lengkapi Data Bank di menu Akun sebelum melakukan penarikan.');
        }

        // Cek Saldo Cukup?
        if ($user->wallet->balance < $amount) {
            return back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini.');
        }

        // DATABASE TRANSACTION (PENTING AGAR SALDO TIDAK HILANG JIKA ERROR)
        DB::transaction(function () use ($user, $amount) {
            // 1. Potong Saldo Dulu (Atomic)
            $user->wallet->decrement('balance', $amount);

            // 2. Buat Log Transaksi
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'withdraw',
                'amount' => $amount,
                'status' => 'pending', // Menunggu Admin Transfer
                'description' => "Penarikan ke {$user->bank_name} ({$user->account_number})",
            ]);
        });

        return back()->with('success', 'Permintaan Withdraw berhasil! Dana akan dikirim ke rekening Anda.');
    }

    public function transfer(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'amount' => 'required|numeric|min:10000',
    ]);

    $sender = Auth::user();
    $receiver = User::where('email', $request->email)->first();

    // Validasi tidak boleh transfer ke diri sendiri
    if ($sender->id === $receiver->id) {
        return back()->with('error', 'Tidak bisa melakukan transfer ke akun sendiri.');
    }

    // Validasi saldo cukup
    if ($sender->wallet->balance < $request->amount) {
        return back()->with('error', 'Saldo Anda tidak mencukupi untuk transfer ini.');
    }

    DB::transaction(function () use ($sender, $receiver, $request) {
        // 1. Potong saldo pengirim sekarang (Hold dana)
        $sender->wallet->decrement('balance', $request->amount);

        // 2. Buat transaksi berstatus PENDING
        Transaction::create([
            'user_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'type' => 'transfer',
            'amount' => $request->amount,
            'status' => 'pending',
            'description' => 'Transfer ke ' . $receiver->email,
        ]);
    });

    return back()->with('success', 'Permintaan transfer berhasil. Menunggu persetujuan Admin.');
}
}
