@extends('pembeli.layout')

@section('content')
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Product Image -->
    <div class="bg-white shadow rounded-lg p-4 flex items-center justify-center">
      <img
        src="{{ asset('images/uploadedfile/' . $product->image) }}"
        alt="Gambar Produk"
        class="w-full max-w-md h-auto rounded-lg object-cover"
      >
    </div>

    <!-- Product Info -->
    <div class="bg-white shadow rounded-lg p-6 space-y-4">
      <h2 class="text-3xl font-semibold text-gray-800">{{ $product->nama }}</h2>

      <p class="text-2xl text-purple-600 font-bold">Rp. {{ number_format($product->harga) }}</p>

      <p class="text-gray-700">{{ $product->deskripsi }}</p>

      <p class="text-gray-600">Stok Tersedia: <strong>{{ $product->stok }}</strong> unit</p>
      <p class="text-gray-600">Kategori: <strong>{{ $product->category->nama }}</strong></p>

      <!-- Input & Tombol -->
      <form action="{{ route('produk.addToCart', $product->id) }}" method="POST" class="space-y-4">
        @csrf

        <div class="flex items-center space-x-4">
          <label for="quantity" class="text-gray-700 font-medium">Jumlah:</label>
          <input
            type="number"
            id="quantity"
            name="quantity"
            min="1"
            max="{{ $product->stok }}"
            value="1"
            class="w-20 text-center p-2 border border-gray-300 rounded-md"
          >
        </div>

        <input type="hidden" name="quantity" id="input-quantity" value="1">

        <button type="submit"
          class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-500 transition w-full sm:w-auto flex items-center justify-center space-x-2">
          <span class="iconify" data-icon="mdi:cart-plus" data-inline="false"></span>
          <span>Tambah ke Keranjang</span>
        </button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  // Sinkronisasi jumlah produk dengan input tersembunyi
  document.getElementById("quantity").addEventListener("input", function () {
    document.getElementById("input-quantity").value = this.value;
  });
</script>
@endpush
