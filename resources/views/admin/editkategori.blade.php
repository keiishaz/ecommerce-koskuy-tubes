<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Kategori</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
</head>

<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('admin.sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      <!-- Header Edit Kategori -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-700">Edit Kategori</h1>
      </div>

      <!-- Form Edit Kategori -->
      <div class="bg-white p-5 rounded-lg shadow-md mb-6">
        <form action="{{ route('updateKategori', $category->id) }}" method="POST">
            @csrf
            @method('PUT')  <!-- Menggunakan metode PUT untuk update -->

            <div class="mb-4">
                <label for="nama" class="block text-gray-700">Nama Kategori</label>
                <input type="text" name="nama" id="nama" class="w-full px-4 py-2 border rounded-lg" value="{{ old('nama', $category->nama) }}" required>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">Update Kategori</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
