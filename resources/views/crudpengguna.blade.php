<!-- resources/views/admin/pengguna.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin - Pengguna</title>
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
    @include('sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <!-- Header -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Daftar Pengguna</h1>
      </div>

      <!-- Pencarian dengan ikon -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <div class="relative">
          <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
              viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
          </span>
          <input type="text" id="search-input" placeholder="Cari nama atau email..."
            class="w-full pl-10 pr-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
        </div>
      </div>

      <!-- Tabel Pengguna -->
      <div class="bg-white p-5 rounded-lg shadow-md">
        <table class="min-w-full table-auto text-left" id="pengguna-table">
          <thead>
            <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
              <th class="py-3 px-6">No</th>
              <th class="py-3 px-6">Nama</th>
              <th class="py-3 px-6">Email</th>
              <th class="py-3 px-6">Role</th>
              <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 text-sm font-light">
            <!-- Contoh Baris Pengguna -->
            <tr class="border-b border-gray-200 hover:bg-gray-100 pengguna-row">
              <td class="py-3 px-6">1</td>
              <td class="py-3 px-6 pengguna-nama">Admin Utama</td>
              <td class="py-3 px-6 pengguna-email">admin@example.com</td>
              <td class="py-3 px-6 text-purple-600 font-semibold">Admin</td>
              <td class="py-3 px-6 text-center">
                <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 mr-2">Edit</button>
                <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Hapus</button>
              </td>
            </tr>
            <tr class="border-b border-gray-200 hover:bg-gray-100 pengguna-row">
              <td class="py-3 px-6">2</td>
              <td class="py-3 px-6 pengguna-nama">Budi Santoso</td>
              <td class="py-3 px-6 pengguna-email">budi123@example.com</td>
              <td class="py-3 px-6 text-green-600 font-semibold">Pembeli</td>
              <td class="py-3 px-6 text-center">
                <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 mr-2">Edit</button>
                <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Hapus</button>
              </td>
            </tr>
            <!-- Tambahkan baris lainnya di sini -->
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    // Fitur pencarian nama/email di tabel
    $('#search-input').on('keyup', function () {
      let keyword = $(this).val().toLowerCase();
      $('.pengguna-row').each(function () {
        let nama = $(this).find('.pengguna-nama').text().toLowerCase();
        let email = $(this).find('.pengguna-email').text().toLowerCase();
        $(this).toggle(nama.includes(keyword) || email.includes(keyword));
      });
    });
  </script>
</body>

</html>
