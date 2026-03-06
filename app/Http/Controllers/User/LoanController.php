<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoanCode; // <-- Import Model di sini

class LoanController extends Controller
{
    public function index()
    {
        return view('user.loan.index');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'unique_code' => 'required|string'
        ]);

        $kode_input = strtoupper($request->unique_code);

        // Cari kode menggunakan Model Eloquent
        $loanCode = LoanCode::where('code', $kode_input)->first();

        if (!$loanCode) {
            return back()->with('error', 'Kode Unik tidak ditemukan. Silakan periksa kembali ketikan Anda.');
        }

        if ($loanCode->is_used) {
            return back()->with('error', 'Maaf, Kode Unik ini sudah diklaim dan tidak berlaku lagi.');
        }

        // Tandai kode menjadi terpakai
        $loanCode->update([
            'is_used' => true,
            'used_by' => Auth::id(),
            'used_at' => now(),
        ]);

        $limit_rp = number_format($loanCode->limit_amount, 0, ',', '.');

        return back()->with('success', "Kode Valid! Selamat, Anda mendapatkan limit pinjaman sebesar Rp $limit_rp. Admin akan segera menghubungi Anda untuk pencairan.");
    }
}