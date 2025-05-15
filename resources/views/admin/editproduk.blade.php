@extends('admin.layoutadmin')

@section('content')      
      <!-- Header Edit Produk -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Edit Produk</h1>
      </div>

      <!-- Form Edit Produk -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <form action="{{ route('updateProduk', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Produk -->
            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama Produk</label>
                <input type="text" name="nama" id="nama" value="{{ $product->nama }}" required
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            <!-- Deskripsi Produk -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="w-full px-4 py-2 border rounded-lg" required>{{ $product->deskripsi }}</textarea>
            </div>

            <!-- Harga Produk -->
            <div class="mb-4">
                <label for="harga" class="block text-gray-700">Harga</label>
                <input type="number" name="harga" id="harga" value="{{ $product->harga }}" required
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            <!-- Stok Produk -->
            <div class="mb-4">
                <label for="stok" class="block text-gray-700">Stok</label>
                <input type="number" name="stok" id="stok" value="{{ $product->stok }}" required
                    class="w-full px-4 py-2 border rounded-lg">
            </div>

            <!-- Kategori Produk -->
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Kategori</label>
                <select name="category_id" id="category_id" class="w-full px-4 py-2 border rounded-lg" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Gambar Produk (Optional) -->
          <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk</label>
            <input type="file" name="image" id="image"
              class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
          </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700">Update Produk</button>
            </div>
        </form>
      </div>
@endsection
