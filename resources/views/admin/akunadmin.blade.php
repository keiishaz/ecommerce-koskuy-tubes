<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profil Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>

</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('admin.sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <h1 class="text-2xl font-semibold text-gray-700 mb-4">Edit Profil</h1>
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          
          <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-700">Nama</label>
            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="w-full p-3 border rounded-lg focus:outline-none" required>
          </div>

          <div class="mb-4">
            <label for="username" class="block text-sm font-semibold text-gray-700">Username</label>
            <input type="text" name="username" id="username" value="{{ Auth::user()->username }}" class="w-full p-3 border rounded-lg focus:outline-none" required>
          </div>

          <div class="mb-4">
            <label for="image" class="block text-sm font-semibold text-gray-700">Gambar Profil</label>
            <input type="file" name="image" id="image" class="w-full p-3 border rounded-lg focus:outline-none">
          </div>

          <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-md hover:bg-blue-600">Update Profil</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
