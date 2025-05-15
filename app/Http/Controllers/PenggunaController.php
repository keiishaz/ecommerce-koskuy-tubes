<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function pengguna(Request $request)
    {
        $role = $request->input('role');

        $query = User::query();

        if ($role && in_array($role, ['admin', 'pembeli'])) {
            $query->where('role', $role);
        }

        $users = $query->get();
        $roles = User::select('role')->distinct()->pluck('role');

        return view('admin.crudpengguna', compact('users', 'role', 'roles'));
    }

    public function tambahPengguna()
    {
        return view('admin.tambahpengguna');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role' => 'required|in:admin,pembeli',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('crudpengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('crudpengguna')->with('success', 'Pengguna berhasil dihapus.');
    }
}
