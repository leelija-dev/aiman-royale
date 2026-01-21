// Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match. Please try again.');
                return;
            }
            
            if (password.length < 8) {
                alert('Password must be at least 8 characters long.');
                return;
            }
            
            // In a real application, you would submit the form here
            alert('Account created successfully! Welcome to StyleHub.');
            // Reset form
            this.reset();
        });