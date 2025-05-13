<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
</head>

<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('admin.sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <!-- Header -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Edit Pengguna</h1>
      </div>

      <!-- Form Edit Pengguna -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <form action="{{ route('editPengguna', $user->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-4">
            <label for="name" class="block text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full px-4 py-2 border rounded-lg" required>
          </div>

          <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" class="w-full px-4 py-2 border rounded-lg" required>
          </div>

          <div class="mb-4">
            <label for="password" class="block text-gray-700">Password (Biarkan kosong jika tidak ingin mengubah)</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg">
          </div>

          <div class="mb-4">
            <label for="role" class="block text-gray-700">Role</label>
            <select name="role" id="role" class="w-full px-4 py-2 border rounded-lg" required>
              <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
              <option value="pengguna" {{ $user->role == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
            </select>
          </div>

          <div class="flex justify-end mt-4">
            <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700">Update Pengguna</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
