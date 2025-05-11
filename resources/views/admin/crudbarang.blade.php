<!-- resources/views/admin/crud-barang.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="{{ asset('js/modernizr.js') }}"></script>
  <script src="{{ asset('js/plugin.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
  <script src="{{ asset('js/crud-barang.js') }}"></script>
</head>

<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('admin.sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <!-- Header CRUD Barang -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <div class="flex items-center gap-3">
          <h1 class="text-2xl font-semibold text-gray-700">Daftar Barang</h1>
        </div>
          <!-- Tombol tambah barang -->
          <a href="{{ route('tambahproduk') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
            Tambah Barang
          </a>
      </div>

    <!-- Pencarian dan Filter Berdasarkan Kategori -->
    <div class="bg-white p-5 rounded-lg shadow-md mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-700">Cari Barang</h2>
        <div class="flex gap-4 w-2/3">
        <!-- Dropdown untuk memilih kategori -->
        <div class="w-40">
          <select id="filter-kategori" class="px-4 py-2 border rounded-lg text-gray-700 w-full" onchange="window.location.href=this.value">
              <option value="{{ route('crudbarang') }}">Semua Kategori</option>  <!-- Link untuk menampilkan semua kategori -->
              @foreach ($categories as $category)
                  <option value="{{ route('crudbarang', ['category_id' => $category->id]) }}" 
                  {{ request()->category_id == $category->id ? 'selected' : '' }}>
                      {{ $category->nama }}
                  </option>
              @endforeach
          </select>        
        </div>

            <!-- Input Pencarian Barang -->
            <div class="relative flex-grow">
              <input type="text" id="search-barang" placeholder="Cari berdasarkan nama barang..."
                class="px-4 py-2 border rounded-lg w-full text-gray-700 pl-10"
                value="{{ request()->search }}" />
              <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                <span class="iconify" data-icon="feather:search"></span>
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Menampilkan Barang -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="barang-list">
        <!-- Looping untuk menampilkan semua produk -->
        @foreach ($products as $product)
          <div class="bg-white shadow-md rounded-lg p-5 flex flex-col justify-between card-barang">
            <img src="{{ asset('images/uploadedfile/' . $product->image) }}" alt="Barang"
              class="w-full h-40 object-cover rounded-md mb-4">
            <h3 class="text-lg font-semibold text-gray-700 item-name">{{ $product->nama }}</h3>
            <p class="text-sm text-gray-500">{{ $product->deskripsi }}</p>
            <p class="text-sm text-gray-500 mt-2"><strong>Kategori:</strong> {{ $product->category->nama }}</p>
            <div class="flex justify-between items-center mt-4">
              <span class="text-purple-600 font-semibold">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
              <span class="text-sm text-gray-500">Stok: {{ $product->stok }}</span>
            </div>
            <div class="flex justify-between mt-4">
              <a href="{{ route('editProduk', $product->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Edit</a>
            
              <!-- Tombol Hapus Produk -->
              <form action="{{ route('hapusProduk', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
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

        <!-- Card Barang lainnya... -->
      </div>
    </div>

</body>

</html>