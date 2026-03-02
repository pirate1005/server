<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class UpgradeController extends Controller
{
    public function index()
    {
        return view('user.upgrade.index', ['user' => Auth::user()]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $price = 500000; // Harga Upgrade Owner (Rp 500.000)

        // 1. Cek apakah sudah owner?
        if ($user->role == 'owner') {
            return back()->with('error', 'Anda sudah menjadi Owner!');
        }

        // 2. Cek Saldo
        if ($user->wallet->balance < $price) {
            return back()->with('error', 'Saldo tidak mencukupi. Silakan Deposit terlebih dahulu.');
        }

        // 3. Proses Transaksi
        DB::transaction(function () use ($user, $price) {
            // Potong Saldo
            $user->wallet->decrement('balance', $price);
            
            // Ubah Role jadi Owner
            $user->update(['role' => 'owner']);

            // Catat Log
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'buy_product', // Kita anggap beli produk VIP
                'amount' => $price,
                'status' => 'success',
                'description' => 'Upgrade Akun ke Level OWNER',
            ]);
        });

        return back()->with('success', 'Selamat! Anda resmi menjadi OWNER VIP.');
    }
}