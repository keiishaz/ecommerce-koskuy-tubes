<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
  <script src="{{ asset('js/modernizr.js') }}"></script>
  <script src="{{ asset('js/plugin.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex min-h-screen">
    @include('admin.sidebar')

    <div class="flex-1 p-6 bg-gray-50 transition-all duration-300 w-full">
      @yield('content')
    </div>
  </div>
  @yield('scripts')
</body>
</html>
