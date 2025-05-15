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

class AdminController extends Controller
{
    public function index()
    {
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

    public function editProfile() {
        return view('admin.akunadmin');
    }

    public function updateProfile(Request $request)
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

    return redirect()->route('admin.dashboardadmin')->with('success', 'Akun berhasil diperbarui.');
    }
}
