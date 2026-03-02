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
        // Ambil semua investasi user, urutkan yang aktif paling atas
        $investments = Investment::with(['product', 'dailyClaims'])
                        ->where('user_id', Auth::id())
                        ->orderByRaw("FIELD(status, 'active', 'pending', 'expired')")
                        ->latest()
                        ->get();

        return view('user.servers.index', compact('investments'));
    }
}