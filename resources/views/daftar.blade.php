<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link href="{{ asset('css/daftar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Form Section: Kiri -->
        <div class="left-section">
            <div class="right-inner">
                <h2>Daftar</h2>
                <p>Masukkan data diri kamu untuk mendaftar dan mulai belanja barang preloved hemat di sini!</p>
                @if($errors->any())
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li style="color: red">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="login-form">
                    @csrf

                    <div class="input-group">
                        <input type="text" name="nama" id="nama" required autocomplete="off" placeholder="Nama Lengkap">
                        <span class="icon left"><i class="fa fa-id-card"></i></span>
                    </div>

                    <div class="input-group">
                        <input type="text" name="username" id="username" required autocomplete="off" placeholder="Username">
                        <span class="icon left"><i class="fa fa-user"></i></span>
                    </div>

                    <div class="input-group">
                        <input type="email" name="email" id="email" required autocomplete="off" placeholder="Email">
                        <span class="icon left"><i class="fa fa-envelope"></i></span>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" id="password-field" required autocomplete="off" placeholder="Kata Sandi">
                        <span class="icon left"><i class="fa fa-lock"></i></span>
                        <span class="icon right toggle-password"><i class="fa fa-eye"></i></span>
                    </div>

                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password-confirmation" required autocomplete="off" placeholder="Konfirmasi Kata Sandi">
                        <span class="icon left"><i class="fa fa-lock"></i></span>
                        <span class="icon right toggle-password"><i class="fa fa-eye"></i></span>
                    </div>

                    <button type="submit">Daftar</button>
                </form>

                <div class="register-prompt">
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang!</a></p>
                </div>
            </div>
        </div>

        <!-- Gambar Section: Kanan -->
        <div class="right-section">
            <img src="{{ asset('images/shopp-3.png') }}" alt="Illustration">
        </div>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
