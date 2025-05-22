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

      <!-- Header Kategori -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Daftar Kategori</h1>
        <a href="{{ route('tambahKategori') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Tambah Kategori</a>
      </div>

      <!-- Pencarian Kategori -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-700">Cari Kategori</h2>
          <div class="relative w-1/2">
            <input type="text" id="search-kategori" placeholder="Cari berdasarkan nama kategori..."
              class="px-4 py-2 border rounded-lg w-full text-gray-700 pl-10" />
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
              <span class="iconify" data-icon="feather:search"></span>
            </span>
          </div>
        </div>
      </div>

      <!-- List Kategori -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="kategori-list">
        <!-- Looping untuk menampilkan kategori dari database -->
        @foreach ($categories as $category)
          <div class="bg-white shadow-md rounded-lg p-5 flex flex-col justify-between card-kategori">
            <div class="mb-4">
              <h3 class="text-lg font-semibold text-gray-700 kategori-nama">{{ $category->nama }}</h3>
              <p class="text-sm text-gray-500 mt-2"><strong>Jumlah Barang:</strong> {{ $category->products->count() }}</p>
            </div>
            <div class="flex justify-between mt-4">
              <!-- Edit Kategori -->
              <a href="{{ route('editKategori', $category->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Edit</a>
              
              <!-- Hapus Kategori -->
              <form action="{{ route('hapusKategori', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
@endsection

@section('scripts')
  <script>
    // Pencarian Kategori
    $('#search-kategori').on('keyup', function () {
      let keyword = $(this).val().toLowerCase();
      $('.card-kategori').each(function () {
        let nama = $(this).find('.kategori-nama').text().toLowerCase();
        $(this).toggle(nama.includes(keyword));
      });
    });
  </script>
@endsection
