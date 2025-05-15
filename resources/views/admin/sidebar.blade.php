<aside class="w-64 bg-gradient-to-b from-purple-600 to-purple-400 text-white p-6 hidden md:block">
  <!-- Logo atau Judul Admin -->
  <div class="mb-8 text-center">
    <h1 class="text-2xl font-bold tracking-wide">Admin Panel</h1>
    <p class="text-sm opacity-80">Koskuy</p>
  </div>

  <!-- Menu -->
<nav class="space-y-4 text-sm">
  <a href="/admin" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
    <span class="iconify" data-icon="mdi:home" style="font-size: 1.5rem;"></span> Dashboard
  </a>
  <a href="/admin/barang" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
    <span class="iconify" data-icon="mdi:package" style="font-size: 1.5rem;"></span> Daftar Barang
  </a>
  <a href="/admin/kategori" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
    <span class="iconify" data-icon="mdi:folder" style="font-size: 1.5rem;"></span> Daftar Kategori
  </a>
  <a href="/admin/pesanan" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
    <span class="iconify" data-icon="mdi:cart" style="font-size: 1.5rem;"></span> Daftar Pesanan
  </a>
  <a href="/admin/pengguna" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
    <span class="iconify" data-icon="mdi:account-circle" style="font-size: 1.5rem;"></span> Daftar Pengguna
  </a>
  <!-- Menu Logout -->
  <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500 mt-6">
          <span class="iconify" data-icon="mdi:logout" style="font-size: 1.5rem;"></span> Keluar
      </button>
  </form>
</nav>

</aside>