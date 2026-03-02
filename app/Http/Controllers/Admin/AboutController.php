<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    // Menampilkan form edit Tentang Kami
    public function index()
    {
        // Ambil data pertama dari tabel, jika kosong biarkan null
        $about = About::first();
        
        return view('admin.about.index', compact('about'));
    }

    // Menyimpan / Mengupdate data Tentang Kami
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Maksimal 5MB
        ]);

        $about = About::first();

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        // Jika Admin mengupload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($about && $about->image_path) {
                $oldPath = str_replace('/storage/', '', $about->image_path);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Simpan gambar baru
            $path = $request->file('image')->store('abouts', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        // UpdateOrCreate (Jika sudah ada data, di-update. Jika kosong, di-create)
        if ($about) {
            $about->update($data);
        } else {
            About::create($data);
        }

        return back()->with('success', 'Halaman Tentang Kami berhasil diperbarui!');
    }
}