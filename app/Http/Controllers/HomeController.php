<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\About; // <-- 1. Tambahkan/Import Model About di sini

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk aktif, urutkan dari harga termurah
        $products = Product::where('is_active', true)
                            ->orderBy('price', 'asc')
                            ->get();

        // <-- 2. Ambil data Tentang Kami (ambil data pertama)
        $about = About::first(); 

        // <-- 3. Tambahkan 'about' ke dalam fungsi compact()
        return view('home', compact('products', 'about'));
    }
}