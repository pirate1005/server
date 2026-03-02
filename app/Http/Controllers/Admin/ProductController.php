<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'daily_income' => 'required|numeric|min:0',
            'contract_days' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        
        // Upload Gambar
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        }

        // Checkbox Handling
        $data['is_owner_product'] = $request->has('is_owner_product');
        $data['is_exclusive_for_owner'] = $request->has('is_exclusive_for_owner');
        $data['is_active'] = $request->has('is_active');

        Product::create($data);

        return redirect()->back()->with('success', 'Server berhasil ditambahkan!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'daily_income' => 'required|numeric',
            'contract_days' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image) {
                $oldPath = str_replace('/storage/', '', $product->image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $data['is_owner_product'] = $request->has('is_owner_product');
        $data['is_exclusive_for_owner'] = $request->has('is_exclusive_for_owner');
        $data['is_active'] = $request->has('is_active');

        $product->update($data);

        return redirect()->back()->with('success', 'Server berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            $oldPath = str_replace('/storage/', '', $product->image);
            Storage::disk('public')->delete($oldPath);
        }
        $product->delete();

        return redirect()->back()->with('success', 'Server berhasil dihapus!');
    }
}   