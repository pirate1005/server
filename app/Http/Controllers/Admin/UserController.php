<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // 1. LIST USER
    public function index(Request $request)
    {
        $query = User::with('wallet')->where('role', '!=', 'admin')->latest();

        // Fitur Cari User
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('whatsapp', 'like', "%$search%");
            });
        }

        $users = $query->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    // 2. DETAIL USER (Show Profile)
    public function show(User $user)
    {
        // Load data dompet, upline, dan history transaksi
        $user->load(['wallet', 'upline', 'referrals', 'wallet']);
        
        // Ambil 10 transaksi terakhir user ini
        $transactions = Transaction::where('user_id', $user->id)->latest()->limit(10)->get();

        return view('admin.users.show', compact('user', 'transactions'));
    }

    // 3. SUSPEND / BAN USER
    public function toggleStatus(User $user)
    {
        // Admin tidak bisa ban dirinya sendiri atau sesama admin
        if ($user->role == 'admin') return back()->with('error', 'Tidak bisa memblokir Admin.');

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan kembali' : 'DIBLOKIR';
        return back()->with('success', "User berhasil $status.");
    }

    // 4. RESET PASSWORD (Default: 12345678)
    public function resetPassword(User $user)
    {
        $user->password = Hash::make('12345678');
        $user->save();

        return back()->with('success', 'Password user direset menjadi: 12345678');
    }

    // 5. EDIT SALDO MANUAL (DARURAT)
    public function updateBalance(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric', // Boleh minus jika ingin kurangi saldo
            'note' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $user) {
            $wallet = $user->wallet ?? Wallet::create(['user_id' => $user->id, 'balance' => 0]);
            
            // Update Saldo
            $wallet->balance += $request->amount;
            $wallet->save();

            // CATAT LOG TRANSAKSI (Penting!)
            Transaction::create([
                'user_id' => $user->id,
                'type' => $request->amount >= 0 ? 'deposit' : 'withdraw', // Penanda manual
                'amount' => abs($request->amount),
                'status' => 'success',
                'description' => 'Manual Admin: ' . $request->note
            ]);
        });

        return back()->with('success', 'Saldo berhasil disesuaikan.');
    }
}