<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $product = Product::findOrFail($id);
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->where('product_id', $product->id)->first();

        if ($cart) {
            $cart->jumlah += $request->quantity;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'jumlah' => $request->quantity,
            ]);
        }

        return redirect()->route('produk.detail', $id)->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function viewCart()
    {
        $user = Auth::user();
        $carts = Cart::with('product')->where('user_id', $user->id)->get();

        $total = $carts->sum(function($cart) {
            return $cart->product->harga * $cart->jumlah;
        });

        return view('pembeli.keranjang', compact('carts', 'total'));
    }

    public function deleteItem($id)
{
    $cart = Cart::findOrFail($id);

    if ($cart->user_id != Auth::id()) {
        abort(403, 'Akses tidak sah.');
    }

    $cart->delete();

    return redirect()->route('keranjang')->with('success', 'Produk berhasil dihapus dari keranjang.');
}  

}