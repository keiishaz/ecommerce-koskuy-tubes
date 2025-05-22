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
                  @if ($order->status !== 'Selesai')
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
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      </div>
@endsection

@section('scripts')
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
@endsection

