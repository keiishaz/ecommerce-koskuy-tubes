<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request) {
        $category_id = $request->category_id;
        $products = Product::when($category_id, function ($query, $category_id) {
            return $query->where('category_id', $category_id);
        })->latest()->get();
        
        $categories = Category::all();
        return view('pembeli.berandauser', compact('products', 'categories'));    
    }

    public function detailProduk($id) {
        $product = Product::with('category')->findOrFail($id);
        return view('pembeli.detailproduk', compact('product'));
    }

    public function akun()
    {
        return view('pembeli.akun');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->hasFile('image')) {
            $oldPath = public_path('images/uploadedfile/' . $user->image);
            if ($user->image && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/uploadedfile'), $imageName);
            $user->image = $imageName;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('akun')->with('success', 'Akun berhasil diperbarui.');
    }
}
