<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function produk(Request $request)
    {
        $categories = Category::all();
        $productsQuery = Product::query();
         
        if ($request->has('category_id') && $request->category_id != '') {
            $productsQuery->where('category_id', $request->category_id);
        }

        $products = $productsQuery->get();

        return view('admin.crudbarang', compact('categories', 'products'));
    }

    public function tambahProduk()
    {
        $categories = Category::all();  
        return view('admin.tambahproduk', compact('categories'));
    }

    public function simpanProduk(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image')->move(public_path('images/uploadedfile'), $request->file('image')->getClientOriginalName());

        Product::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'image' => $request->file('image')->getClientOriginalName(),
        ]);

        return redirect()->route('crudbarang')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduk($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.editproduk', compact('product', 'categories'));
    }

    public function updateProduk(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $imagePath = $request->file('image')->move(public_path('images/uploadedfile'), $request->file('image')->getClientOriginalName());
            $product->image =  $request->file('image')->getClientOriginalName(); 
        }

        $product->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('crudbarang')->with('success', 'Produk berhasil diperbarui!');
    }

    public function hapusProduk($id) {
        $product = Product::findOrFail($id);

        if (file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('crudbarang')->with('success', 'Produk berhasil dihapus!');
    }
}
