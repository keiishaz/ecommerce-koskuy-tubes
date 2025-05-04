document.addEventListener('DOMContentLoaded', function () {
    // Tambahkan interaktivitas jika diperlukan, misalnya toggle password visibility.
    console.log('Login page loaded');
});

document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('.toggle-password');
    const passwordField = document.getElementById('password-field');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
});
