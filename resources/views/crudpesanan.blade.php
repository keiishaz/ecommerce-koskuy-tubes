<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Daftar Pesanan</title>
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
    @include('sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <!-- Header Pesanan -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Daftar Pesanan</h1>
      </div>

      <!-- Pencarian Pesanan -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-700">Cari Pesanan</h2>
          <div class="relative w-1/2">
            <input type="text" id="search-pesanan" placeholder="Cari berdasarkan nama barang atau pengguna..."
              class="px-4 py-2 border rounded-lg w-full text-gray-700 pl-10" />
            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
              <span class="iconify" data-icon="feather:search"></span>
            </span>
          </div>
        </div>
      </div>

      <!-- List Pesanan -->
      <div class="grid grid-cols-1 gap-6" id="pesanan-list">
        <!-- Contoh Pesanan -->
        <div class="bg-white shadow-md rounded-lg p-5 flex flex-col gap-4 card-pesanan">
          <div class="flex flex-wrap justify-between items-start">
            <div>
              <h3 class="text-lg font-semibold text-gray-700 pesanan-barang">Nama Barang: Headset Gaming</h3>
              <p class="text-sm text-gray-500 mt-1">Nama Pembeli: <strong>Ali Rahman</strong></p>
              <p class="text-sm text-gray-500 mt-1">Jumlah: <strong>2</strong></p>
              <p class="text-sm text-gray-500 mt-1">Harga Satuan: <strong>Rp 250.000</strong></p>
              <p class="text-sm text-gray-500 mt-1">Total Harga: <strong>Rp 500.000</strong></p>
              <p class="text-sm text-gray-500 mt-1">Status: <span class="text-yellow-500 font-medium">Menunggu Konfirmasi</span></p>
            </div>
            <div class="flex flex-col gap-2 mt-4 md:mt-0">
              <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Konfirmasi</button>
              <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</button>
            </div>
          </div>
        </div>

        <!-- Pesanan lainnya -->
        <div class="bg-white shadow-md rounded-lg p-5 flex flex-col gap-4 card-pesanan">
          <div class="flex flex-wrap justify-between items-start">
            <div>
              <h3 class="text-lg font-semibold text-gray-700 pesanan-barang">Nama Barang: Jaket Kulit</h3>
              <p class="text-sm text-gray-500 mt-1">Nama Pembeli: <strong>Sinta Dewi</strong></p>
              <p class="text-sm text-gray-500 mt-1">Jumlah: <strong>1</strong></p>
              <p class="text-sm text-gray-500 mt-1">Harga Satuan: <strong>Rp 400.000</strong></p>
              <p class="text-sm text-gray-500 mt-1">Total Harga: <strong>Rp 400.000</strong></p>
              <p class="text-sm text-gray-500 mt-1">Status: <span class="text-green-500 font-medium">Dikonfirmasi</span></p>
            </div>
            <div class="flex flex-col gap-2 mt-4 md:mt-0">
              <button class="bg-gray-400 text-white px-4 py-2 rounded-md cursor-not-allowed" disabled>Selesai</button>
              <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Pencarian Pesanan
    $('#search-pesanan').on('keyup', function () {
      let keyword = $(this).val().toLowerCase();
      $('.card-pesanan').each(function () {
        let text = $(this).text().toLowerCase();
        $(this).toggle(text.includes(keyword));
      });
    });
  </script>
</body>

</html>
