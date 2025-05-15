<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
public function index()
{
    $user = Auth::user();

    // Data untuk dashboard
    $incomingOrders = Order::where('status', 'Menunggu Pembayaran')->count();
    $completedOrders = Order::where('status', 'Selesai')->count();
    $totalIncome = Order::where('status', 'Selesai')->sum('total_harga');

    $productCount = Product::count();
    $categoryCount = Category::count();
    $userCount = User::count();

    return view('admin.dashboardadmin', compact(
        'incomingOrders',
        'completedOrders',
        'totalIncome',
        'productCount',
        'categoryCount',
        'userCount'
    ));
}

    public function orders()
    {
    $orders = Order::with('items.product', 'user')
                ->get();

    // Group orders by date, considering created_at
    $groupedOrders = $orders->groupBy(function($order) {
        return $order->created_at->format('Y-m-d'); // Group by date only, not time
    });

    return view('admin.crudpesanan', compact('groupedOrders'));
    }

    // Confirm the order
public function confirmOrder(Order $order)
{
    $order->status = 'Dikonfirmasi';  // Change status to "Confirmed"
    $order->save();

    return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil dikonfirmasi.');
}

// Delete the order
public function deleteOrder(Order $order)
{
    // Delete the order items
    foreach ($order->items as $item) {
        $item->delete();
    }

    // Delete the order
    $order->delete();

    return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil dihapus.');
}

public function updateOrderStatus($orderId, $status)
{
    $order = Order::findOrFail($orderId);

    // Check if the status is one of the allowed statuses
    $validStatuses = ['Menunggu Pembayaran', 'Diproses', 'Selesai'];
    
    if (!in_array($status, $validStatuses)) {
        return redirect()->route('crudpesanan')->with('error', 'Status yang dipilih tidak valid.');
    }

    // Update the order status
    $order->status = $status;
    $order->save();

    return redirect()->route('crudpesanan')->with('success', 'Status pesanan berhasil diperbarui.');
}

public function editProfile() {
    return view('admin.akunadmin');
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        'password' => 'nullable', // Validasi password jika ada
    ]);

    // Update Nama dan Username
    $user->name = $request->name;
    $user->username = $request->username;

    // Jika ada gambar baru, upload gambar dan update path di database
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        $oldPath = public_path('images/uploadedfile/' . $user->image);
        if ($user->image && file_exists($oldPath)) {
            unlink($oldPath);
        }

        // Simpan gambar baru
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images/uploadedfile'), $imageName);
        $user->image = $imageName;
    }

    // Update Password jika ada
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('admin.akun')->with('success', 'Akun berhasil diperbarui.');
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

    public function pengguna(Request $request)
{
    $search = $request->input('search');
    $role = $request->input('role');

    $query = User::query();

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('username', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    if ($role && in_array($role, ['admin', 'pembeli'])) {
        $query->where('role', $role);
    }

    $users = $query->get();
    $roles = User::select('role')->distinct()->pluck('role');

    return view('admin.crudpengguna', compact('users', 'search', 'role', 'roles'));
}

public function tambahPengguna()
{
    return view('admin.tambahpengguna');
}

// Menampilkan form edit pengguna
public function editPengguna($id)
{
    $user = User::findOrFail($id);
    return view('admin.editpengguna', compact('user'));
}

}
