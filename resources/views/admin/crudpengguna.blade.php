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
    @include('admin.sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <!-- Header -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Daftar Pengguna</h1>
      
      <!-- Tombol tambah pengguna -->
      <a href="{{ route('tambahpengguna') }}" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
        Tambah Pengguna
      </a>

      </div>

      <!-- Pencarian dan Filter Berdasarkan Role -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 mt-4">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-lg font-semibold text-gray-700">Cari Pengguna</h2>
          <div class="flex gap-4 w-2/3">

            <!-- Dropdown untuk memilih Role -->
            <div class="w-40">
              <form id="filter-form" method="GET" action="">
                <select name="role" id="filter-role" class="px-4 py-2 border rounded-lg text-gray-700 w-full" onchange="document.getElementById('filter-form').submit()">
                  <option value="">Semua Role</option>
                  @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                      {{ ucfirst($role) }}
                    </option>
                  @endforeach
                </select>
              </form>
            </div>

            <!-- Input pencarian nama/email -->
            <input type="text" id="search-input" placeholder="Cari nama atau email..." class="px-4 py-2 border rounded-lg text-gray-700 w-full" />
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
              @forelse ($users as $index => $user)
              <tr class="border-b border-gray-200 hover:bg-gray-100 pengguna-row">
                <td class="py-3 px-6">{{ $index + 1 }}</td>
                <td class="py-3 px-6 pengguna-nama">{{ $user->name }}</td>
                <td class="py-3 px-6 pengguna-email">{{ $user->email }}</td>
                <td class="py-3 px-6 text-purple-600 font-semibold">{{ ucfirst($user->role) }}</td>
                <td class="py-3 px-6 text-center">
                  <form action="" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus pengguna ini?')" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">Hapus</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4">Tidak ada pengguna ditemukan.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
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
