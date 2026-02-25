document.querySelector('form').addEventListener('submit', function(e) {

    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');

    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    // Reset errors
    passwordError.classList.add('hidden');
    confirmPasswordError.classList.add('hidden');

    let valid = true;

    if (password.value.length < 8) {
        e.preventDefault();
        passwordError.textContent = "Password must be at least 8 characters long.";
        passwordError.classList.remove('hidden');
        valid = false;
    }

    if (password.value !== confirmPassword.value) {
        e.preventDefault();
        confirmPasswordError.textContent = "Passwords do not match.";
        confirmPasswordError.classList.remove('hidden');
        valid = false;
    }

});