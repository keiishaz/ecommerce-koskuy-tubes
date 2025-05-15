<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Koskuy - Homepage</title>

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <!-- Google Fonts: Poppins & Montserrat (minimalis dan elegan) -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">

  <!-- Iconify CDN -->
  <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
  <!-- Header -->
  <header>
    <div class="max-w-7xl mx-auto px-6 py-6 flex flex-wrap items-center justify-between">
      <div class="text-3xl font-bold tracking-wider" style="color:#6e4a75;">Koskuy</div>

  <!-- Search + Categories -->
  <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 max-w-xl mx-auto">
    <input type="text" id="search-barang" placeholder="Cari produk..." 
      class="flex-grow px-4 py-3 border border-purple-300 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-300 transition" />
    <select id="filter-kategori"
      class="w-48 px-4 py-3 border border-purple-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
      <option value="all">Semua Kategori</option>
      @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>
          {{ $category->nama }}
        </option>
      @endforeach
    </select>
  </div>

      <!-- Icons (Cart, Account & Orders) -->
      <div class="header-icons flex items-center space-x-6">
        <a href="{{ route('keranjang') }}" title="Keranjang">
          <span class="icon-bg">
            <span class="iconify" data-icon="mdi:cart" data-inline="false"></span>
          </span>
          Keranjang
        </a>
        <a href="{{ route('pesanan') }}" title="Pesanan">
          <span class="icon-bg">
            <span class="iconify" data-icon="mdi:clipboard-list" data-inline="false"></span>
          </span>
          Pesanan
        </a>
        <a href="{{ route('akun') }}" title="Akun" class="flex items-center gap-2">
          @if(Auth::user()->image)
          <img src="{{ asset('images/uploadedfile/' . Auth::user()->image) }}" alt="User Image" class="profile-img" />
          @else
          <img src="{{ asset('images/default-avatar.png') }}" alt="User Image" class="profile-img" />
          @endif
          <span>{{ Auth::user()->name }}</span>
        </a>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" title="Logout">
            <span class="icon-bg">
              <span class="iconify" data-icon="mdi:logout" data-inline="false"></span>
            </span>
            Keluar
          </button>
        </form>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-6 py-8">
    <h2>Produk Terkini</h2>

    <!-- Product Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-6">
      @foreach ($products as $product)
      <div class="card-barang" data-category="{{ $product->category->id }}">
        <div class="relative overflow-hidden rounded-lg">
          <img src="{{ asset('images/uploadedfile/' . $product->image) }}" alt="Product Image" />
        </div> <br>
        <p class="category-label">Kategori: {{ $product->category->nama }}</p>
        <h3 class="product-name item-name">{{ $product->nama }}</h3>
        <p class="product-desc">{{ $product->deskripsi }}</p>

        <div class="flex justify-between items-center mt-4">
          <p class="price">Rp. {{ number_format($product->harga) }}</p>
          <p class="stock">Stok: {{ $product->stok }}</p>
        </div>

        <a href="{{ route('produk.detail', $product->id) }}" class="btn-purple mt-5 block">
          Lihat Detail
        </a>
      </div>
      @endforeach
    </div>
  </main>

<script>
  function filterProduk() {
    let keyword = $('#search-barang').val().toLowerCase();
    let selectedCategory = $('#filter-kategori').val();

    $('.card-barang').each(function () {
      let itemName = $(this).find('.item-name').text().toLowerCase();
      let itemCategory = $(this).data('category').toString();

      let cocokPencarian = itemName.includes(keyword);
      let cocokKategori = selectedCategory === 'all' || itemCategory === selectedCategory;

      $(this).toggle(cocokPencarian && cocokKategori);
    });
  }

  // Trigger filter saat pencarian diketik
  $('#search-barang').on('keyup', filterProduk);

  // Trigger filter saat kategori diubah
  $('#filter-kategori').on('change', filterProduk);
</script>

</body>

</html>
