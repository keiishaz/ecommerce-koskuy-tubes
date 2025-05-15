<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PesananController extends Controller
{
    public function orders()
    {
    $orders = Order::with('items.product', 'user')
                ->get();

    $groupedOrders = $orders->groupBy(function($order) {
        return $order->created_at->format('Y-m-d');
    });

    return view('admin.crudpesanan', compact('groupedOrders'));
    }

    public function confirmOrder(Order $order)
    {
        $order->status = 'Dikonfirmasi';
        $order->save();

        return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil dikonfirmasi.');
    }

    public function deleteOrder(Order $order)
    {
        foreach ($order->items as $item) {
            $item->delete();
        }

        $order->delete();

        return redirect()->route('admin.orders')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);

        $validStatuses = ['Menunggu Pembayaran', 'Diproses', 'Selesai'];
        
        if (!in_array($status, $validStatuses)) {
            return redirect()->route('crudpesanan')->with('error', 'Status yang dipilih tidak valid.');
        }

        $order->status = $status;
        $order->save();

        return redirect()->route('crudpesanan')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
