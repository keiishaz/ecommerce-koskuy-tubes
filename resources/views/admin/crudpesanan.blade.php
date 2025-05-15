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
    @include('admin.sidebar')

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

      <!-- Grouped Pesanan List -->
      <div class="grid grid-cols-1 gap-6" id="pesanan-list">
        @foreach ($groupedOrders as $date => $orders)
          <div class="bg-white shadow-md rounded-lg p-5">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Pesanan Tanggal: {{ $date }}</h3>
            @foreach ($orders as $order)
              <div class="bg-white shadow-md rounded-lg p-5 mb-4">
                <div class="flex flex-col gap-4">
                  <!-- Info Nama dan Status -->
                  <div class="flex justify-between items-center">
                    <h4 class="text-md font-semibold text-gray-700">Nama Pembeli: <strong>{{ $order->user->name }}</strong></h4>
                    <span class="bg-opacity-20 text-sm font-semibold px-3 py-1 rounded-full
                      @if($order->status == 'Menunggu Pembayaran') bg-yellow-400 text-yellow-800 
                      @elseif($order->status == 'Diproses') bg-green-400 text-green-800 
                      @else bg-red-400 text-red-800 @endif">
                      {{ $order->status }}
                    </span>
                  </div>

                  <!-- Ringkasan Pesanan -->
                  <div>
                    <h5 class="text-sm font-semibold text-gray-700">Ringkasan Pesanan:</h5>
                    <ul class="list-disc ml-5 text-sm text-gray-600">
                      @foreach ($order->items as $item)
                        <li>{{ $item->product->nama }} - {{ $item->jumlah }} x Rp {{ number_format($item->harga) }}</li>
                      @endforeach
                    </ul>
                  </div>

                  <!-- Total Harga (mencolok) -->
                  <div>
                    <p class="text-lg font-bold text-gray-700">Total Harga: Rp {{ number_format($order->total_harga) }}</p>
                  </div>

                  <!-- Status Change Buttons -->
                  <div class="flex justify-end gap-4 mt-4">
                    <form action="{{ route('admin.order.updateStatus', ['order' => $order->id, 'status' => 'Menunggu Pembayaran']) }}" method="POST" class="w-full">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 w-full">
                        Menunggu Pembayaran
                      </button>
                    </form>

                    <form action="{{ route('admin.order.updateStatus', ['order' => $order->id, 'status' => 'Diproses']) }}" method="POST" class="w-full">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 w-full">
                        Diproses
                      </button>
                    </form>

                    <form action="{{ route('admin.order.updateStatus', ['order' => $order->id, 'status' => 'Selesai']) }}" method="POST" class="w-full">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 w-full">
                        Selesai
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      </div>

    </div>
  </div>

  <script>
    // Pencarian Pesanan
    $('#search-pesanan').on('keyup', function () {
      let keyword = $(this).val().toLowerCase();
      $('#pesanan-list .bg-white').each(function () {
        let text = $(this).text().toLowerCase();
        $(this).toggle(text.includes(keyword));
      });
    });
  </script>

</body>

</html>
