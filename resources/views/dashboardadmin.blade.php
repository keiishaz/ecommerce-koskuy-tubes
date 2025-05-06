<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
  <script src="{{ asset('js/dashboard.js') }}" defer></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="card-dashboard bg-white shadow-md rounded-lg p-5 flex flex-col justify-between">
          <div class="flex items-center gap-3">
            <span class="iconify text-purple-600 text-2xl" data-icon="mdi:cart-outline"></span>
            <h2 class="text-lg font-semibold text-gray-700">Barang Terjual</h2>
          </div>
          <p class="text-3xl font-bold text-purple-600 mt-3">1,240</p>
        </div>

        <div class="card-dashboard bg-white shadow-md rounded-lg p-5 flex flex-col justify-between">
          <div class="flex items-center gap-3">
            <span class="iconify text-pink-500 text-2xl" data-icon="mdi:package-variant-closed"></span>
            <h2 class="text-lg font-semibold text-gray-700">Pesanan Masuk</h2>
          </div>
          <p class="text-3xl font-bold text-pink-500 mt-3">325</p>
        </div>

        <div class="card-dashboard bg-white shadow-md rounded-lg p-5 flex flex-col justify-between">
          <div class="flex items-center gap-3">
            <span class="iconify text-blue-500 text-2xl" data-icon="mdi:bell-outline"></span>
            <h2 class="text-lg font-semibold text-gray-700">Notifikasi</h2>
          </div>
          <p class="text-sm text-gray-400 mt-3">Belum ada notifikasi baru</p>
        </div>
      </div>

      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Grafik Penjualan</h2>
        <canvas id="salesChart" class="w-full h-48"></canvas>
      </div>

      <div class="bg-white p-5 rounded-lg shadow-md overflow-x-auto">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Daftar Barang</h2>
        <table class="min-w-full table-auto">
          <thead class="bg-gray-100 text-sm font-semibold text-gray-600">
            <tr>
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">Nama</th>
              <th class="px-4 py-2">Stok</th>
              <th class="px-4 py-2">Harga</th>
              <th class="px-4 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b hover:bg-gray-50">
              <td class="px-4 py-2">1</td>
              <td class="px-4 py-2">Contoh Barang</td>
              <td class="px-4 py-2">20</td>
              <td class="px-4 py-2">Rp 150.000</td>
              <td class="px-4 py-2 space-x-2">
                <button class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">Edit</button>
                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
