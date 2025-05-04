<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="{{ asset('images/shopp-2.png') }}" alt="Illustration">
        </div>
        <div class="right-section">
            <div class="right-inner">
            <h2>Masuk</h2>
            <p>Yuk masuk ke akun kamu dan temukan barang-barang preloved anak kos yang hemat dan bermanfaat!</p>
            <form action="" method="POST" class="login-form">
                @csrf
            
                <div class="input-group">
                    <input type="text" name="username" id="username" required autocomplete="off" placeholder="Email">
                    <span class="icon left"><i class="fa fa-user"></i></span>
                </div>
                
                <div class="input-group">
                    <input type="password" name="password" id="password-field" required autocomplete="off" placeholder="Kata Sandi">
                    <span class="icon left"><i class="fa fa-lock"></i></span>
                    <span class="icon right toggle-password"><i class="fa fa-eye"></i></span>
                </div>
                                                      
                <button type="submit">Masuk</button>
            </form>
            
            <div class="register-prompt">
                <p>Tidak punya akun? <a href="{{ route('daftar') }}">Daftar sekarang!</a></p>
            </div>
            
        </div>
    </div>
    <script src="{{ asset('js/login.js') }}"></script>

</body>
</html>
