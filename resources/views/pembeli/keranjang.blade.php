@extends('pembeli.layout')

@section('content')
  <h2 class="text-2xl font-semibold mb-4">Keranjang Anda</h2>

  @if($carts->count() > 0)
    <!-- Cart Items List -->
    <div class="bg-white shadow-sm rounded-lg p-6">
      <div class="overflow-x-auto">
        
        <!-- Form Checkout -->
        <form action="{{ route('checkout') }}" method="GET">
          <table class="min-w-full table-auto">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
              <tr>
                <th class="py-3 px-4 text-left">Produk</th>
                <th class="py-3 px-4 text-left">Harga</th>
                <th class="py-3 px-4 text-left">Jumlah</th>
                <th class="py-3 px-4 text-left">Subtotal</th>
                <th class="py-3 px-4 text-left">Pilih</th>
                <th class="py-3 px-4 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody class="text-gray-700">
              @foreach ($carts as $cart)
              <tr class="border-b hover:bg-gray-50 transition">
                <td class="py-3 px-4">
                  <div class="flex items-center">
                    <img src="{{ asset('images/uploadedfile/' . $cart->product->image) }}" alt="Product Image" class="w-12 h-12 object-cover rounded-lg mr-4 shadow-sm">
                    <span>{{ $cart->product->nama }}</span>
                  </div>
                </td>
                <td class="py-3 px-4">Rp {{ number_format($cart->product->harga, 0, ',', '.') }}</td>
                <td class="py-3 px-4">
                  <input type="number" min="1" value="{{ $cart->jumlah }}" name="quantity[{{ $cart->product->id }}]"
                    class="w-16 text-center px-2 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-400" />
                </td>
                <td class="py-3 px-4">Rp {{ number_format($cart->product->harga * $cart->jumlah, 0, ',', '.') }}</td>
                <td class="py-3 px-4">
                  <input type="checkbox" name="product_id[]" value="{{ $cart->product->id }}" class="text-purple-600 focus:ring-purple-400" />
                </td>
                <td class="py-3 px-4">
                  <!-- Tombol Hapus untuk Produk -->
                  <button type="button" onclick="deleteCart({{ $cart->id }})" class="text-red-600 hover:text-red-800 font-semibold">
                    Hapus
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

          <!-- Checkout Button -->
          <div class="flex justify-end mt-6">
            <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white font-semibold py-2 px-6 rounded-md shadow-md transition">
              Proses ke Pembayaran
            </button>
          </div>
        </form>
        
      </div>
    </div>
  @else
    <!-- Kosong -->
    <div class="bg-white shadow-sm rounded-lg p-6 text-center text-gray-500">
      <span class="text-lg">Tidak ada produk di keranjang.</span>
    </div>
  @endif

  <!-- Form untuk delete produk -->
  <form id="delete-form" action="{{ route('keranjang.hapus', 'temp') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <!-- Hapus akan dilakukan disini setelah tombol ditekan -->
  </form>

@endsection

@push('scripts')
<script>
  function deleteCart(cartId) {
    // Update URL pada form delete
    const form = document.getElementById('delete-form');
    form.action = '/keranjang/' + cartId + '/hapus'; // Update dengan URL yang sesuai

    // Submit form
    if (confirm('Yakin ingin menghapus produk ini dari keranjang?')) {
      form.submit();
    }
  }
</script>
@endpush
