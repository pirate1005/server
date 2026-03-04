<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Investment;
use Carbon\Carbon;

class ServerController extends Controller
{
    public function index()
    {
        // Ambil semua investasi user, hubungkan (join) dengan tabel products
        $investments = Investment::select('investments.*') // Wajib agar ID product tidak menimpa ID investment
                        ->join('products', 'investments.product_id', '=', 'products.id')
                        ->with(['product', 'dailyClaims'])
                        ->where('investments.user_id', Auth::id())
                        // 1. Urutkan berdasarkan status (Active paling atas, expired paling bawah)
                        ->orderByRaw("FIELD(investments.status, 'active', 'pending', 'expired')")
                        // 2. Urutkan berdasarkan HARGA SERVER dari termurah ke termahal
                        ->orderBy('products.price', 'asc') 
                        ->get();

        return view('user.servers.index', compact('investments'));
    }
}