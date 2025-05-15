@extends('pembeli.layout')

@section('title', 'Checkout')

@section('content')
  <h2 class="text-2xl font-semibold mb-4">Detail Pemesanan</h2>

  <!-- Cart Items List -->
  <div class="bg-white shadow-sm rounded-lg p-6">
    <div class="overflow-x-auto">
      <table class="min-w-full table-auto">
        <thead>
          <tr>
            <th class="py-2 px-4 text-left">Produk</th>
            <th class="py-2 px-4 text-left">Harga</th>
            <th class="py-2 px-4 text-left">Jumlah</th>
            <th class="py-2 px-4 text-left">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($carts as $cart)
          <tr>
            <td class="py-2 px-4">
              <div class="flex items-center">
                <img src="{{ asset('images/uploadedfile/' . $cart->product->image) }}" alt="Product Image" class="w-12 h-12 object-cover rounded-lg mr-4">
                <span>{{ $cart->product->nama }}</span>
              </div>
            </td>
            <td class="py-2 px-4">Rp. {{ number_format($cart->product->harga) }}</td>
            <td class="py-2 px-4">{{ $cart->jumlah }}</td>
            <td class="py-2 px-4">Rp. {{ number_format($cart->product->harga * $cart->jumlah) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Checkout Form -->
    <div class="mt-6">
      <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
          <!-- Alamat Pengiriman -->
          <div>
            <label for="alamat" class="block text-gray-700">Alamat Pengiriman</label>
            <textarea id="alamat" name="alamat" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400" required></textarea>
          </div>

          <!-- Jenis Pembayaran -->
          <div>
            <label for="jenis_pembayaran" class="block text-gray-700">Pilih Jenis Pembayaran</label>
            <select id="jenis_pembayaran" name="jenis_pembayaran" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400" required>
              <option value="transfer">Transfer Bank</option>
              <option value="cash">Bayar di Tempat</option>
            </select>
          </div>
        </div>

        <!-- Produk dan Jumlah -->
        @foreach ($carts as $cart)
          <input type="hidden" name="product_id[]" value="{{ $cart->product_id }}">
          <input type="hidden" name="quantity[{{ $cart->product_id }}]" value="{{ $cart->jumlah }}">
        @endforeach

        <!-- Total -->
        <div class="flex justify-end mt-4">
          <div class="text-lg font-semibold">
            <p>Total: Rp. {{ number_format($total) }}</p>
          </div>
        </div>

        <!-- Tombol Checkout -->
        <div class="flex justify-end mt-6">
          <button type="submit" class="bg-green-600 text-white py-2 px-6 rounded-md hover:bg-green-500">Pesan</button>
        </div>
      </form>
    </div>
  </div>
@endsection
