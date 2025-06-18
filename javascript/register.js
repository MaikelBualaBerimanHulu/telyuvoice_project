
        // Initialize form with animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to form elements
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.animation = `fadeInUp 0.5s ease forwards ${index * 0.1 + 0.3}s`;
            });

            // Enable prodi select when fakultas is selected
            document.getElementById('fakultas').addEventListener('change', function() {
                const prodiSelect = document.getElementById('prodi');
                if (this.value) {
                    prodiSelect.disabled = false;
                    prodiSelect.classList.add('animate__animated', 'animate__fadeIn');
                } else {
                    prodiSelect.disabled = true;
                }
            });

            // Username validation
            document.getElementById('username').addEventListener('input', function() {
                const feedback = document.getElementById('usernameFeedback');
                if (this.value.length < 4) {
                    feedback.textContent = 'Username terlalu pendek (min 4 karakter)';
                    feedback.style.color = 'var(--error)';
                    feedback.style.display = 'block';
                } else if (this.value.length > 20) {
                    feedback.textContent = 'Username terlalu panjang (max 20 karakter)';
                    feedback.style.color = 'var(--error)';
                    feedback.style.display = 'block';
                } else {
                    feedback.textContent = 'Username tersedia';
                    feedback.style.color = 'var(--success)';
                    setTimeout(() => {
                        feedback.style.display = 'none';
                    }, 1500);
                }
            });
        });

        function updateProdiOptions() {
            const fakultas = document.getElementById('fakultas').value;
            const prodi = document.getElementById('prodi');
            
            // Clear existing options
            prodi.innerHTML = '';
            
            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Pilih Program Studi';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            prodi.appendChild(defaultOption);

            let options = [];

            if (fakultas === 'FIT') {
                options = [
                    'D3 Rekayasa Perangkat Lunak Aplikasi',
                    'D3 Sistem Informasi Akuntansi',
                    'D3 Teknologi Telekomunikasi',
                    'D3 Sistem Informasi',
                    'D3 Teknologi Komputer',
                    'D3 Digital Marketing',
                    'D3 Hospitalty & Culinary',
                    'D4 Teknologi Rekayara Multi Media',
                    'D4 Sistem Informasi Kota Cerdas'
                ];
            } else if (fakultas === 'FTE') {
                options = [
                    'S1 Teknik Elektro',
                    'S1 Teknik Telekomunikasi',
                    'S1 Teknik Fisika',
                    'S1 Teknik Biomedis',
                    'S1 Teknik Sistem Energi'
                ];
            } else if (fakultas === 'FIF') {
                options = [
                    'S1 Teknik Informatika',
                    'S1 Teknologi Informasi',
                    'S1 Sains data',
                    'S1 Rekayasa Perangkat Lunak'
                ];
            } else if (fakultas === 'FRI') {
                options = [
                    'S1 Teknik Industri',
                    'S1 Sistem Informasi',
                    'S1 Teknik Logistik'
                ];
            } else if (fakultas === 'FEB') {
                options = [
                    'S1 Ekonomi',
                    'S1 Manajemen',
                    'S1 Akuntansi'
                ];
            } else if (fakultas === 'FKS') {
                options = [
                    'S1 Ilmu Komunikasi',
                    'S1 Psikologi'
                ];
            } else if (fakultas === 'FIK') {
                options = [
                    'S1 Desain Komunikasi Visual',
                    'S1 Desain Produk',
                    'S1 Desain Interior',
                    'S1 Desain Grafis',
                    'S1 Seni Rupa'
                ];
            }

            // Add new options with animation
            options.forEach((option, index) => {
                setTimeout(() => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.textContent = option;
                    opt.classList.add('animate__animated', 'animate__fadeIn');
                    prodi.appendChild(opt);
                }, index * 50);
            });

            // Animate the select dropdown
            prodi.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                prodi.classList.remove('animate__animated', 'animate__pulse');
            }, 500);
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthIndicator = document.getElementById('strengthIndicator');
            const hint = document.getElementById('passwordHint');
            
            // Reset
            strengthIndicator.style.width = '0%';
            hint.style.display = 'none';
            
            if (password.length === 0) return;
            
            hint.style.display = 'block';
            
            // Calculate strength
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 15;
            
            // Character variety
            if (/[A-Z]/.test(password)) strength += 15; // Uppercase
            if (/[a-z]/.test(password)) strength += 15; // Lowercase
            if (/[0-9]/.test(password)) strength += 15; // Numbers
            if (/[^A-Za-z0-9]/.test(password)) strength += 15; // Special chars
            
            // Cap at 100
            strength = Math.min(strength, 100);
            
            // Update UI
            strengthIndicator.style.width = strength + '%';
            
            // Color coding
            if (strength < 40) {
                strengthIndicator.style.backgroundColor = 'var(--error)';
                hint.textContent = 'Password lemah - tambahkan lebih banyak variasi karakter';
                hint.style.color = 'var(--error)';
            } else if (strength < 70) {
                strengthIndicator.style.backgroundColor = 'orange';
                hint.textContent = 'Password cukup - bisa lebih kuat';
                hint.style.color = 'orange';
            } else {
                strengthIndicator.style.backgroundColor = 'var(--success)';
                hint.textContent = 'Password kuat!';
                hint.style.color = 'var(--success)';
            }
        }

        // Form submission handler
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate form submission
            const form = this;
            const successMessage = document.getElementById('successMessage');
            const registerForm = document.getElementById('registerForm');
            
            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            submitButton.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                // Hide form, show success message
                registerForm.style.display = 'none';
                successMessage.style.display = 'block';
                
                // Reset button
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
                
                // You would typically submit the form here
                // form.submit();
            }, 2000);
        });
    </script>
