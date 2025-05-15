<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function kategori(Request $request)
    {
        $categories = Category::all();
        return view('admin.crudkategori', compact('categories'));
    }

    public function tambahKategori()
    {
        return view('admin.tambahkategori');
    }

    public function simpanKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Category::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function editKategori($id)
    {
        $category = Category::findOrFail($id); 
        return view('admin.editkategori', compact('category'));
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function hapusKategori($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
