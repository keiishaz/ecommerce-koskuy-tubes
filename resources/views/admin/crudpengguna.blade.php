@extends('admin.layoutadmin')

@section('content')      

@if (session('success'))
  <div 
    x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, 3000)" 
    x-show="show"
    x-transition
    class="fixed top-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50"
    role="alert"
  >
    <strong class="font-semibold">Sukses!</strong> {{ session('success') }}
  </div>
@endif

      <!-- Header Pengguna -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Daftar Pengguna</h1>
        <a href="{{ route('tambahpengguna') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
          Tambah Pengguna
        </a>
      </div>

      <!-- Pencarian dan Filter Berdasarkan Role -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 mt-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold text-gray-700">Cari Pengguna</h2>
          <div class="w-40">
            <form id="filter-form" method="GET" action="">
              <select name="role" id="filter-role" class="px-4 py-2 border rounded-lg text-gray-700 w-full" onchange="document.getElementById('filter-form').submit()">
                <option value="">Semua Role</option>
                @foreach ($roles as $role)
                  <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                @endforeach
              </select>
            </form>
          </div>
        </div>
      </div>

      <!-- Tabel Pengguna -->
      <div class="bg-white p-5 rounded-lg shadow-md">
        <table class="min-w-full table-auto text-left">
          <thead>
            <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
              <th class="py-3 px-6">No</th>
              <th class="py-3 px-6">Nama</th>
              <th class="py-3 px-6">Email</th>
              <th class="py-3 px-6">Role</th>
              <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 text-sm font-light">
            @forelse ($users as $index => $user)
              <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6">{{ $index + 1 }}</td>
                <td class="py-3 px-6">{{ $user->name }}</td>
                <td class="py-3 px-6">{{ $user->email }}</td>
                <td class="py-3 px-6 text-purple-600 font-semibold">{{ ucfirst($user->role) }}</td>
                <td class="py-3 px-6 text-center">
                  <form action="{{ route('deletePengguna', $user->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus pengguna ini?')" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Hapus</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4">Tidak ada pengguna ditemukan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
@endsection
