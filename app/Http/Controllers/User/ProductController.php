<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Investment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Str; // Pastikan ini di-import

class ProductController extends Controller
{
    // ETALASE PRODUK
    public function index()
    {
        // Ambil semua produk aktif
        $products = Product::where('is_active', true)->get();
        return view('user.products.index', compact('products'));
    }

    // PROSES BELI
    public function buy(Request $request, Product $product)
    {
        $user = Auth::user();

        // 1. Cek Apakah Produk Aktif?
        if (!$product->is_active) {
            return back()->with('error', 'Maaf, server ini sedang tidak tersedia.');
        }

        // 2. Cek Aturan VIP (Hanya Owner yg boleh beli server VIP)
        if ($product->is_exclusive_for_owner && $user->role !== 'owner') {
            return back()->with('error', 'Server ini khusus untuk Member VIP (Owner). Silakan upgrade akun Anda.');
        }

        // 3. Cek Saldo
        if ($user->wallet->balance < $product->price) {
            return back()->with('error', 'Saldo tidak mencukupi. Silakan lakukan Deposit.');
        }

        // 4. Proses Transaksi (Atomic)
        DB::transaction(function () use ($user, $product) {
            // A. Potong Saldo
            $user->wallet->decrement('balance', $product->price);

            // B. Catat Transaksi Pembelian
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'buy_product',
                'amount' => $product->price,
                'status' => 'success',
                'description' => "Sewa Server: {$product->name}",
            ]);

            // C. Buat Investasi Baru (Kontrak Berjalan)
            Investment::create([
                // --- PERBAIKAN DI SINI (Menambahkan invoice_code) ---
                'invoice_code' => 'INV-' . strtoupper(Str::random(10)), 
                // ----------------------------------------------------
                'user_id' => $user->id,
                'product_id' => $product->id,
                'amount_invested' => $product->price,
                'daily_profit' => $product->daily_income,
                'start_date' => now(),
                'end_date' => now()->addDays($product->contract_days),
                'status' => 'active',
                'daily_video_url' => null, 
                'daily_video_key' => null
            ]);

            // D. Cek Auto Upgrade Owner
            if ($product->is_owner_product && $user->role !== 'owner') {
                $user->update(['role' => 'owner']);
            }
        });

        return redirect()->route('user.servers')->with('success', 'Server berhasil disewa! Kontrak investasi dimulai.');
    }
}