@extends('admin.layoutadmin')

@section('content')
      <!-- Header Tambah Produk -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Tambah Produk</h1>
      </div>

      <!-- Form Tambah Produk -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <form action="{{ url('/admin/barang/tambah') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama Produk</label>
                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="w-full px-4 py-2 border rounded-lg" required></textarea>
            </div>

            <div class="mb-4">
                <label for="harga" class="block text-gray-700">Harga</label>
                <input type="number" name="harga" id="harga" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-gray-700">Stok</label>
                <input type="number" name="stok" id="stok" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" class="w-full px-4 py-2 border rounded-lg" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-gray-700">Gambar Produk</label>
                <input type="file" name="image" id="image" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Simpan Produk</button>
            </div>
        </form>
      </div>
@endsection
