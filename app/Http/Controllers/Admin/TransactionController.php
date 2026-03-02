<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // MENAMPILKAN LIST TRANSAKSI
    public function index()
    {
        // Ambil transaksi deposit & withdraw saja (profit harian ga perlu diapprove)
        $transactions = Transaction::with('user')
            ->whereIn('type', ['deposit', 'withdraw'])
            ->latest()
            ->paginate(10);

        return view('admin.transactions.index', compact('transactions'));
    }

    // APPROVE TRANSAKSI (ACC)
    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($transaction) {
            // Jika ini adalah transfer antar user
            if ($transaction->type === 'transfer') {
                // Tambahkan saldo ke penerima
                $receiverWallet = \App\Models\Wallet::where('user_id', $transaction->receiver_id)->first();
                $receiverWallet->increment('balance', $transaction->amount);

                // Buat riwayat sukses untuk penerima (agar muncul di dashboard penerima)
                Transaction::create([
                    'user_id' => $transaction->receiver_id,
                    'type' => 'transfer_received',
                    'amount' => $transaction->amount,
                    'status' => 'success',
                    'description' => 'Menerima transfer dari ' . $transaction->user->email,
                ]);
            }

            // Jika deposit (logika lama Anda)
            elseif ($transaction->type === 'deposit') {
                $transaction->user->wallet->increment('balance', $transaction->amount);
            }

            // Ubah status transaksi utama jadi sukses
            $transaction->update(['status' => 'success']);
        });

        return back()->with('success', 'Transaksi berhasil disetujui.');
    }

    // REJECT TRANSAKSI (TOLAK)
    public function reject(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($transaction) {
            // Jika transfer DITOLAK, kembalikan uangnya ke pengirim
            if ($transaction->type === 'transfer') {
                $transaction->user->wallet->increment('balance', $transaction->amount);
            }

            // Jika withdraw ditolak (uang dikembalikan ke user)
            elseif ($transaction->type === 'withdraw') {
                $transaction->user->wallet->increment('balance', $transaction->amount);
            }

            $transaction->update(['status' => 'failed']); // atau 'rejected'
        });

        return back()->with('success', 'Transaksi berhasil ditolak dan saldo telah dikembalikan (jika ada).');
    }
}
