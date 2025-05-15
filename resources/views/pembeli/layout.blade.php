<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Koskuy</title>

  <!-- Tailwind CSS -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">

  <!-- Iconify -->
  <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9fafc;
      color: #2f2f4f;
    }

    h2, h3 {
      font-family: 'Montserrat', sans-serif;
      color: #5c5d9a;
    }

    header {
      background: linear-gradient(135deg, #dfe3ff, #b7bbff);
      box-shadow: 0 2px 10px rgba(92, 93, 154, 0.15);
    }

    .icon-bg {
      background-color: #e1e3f8;
      color: #5c5d9a;
      border-radius: 9999px;
      padding: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .icon-bg:hover {
      background-color: #7a78d2;
      color: #eef0ff;
      transform: scale(1.2);
      box-shadow: 0 4px 15px rgba(122, 120, 210, 0.4);
      cursor: pointer;
    }

    .profile-img {
      border-radius: 9999px;
      object-fit: cover;
      width: 36px;
      height: 36px;
      border: 2px solid #7a78d2;
      transition: box-shadow 0.3s ease;
    }

    .profile-img:hover {
      box-shadow: 0 0 10px #7a78d2;
    }

    .header-icons a,
    .header-icons form button {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 600;
      color: #4b4b7d;
      transition: color 0.25s ease;
      font-family: 'Poppins', sans-serif;
      font-size: 0.9rem;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0.25rem 0.5rem;
      border-radius: 8px;
    }

    .header-icons a:hover,
    .header-icons form button:hover {
      color: #7a78d2;
      background: #e1e3f8;
      box-shadow: 0 3px 10px rgba(122, 120, 210, 0.15);
    }
  </style>

  @stack('styles')
</head>

<body>
  <!-- Header -->
  <header>
    <div class="max-w-7xl mx-auto px-6 py-6 flex flex-wrap items-center justify-between">
      <a href="/user" class="text-3xl font-bold tracking-wider" style="color:#6e4a75;">Koskuy</a>

      <!-- Ikon Navigasi -->
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
            Logout
          </button>
        </form>
      </div>
    </div>
  </header>

  <!-- Konten Utama -->
  <main class="max-w-7xl mx-auto px-6 py-8">
    @yield('content')
  </main>

  @stack('scripts')
</body>
</html>
