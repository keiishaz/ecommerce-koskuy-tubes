<!-- resources/views/admin/kategori.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Kategori</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="{{ asset('js/modernizr.js') }}"></script>
  <script src="{{ asset('js/plugin.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
</head>

<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('admin.sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
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
    </div>
  </div>

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
</body>

</html>
