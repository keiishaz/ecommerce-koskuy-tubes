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
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('admin.sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <!-- Akun Profil di Atas Dashboard -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
        <img src="{{ asset('images/uploadedfile/' . (Auth::user()->image ?? 'default.png')) }}"
            alt="Admin"
            class="w-12 h-12 rounded-full border-2 border-purple-600">
          <div>
            <p class="text-lg font-semibold text-gray-700">{{ Auth::user()->name }}</p>
            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
          </div>
        </div>
        <a href="{{ route('admin.akun') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Edit Profil</a>
      </div>

<!-- Judul Bagian Pesanan & Pendapatan -->
<h2 class="text-lg font-semibold text-gray-700 mb-2">Ringkasan Pesanan</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Pesanan Masuk -->
    <div class="bg-white rounded-xl shadow p-5 border-t-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Pesanan Masuk</p>
                <p class="text-3xl font-bold text-purple-600">{{ $incomingOrders }}</p>
            </div>
            <span class="iconify text-3xl text-purple-500" data-icon="mdi:cart-outline"></span>
        </div>
    </div>

    <!-- Pesanan Selesai -->
    <div class="bg-white rounded-xl shadow p-5 border-t-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Pesanan Selesai</p>
                <p class="text-3xl font-bold text-green-600">{{ $completedOrders }}</p>
            </div>
            <span class="iconify text-3xl text-green-500" data-icon="mdi:check-circle-outline"></span>
        </div>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-white rounded-xl shadow p-5 border-t-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                <p class="text-xl font-bold text-yellow-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <span class="iconify text-3xl text-yellow-500" data-icon="mdi:currency-usd"></span>
        </div>
    </div>
</div>

<!-- Judul Bagian Statistik -->
<h2 class="text-lg font-semibold text-gray-700 mb-2">Statistik Sistem</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Jumlah Barang -->
    <div class="bg-white rounded-xl shadow p-6 border-t-4 border-indigo-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Jumlah Barang</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $productCount }}</p>
            </div>
            <span class="iconify text-3xl text-indigo-500" data-icon="mdi:cube-outline"></span>
        </div>
    </div>

    <!-- Jumlah Kategori -->
    <div class="bg-white rounded-xl shadow p-6 border-t-4 border-pink-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Jumlah Kategori</p>
                <p class="text-3xl font-bold text-pink-600">{{ $categoryCount }}</p>
            </div>
            <span class="iconify text-3xl text-pink-500" data-icon="mdi:shape-outline"></span>
        </div>
    </div>

    <!-- Total Pengguna -->
    <div class="bg-white rounded-xl shadow p-6 border-t-4 border-gray-600">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Pengguna</p>
                <p class="text-3xl font-bold text-gray-700">{{ $userCount }}</p>
            </div>
            <span class="iconify text-3xl text-gray-700" data-icon="mdi:account-group-outline"></span>
        </div>
    </div>

</div>
      </div>
    </div>
  </div>
</body>
</html>
