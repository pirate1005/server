<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // === LOGIKA REDIRECT TERBARU ===
        
        // Ambil role user yang sedang login
        $role = $request->user()->role;

        // 1. Jika ADMIN -> Masuk ke Dashboard Admin (Sidebar Kiri)
        if ($role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // 2. Jika MEMBER / OWNER -> Masuk ke Dashboard User (Navigasi Bawah)
        // Kita arahkan ke route('dashboard') yang menghandle UserDashboardController
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Setelah logout kembali ke halaman depan
        return redirect('/');
    }
}