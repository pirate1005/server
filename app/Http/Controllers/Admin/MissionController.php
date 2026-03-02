<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Investment;
use App\Models\DailyClaim;

class MissionController extends Controller
{
    // 1. HALAMAN UTAMA (SETTING MISI)
    public function index()
    {
        // Ambil semua produk yang aktif untuk disetting misinya
        $products = Product::where('is_active', true)->get();
        return view('admin.missions.index', compact('products'));
    }

    // 2. PROSES UPDATE MISI HARIAN
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'video_url' => 'required|url',
            'video_key' => 'required|string|max:20',
        ]);

        // STRATEGI: Update massal ke semua tabel Investment yang Aktif & Produknya sesuai
        // Jadi semua member yang punya server ini langsung dapet tugas baru
        $affected = Investment::where('product_id', $request->product_id)
                    ->where('status', 'active')
                    ->update([
                        'daily_video_url' => $request->video_url,
                        'daily_video_key' => $request->video_key,
                        'updated_at' => now(),
                    ]);

        return redirect()->back()->with('success', "Misi berhasil disebar ke {$affected} penyewa aktif!");
    }

    // 3. HALAMAN LOG ABSENSI (SIAPA YG SUDAH KERJAKAN?)
    public function logs()
    {
        // Ambil data klaim harian terbaru
        $logs = DailyClaim::with(['investment.user', 'investment.product'])
                ->latest()
                ->paginate(20);

        return view('admin.missions.logs', compact('logs'));
    }
}