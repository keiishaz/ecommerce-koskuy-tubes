<aside class="w-64 bg-gradient-to-b from-purple-600 to-purple-400 text-white p-6 hidden md:block">
  <!-- Profil Akun di Sidebar -->
  <div class="flex items-center mb-6">
    <img src="{{ asset('images/profile.jpg') }}" alt="Admin" class="w-12 h-12 rounded-full border-2 border-white">
    <div class="ml-3">
      <p class="font-semibold text-lg">Admin</p>
      <p class="text-sm">admin@example.com</p>
    </div>
  </div>

  <!-- Menu -->
  <nav class="space-y-4 text-sm">
    <a href="/admin/barang" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
      <span class="iconify" data-icon="mdi:package"></span> Daftar Barang
    </a>
    <a href="/admin/kategori" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
      <span class="iconify" data-icon="mdi:folder"></span> Daftar Kategori
    </a>
    <a href="/admin/pesanan" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
      <span class="iconify" data-icon="mdi:cart"></span> Daftar Pesanan
    </a>
    <a href="/admin/pengguna" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500">
      <span class="iconify" data-icon="mdi:account-circle"></span> Daftar Pengguna
    </a>
    <!-- Menu Logout -->
    <a href="/logout" class="flex items-center gap-3 text-white hover:text-gray-200 px-4 py-2 rounded-md transition-all hover:bg-purple-500 mt-6">
      <span class="iconify" data-icon="mdi:logout"></span> Logout
    </a>
  </nav>
</aside>