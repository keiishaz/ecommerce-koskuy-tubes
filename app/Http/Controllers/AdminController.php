<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function index() {
        return view('admin.dashboardadmin');
    }

    public function produk(Request $request)
    {
        $categories = Category::all();
        $products = Product::all();
        $productsQuery = Product::query();
         
        // Jika ada kategori yang dipilih
        if ($request->has('category_id') && $request->category_id != '') {
            $productsQuery->where('category_id', $request->category_id);
        }

        // Ambil produk setelah filter
        $products = $productsQuery->get();

        return view('admin.crudbarang', compact('categories', 'products'));
    }

    public function tambahProduk()
    {
        $categories = Category::all();  // Ambil semua kategori
        return view('admin.tambahproduk', compact('categories'));
    }

    // Menyimpan produk baru
    public function simpanProduk(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Menyimpan gambar produk
        $imagePath = $request->file('image')->move(public_path('images/uploadedfile'), $request->file('image')->getClientOriginalName());

        // Menyimpan data produk ke database
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
        // Ambil produk berdasarkan ID
        $product = Product::findOrFail($id);
        $categories = Category::all();  // Ambil semua kategori untuk dropdown

        return view('admin.editproduk', compact('product', 'categories'));
    }

    public function updateProduk(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Jika gambar baru diupload, simpan gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));  // Menghapus gambar lama
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->move(public_path('images/uploadedfile'), $request->file('image')->getClientOriginalName());
            $product->image =  $request->file('image')->getClientOriginalName();  // Update path gambar
        }

        // Update data produk
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
    // Cari produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Hapus gambar terkait jika ada
    if (file_exists(public_path($product->image))) {
        unlink(public_path($product->image));  // Menghapus gambar produk
    }

    // Hapus produk dari database
    $product->delete();

    return redirect()->route('crudbarang')->with('success', 'Produk berhasil dihapus!');
    }

    // Menampilkan daftar kategori
    public function kategori(Request $request)
    {
        $categories = Category::all(); // Ambil semua kategori dari database
        return view('admin.crudkategori', compact('categories'));
    }

    // Menampilkan form tambah kategori
    public function tambahKategori()
    {
        return view('admin.tambahkategori'); // Halaman form tambah kategori
    }

    // Menyimpan kategori baru
    public function simpanKategori(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Simpan kategori ke database
        Category::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form edit kategori
    public function editKategori($id)
    {
        $category = Category::findOrFail($id); // Ambil kategori berdasarkan ID
        return view('admin.editkategori', compact('category'));
    }

    // Update kategori
    public function updateKategori(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Cari kategori dan update
        $category = Category::findOrFail($id);
        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus kategori
    public function hapusKategori($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus!');
    }

}
