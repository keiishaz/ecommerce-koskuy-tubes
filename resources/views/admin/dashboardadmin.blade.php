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
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('admin.sidebar')

<div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
  <!-- Akun Profil di Atas Dashboard -->
  <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex items-center justify-between">
    <div class="flex items-center gap-3">
      <img src="{{ asset('images/profile.jpg') }}" alt="Admin" class="w-12 h-12 rounded-full border-2 border-purple-600">
      <div>
        <p class="text-lg font-semibold text-gray-700">Admin</p>
        <p class="text-sm text-gray-500">admin@example.com</p>
      </div>
    </div>
    <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Edit Profil</button>
  </div>

  <!-- Card Ringkasan Dashboard -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Pesanan Masuk -->
    <div class="bg-white shadow-md rounded-lg p-5 flex flex-col justify-between">
      <div class="flex items-center gap-3">
        <span class="iconify text-purple-600 text-2xl" data-icon="mdi:cart-outline"></span>
        <h2 class="text-lg font-semibold text-gray-700">Pesanan Masuk</h2>
      </div>
      <p class="text-3xl font-bold text-purple-600 mt-3">1,240</p>
    </div>

    <!-- Pesanan Selesai -->
    <div class="bg-white shadow-md rounded-lg p-5 flex flex-col justify-between">
      <div class="flex items-center gap-3">
        <span class="iconify text-green-500 text-2xl" data-icon="mdi:check-circle-outline"></span>
        <h2 class="text-lg font-semibold text-gray-700">Pesanan Selesai</h2>
      </div>
      <p class="text-3xl font-bold text-green-500 mt-3">980</p>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-white shadow-md rounded-lg p-5 flex flex-col justify-between">
      <div class="flex items-center gap-3">
        <span class="iconify text-yellow-500 text-2xl" data-icon="mdi:currency-usd"></span>
        <h2 class="text-lg font-semibold text-gray-700">Total Pendapatan</h2>
      </div>
      <p class="text-3xl font-bold text-yellow-500 mt-3">Rp 500,000,000</p>
    </div>
  </div>

  <!-- Status Pesanan Terakhir -->
  <div class="bg-white p-5 rounded-lg shadow-md mb-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Status Pesanan Terakhir</h2>
    <div class="flex justify-between">
      <span class="text-gray-600">ID Pesanan: #1234</span>
      <span class="text-green-500">Selesai</span>
    </div>
  </div>

  <!-- Notifikasi -->
  <div class="bg-white p-5 rounded-lg shadow-md mb-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Notifikasi</h2>
    <p class="text-sm text-gray-400">Belum ada notifikasi baru</p>
  </div>

  <!-- Grafik Penjualan Berdasarkan Kategori -->
  <div class="bg-white p-5 rounded-lg shadow-md mb-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Grafik Penjualan Berdasarkan Kategori</h2>
    <canvas id="salesChart" class="w-full h-48"></canvas>
  </div>
</div>

  <script>
    const ctx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Makanan', 'Minuman', 'Elektronik', 'Fashion'],
        datasets: [{
          label: 'Total Penjualan',
          data: [120, 80, 45, 60],
          backgroundColor: ['#8b5cf6', '#10b981', '#3b82f6', '#f59e0b']
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>