<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();

        $productIds = $request->get('product_id');
        $quantities = $request->get('quantity');

        if (!$productIds) {
            return redirect()->route('keranjang')->with('error', 'Pilih produk yang ingin dipesan.');
        }

        $carts = Cart::with('product')
                     ->where('user_id', $user->id)
                     ->whereIn('product_id', $productIds)
                     ->get();

        foreach ($carts as $cart) {
            $cart->jumlah = $quantities[$cart->product_id];
            $cart->save();
        }

        $total = $carts->sum(function ($cart) {
            return $cart->product->harga * $cart->jumlah;
        });

        return view('pembeli.checkout', compact('carts', 'total'));
    }

    public function storeOrder(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'alamat' => 'required|string',
            'jenis_pembayaran' => 'required|string',
        ]);

        $productIds = $request->get('product_id');
        $quantities = $request->get('quantity');

        if (!$productIds || count($productIds) == 0) {
            return redirect()->route('checkout')->with('error', 'Tidak ada produk yang dipilih.');
        }

        $carts = Cart::with('product')
                     ->where('user_id', $user->id)
                     ->whereIn('product_id', $productIds)
                     ->get();

        $order = new Order();
        $order->user_id = $user->id;
        $order->status = 'Menunggu Pembayaran';
        $order->total_harga = $carts->sum(function($cart) {
            return $cart->product->harga * $cart->jumlah;
        });
        $order->alamat = $request->alamat;
        $order->jenis_pembayaran = $request->jenis_pembayaran;
        $order->save();

        foreach ($carts as $cart) {
            $product = $cart->product;
            $product->stok -= $cart->jumlah;
            $product->save();

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'jumlah' => $cart->jumlah,
                'harga' => $cart->product->harga,
            ]);
        }

        Cart::where('user_id', $user->id)->whereIn('product_id', $productIds)->delete();

        return redirect()->route('pesanan')->with('success', 'Pemesanan berhasil dilakukan.');
    }

    public function pesanan()
    {
        $user = Auth::user();

        $orders = Order::with('items.product')
                    ->where('user_id', $user->id)
                    ->get();

        $groupedOrders = $orders->groupBy(function ($order) {
            return $order->created_at->format('Y-m-d H:i:s');
        });

        return view('pembeli.pesanan', compact('groupedOrders'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id != Auth::id()) {
            return redirect()->route('pesanan')->with('error', 'Anda tidak dapat membatalkan pesanan ini.');
        }

        foreach ($order->items as $item) {
            $item->delete();
        }

        $order->delete();

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function cancelGroupOrder($date)
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
                        ->where('created_at', $date)
                        ->get();

        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stok += $item->jumlah;
                $product->save();

                $item->delete();
            }

            $order->delete();
        }

        return redirect()->route('pesanan')->with('success', 'Semua pesanan pada waktu tersebut telah dibatalkan.');
    }
}

