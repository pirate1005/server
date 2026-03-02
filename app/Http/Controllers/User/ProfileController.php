<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|numeric',
            'account_holder' => 'nullable|string',
            'photo_profile' => 'nullable|image|max:10240',
        ]);

        // Update Data Diri & Bank
        $data = $request->only(['name', 'whatsapp', 'bank_name', 'account_number', 'account_holder']);

        // Handle Foto Profil
        if ($request->hasFile('photo_profile')) {
            // Hapus foto lama jika ada
            if ($user->photo_profile) {
                $oldPath = str_replace('/storage/', '', $user->photo_profile);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('photo_profile')->store('profiles', 'public');
            $data['photo_profile'] = '/storage/' . $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:8',
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diganti!');
    }
}