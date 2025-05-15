@extends('pembeli.layout')

@section('content')
  <h2 class="text-2xl font-semibold mb-4">Pesanan Anda</h2>

  @if($groupedOrders->count() > 0)
    <!-- Daftar Pesanan -->
    <div class="bg-white shadow-sm rounded-lg p-6 space-y-6">
      @foreach ($groupedOrders as $date => $orders)
        <div class="bg-gray-50 rounded-lg shadow-md p-6">
          <!-- Tanggal dan waktu pesanan -->
          <h3 class="text-xl font-semibold text-purple-700 mb-4">Pesanan Waktu: {{ $date }}</h3>

          <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
              <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                  <th class="py-3 px-4 text-left">Produk</th>
                  <th class="py-3 px-4 text-left">Jumlah</th>
                  <th class="py-3 px-4 text-left">Harga</th>
                  <th class="py-3 px-4 text-left">Total</th>
                  <th class="py-3 px-4 text-left">Status</th>
                </tr>
              </thead>
              <tbody class="text-gray-700">
                @foreach ($orders as $order)
                  @foreach ($order->items as $item)
                    <tr class="border-b hover:bg-gray-50">
                      <td class="py-3 px-4">
                        <div class="flex items-center">
                          @if ($item->product)
                            <img src="{{ asset('images/uploadedfile/' . $item->product->image) }}" alt="Product Image" class="w-12 h-12 object-cover rounded-lg mr-4 shadow-sm">
                            <span>{{ $item->product->nama }}</span>
                          @else
                            <span class="text-red-500 italic">Produk Tidak Ditemukan</span>
                          @endif
                        </div>
                      </td>
                      <td class="py-3 px-4">{{ $item->jumlah }}</td>
                      <td class="py-3 px-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                      <td class="py-3 px-4">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</td>
                      <td class="py-3 px-4">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-medium px-2 py-1 rounded">
                          {{ $order->status }}
                        </span>
                      </td>
                    </tr>
                  @endforeach
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Total Pesanan -->
          <div class="flex justify-end mt-4 text-lg font-semibold text-gray-800">
            <p>
              Total: Rp {{ number_format($orders->sum(function($order) {
                return $order->items->sum(function($item) {
                  return $item->harga * $item->jumlah;
                });
              }), 0, ',', '.') }}
            </p>
          </div>

          <!-- Tombol Batalkan -->
          <div class="flex justify-end mt-4">
            <form action="{{ route('pesanan.cancelGroup', $date) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan seluruh pesanan ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-600 hover:bg-red-500 text-white font-medium py-2 px-6 rounded-md shadow transition">
                Batalkan Pesanan
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <!-- Kosong -->
    <div class="bg-white shadow-sm rounded-lg p-6 text-center text-gray-500">
      <span class="text-lg">Belum ada pesanan yang dilakukan.</span>
    </div>
  @endif
@endsection
