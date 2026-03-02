<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    // Menampilkan halaman kelola banner
    public function index()
    {
        $banners = Banner::latest()->get();
        return view('admin.banners.index', compact('banners'));
    }

    // Menyimpan banner baru
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Maks 5MB
            'title' => 'nullable|string|max:255',
            'target_url' => 'nullable|url',
        ]);

        // Upload Gambar
        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'image_path' => '/storage/' . $path,
            'target_url' => $request->target_url,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Iklan/Banner berhasil ditambahkan!');
    }

    // Mengupdate banner
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'title' => 'nullable|string|max:255',
            'target_url' => 'nullable|url',
        ]);

        $data = [
            'title' => $request->title,
            'target_url' => $request->target_url,
            'is_active' => $request->has('is_active'),
        ];

        // Jika upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            $oldPath = str_replace('/storage/', '', $banner->image_path);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Simpan gambar baru
            $path = $request->file('image')->store('banners', 'public');
            $data['image_path'] = '/storage/' . $path;
        }

        $banner->update($data);

        return back()->with('success', 'Iklan/Banner berhasil diupdate!');
    }

    // Menghapus banner
    public function destroy(Banner $banner)
    {
        // Hapus file gambar dari storage
        $oldPath = str_replace('/storage/', '', $banner->image_path);
        if (Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        $banner->delete();

        return back()->with('success', 'Iklan/Banner berhasil dihapus!');
    }
}