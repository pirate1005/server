<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data referral (urutkan dari yang terbaru)
        $referrals = $user->referrals()->latest()->get();

        return view('user.referrals.index', compact('user', 'referrals'));
    }
}