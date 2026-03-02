<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'whatsapp' => ['required', 'string', 'max:20'], // Tambahan WA
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'], // Cek kode referral valid?
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Cari ID upline jika ada kode referral
        $upline = null;
        if ($request->referral_code) {
            $uplineUser = User::where('referral_code', $request->referral_code)->first();
            $upline = $uplineUser ? $uplineUser->id : null;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
            'role' => 'member', // Default jadi member biasa
            'referral_code' => strtoupper(Str::random(6)), // Generate kode unik buat user ini sendiri
            'referred_by' => $upline, // Siapa yang ngajak
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Setelah daftar, langsung ke Home
        return redirect(route('home'));
    }
}
