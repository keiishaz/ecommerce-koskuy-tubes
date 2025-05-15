@extends('pembeli.layout')

@section('content')
  <h2 class="text-2xl font-semibold mb-4">Akun Anda</h2>

  <form action="{{ route('akun.update') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm rounded-lg p-6 space-y-6">
    @csrf
    @method('PUT')

    <!-- Foto Profil -->
    <div>
      <label for="image" class="block text-gray-700 font-medium">Foto Profil</label>
      <input type="file" name="image" id="image" class="mt-2 p-2 border border-gray-300 rounded-md w-full" />
      @error('image')
        <span class="text-red-500 text-sm">{{ $message }}</span>
      @enderror

      <div class="mt-4">
        <img
          src="{{ Auth::user()->image ? asset('images/uploadedfile/' . Auth::user()->image) : asset('images/default-avatar.png') }}"
          alt="User Image"
          class="w-24 h-24 rounded-full object-cover border-2 border-gray-200 shadow"
        >
      </div>
    </div>

    <!-- Nama -->
    <div>
      <label for="name" class="block text-gray-700 font-medium">Nama</label>
      <input
        type="text"
        name="name"
        id="name"
        value="{{ Auth::user()->name }}"
        class="mt-2 p-2 border border-gray-300 rounded-md w-full focus:ring focus:ring-blue-200"
        required
      />
      @error('name')
        <span class="text-red-500 text-sm">{{ $message }}</span>
      @enderror
    </div>

    <!-- Username -->
    <div>
      <label for="username" class="block text-gray-700 font-medium">Username</label>
      <input
        type="text"
        name="username"
        id="username"
        value="{{ Auth::user()->username }}"
        class="mt-2 p-2 border border-gray-300 rounded-md w-full focus:ring focus:ring-blue-200"
        required
      />
      @error('username')
        <span class="text-red-500 text-sm">{{ $message }}</span>
      @enderror
    </div>

    <!-- Password -->
    <div>
      <label for="password" class="block text-gray-700 font-medium">Password Baru</label>
      <input
        type="password"
        name="password"
        id="password"
        class="mt-2 p-2 border border-gray-300 rounded-md w-full focus:ring focus:ring-blue-200"
      />
      <small class="text-gray-500">Kosongkan jika tidak ingin mengganti password.</small>
      @error('password')
        <span class="text-red-500 text-sm block mt-1">{{ $message }}</span>
      @enderror
    </div>

    <!-- Tombol Simpan -->
    <div class="flex justify-end">
      <button
        type="submit"
        class="bg-green-600 hover:bg-green-500 text-white font-semibold py-2 px-6 rounded-md transition shadow"
      >
        Simpan Perubahan
      </button>
    </div>
  </form>
@endsection
