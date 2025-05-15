<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Http\Controllers;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request) {
        // Menampilkan produk berdasarkan kategori jika parameter category_id ada
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

    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validasi gambar
        'password' => 'nullable',  // Validasi password jika ada
    ]);

    // Update Nama dan Username
    $user->name = $request->name;
    $user->username = $request->username;

    // Jika ada gambar baru, upload gambar dan update path di database
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($user->image && Storage::exists('public/uploadedfiles/' . $user->image)) {
            Storage::delete('public/uploadedfiles/' . $user->image);
        }

        // Generate a new filename for the uploaded image
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();

        // Move the image to the 'public/images/uploadedfile' folder
        $request->file('image')->move(public_path('images/uploadedfile'), $imageName);

        // Update the image name in the database
        $user->image = $imageName;
    }

    // Update Password jika ada
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    // Simpan perubahan
    $user->save();

    return redirect()->route('akun')->with('success', 'Akun berhasil diperbarui.');
}



    public function addToCart(Request $request, $id)
    {
        // Validasi jumlah yang dimasukkan
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Ambil ID pengguna yang sedang login
        $user = Auth::user();

        // Cek apakah produk sudah ada di keranjang
        $cart = Cart::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();

        if ($cart) {
            // Jika sudah ada di keranjang, update jumlahnya
            $cart->jumlah += $request->quantity;
            $cart->save();
        } else {
            // Jika belum ada di keranjang, tambahkan produk baru
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'jumlah' => $request->quantity,
            ]);
        }

        // Kembali ke halaman produk atau keranjang
        return redirect()->route('produk.detail', $id)->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Fungsi untuk menampilkan keranjang
    public function viewCart()
    {
    $user = Auth::user();
    $carts = Cart::with('product')->where('user_id', $user->id)->get(); // Ambil semua produk di keranjang

    $total = $carts->sum(function($cart) {
        return $cart->product->harga * $cart->jumlah; // Hitung subtotal setiap produk
    });

    return view('pembeli.keranjang', compact('carts', 'total'));    
    }

    public function buyNow(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->quantity;

        // Tambahkan produk ke keranjang
        $this->addToCart($request, $id);

        // Setelah menambahkan ke keranjang, langsung redirect ke halaman checkout
        return redirect()->route('checkout')->with('success', 'Produk berhasil ditambahkan ke keranjang. Lanjutkan ke pembayaran!');
    }

// Fungsi untuk menghapus produk dari keranjang
public function removeFromCart($cartId)
{
    $cart = Cart::findOrFail($cartId);
    $cart->delete();

    return redirect()->route('keranjang')->with('success', 'Produk berhasil dihapus dari keranjang!');
}

// Fungsi untuk melanjutkan ke checkout berdasarkan produk yang dipilih
public function checkout(Request $request)
{
    $user = Auth::user();

    // Ambil produk yang dipilih dari keranjang
    $productIds = $request->get('product_id');
    $quantities = $request->get('quantity');

    if (!$productIds) {
        return redirect()->route('keranjang')->with('error', 'Pilih produk yang ingin dipesan.');
    }

    // Ambil produk dari keranjang berdasarkan produk yang dipilih
    $carts = Cart::with('product')
                 ->where('user_id', $user->id)
                 ->whereIn('product_id', $productIds)
                 ->get();

    // Update jumlah produk yang dipilih
    foreach ($carts as $cart) {
        $cart->jumlah = $quantities[$cart->product_id];
        $cart->save();
    }

    // Menghitung total harga keranjang
    $total = $carts->sum(function ($cart) {
        return $cart->product->harga * $cart->jumlah;
    });

    return view('pembeli.checkout', compact('carts', 'total'));
}

public function storeOrder(Request $request)
{
    $user = Auth::user();

    // Validasi input alamat dan metode pembayaran
    $request->validate([
        'alamat' => 'required|string',
        'jenis_pembayaran' => 'required|string',
    ]);

    // Ambil produk dari keranjang
    $productIds = $request->get('product_id');
    $quantities = $request->get('quantity');

    // Validasi apakah produk yang dipilih ada
    if (!$productIds || count($productIds) == 0) {
        return redirect()->route('checkout')->with('error', 'Tidak ada produk yang dipilih.');
    }

    // Ambil produk dari keranjang berdasarkan produk yang dipilih
    $carts = Cart::with('product')
                 ->where('user_id', $user->id)
                 ->whereIn('product_id', $productIds)
                 ->get();

    // Membuat pesanan baru
    $order = new Order();
    $order->user_id = $user->id;
    $order->status = 'Menunggu Pembayaran';  // Status awal
    $order->total_harga = $carts->sum(function($cart) {
        return $cart->product->harga * $cart->jumlah;
    });
    $order->alamat = $request->alamat;  // Alamat dari form
    $order->jenis_pembayaran = $request->jenis_pembayaran;  // Jenis pembayaran dari form
    $order->save();

    // Menyimpan order items ke dalam tabel order_items
    foreach ($carts as $cart) {
        // Kurangi stok produk yang dipesan
        $product = $cart->product;
        $product->stok -= $cart->jumlah;
        $product->save();

        // Menyimpan item ke tabel order_items
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $cart->product_id,
            'jumlah' => $cart->jumlah,
            'harga' => $cart->product->harga,
        ]);
    }

    // Hapus produk yang sudah dipesan dari keranjang
    Cart::where('user_id', $user->id)->whereIn('product_id', $productIds)->delete();

    // Redirect ke halaman pesanan setelah berhasil membuat pesanan
    return redirect()->route('pesanan')->with('success', 'Pemesanan berhasil dilakukan.');
}


public function pesanan()
{
    $user = Auth::user();

    // Ambil semua pesanan pengguna
    $orders = Order::with('items.product')  // Mengambil item dan produk terkait
                ->where('user_id', $user->id)
                ->get();

    // Group berdasarkan tanggal dan waktu lengkap (termasuk detik)
    $groupedOrders = $orders->groupBy(function ($order) {
        return $order->created_at->format('Y-m-d H:i:s');  // Mengelompokkan berdasarkan tanggal dan waktu lengkap (termasuk detik)
    });

    return view('pembeli.pesanan', compact('groupedOrders'));
}


public function cancelOrder($orderId)
{
    $order = Order::findOrFail($orderId);

    // Pastikan hanya pesanan milik user yang bisa dibatalkan
    if ($order->user_id != Auth::id()) {
        return redirect()->route('pesanan')->with('error', 'Anda tidak dapat membatalkan pesanan ini.');
    }

    // Hapus item terkait pesanan
    foreach ($order->items as $item) {
        $item->delete();
    }

    // Hapus pesanan
    $order->delete();

    return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibatalkan.');
}

public function cancelGroupOrder($date)
{
    $user = Auth::user();

    // Ambil semua pesanan berdasarkan user dan waktu penuh (termasuk detik)
    $orders = Order::where('user_id', $user->id)
                    ->where('created_at', $date)
                    ->get();

    // Loop untuk menghapus semua item pesanan
    foreach ($orders as $order) {
        // Menghapus item pesanan
        foreach ($order->items as $item) {
            // Mengembalikan stok produk
            $product = $item->product;
            $product->stok += $item->jumlah;
            $product->save();

            // Menghapus item dari order
            $item->delete();
        }

        // Menghapus pesanan
        $order->delete();
    }

    return redirect()->route('pesanan')->with('success', 'Semua pesanan pada waktu tersebut telah dibatalkan.');
}



}
