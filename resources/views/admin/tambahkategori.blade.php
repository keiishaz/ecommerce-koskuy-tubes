@extends('admin.layoutadmin')

@section('content')
      <!-- Header Tambah Kategori -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Tambah Kategori</h1>
      </div>

      <!-- Form Tambah Kategori -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <form action="{{ route('simpanKategori') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama Kategori</label>
                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Simpan Kategori</button>
            </div>
        </form>
      </div>
@endsection
