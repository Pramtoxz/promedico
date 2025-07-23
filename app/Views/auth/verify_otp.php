<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            950: '#042f2e',
                        }
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .bg-gradient-teal {
                background-image: linear-gradient(to right, #0d9488, #14b8a6, #5eead4);
            }
        }
        
        .otp-input {
            width: 3rem;
            height: 3.5rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header with Teal Gradient -->
            <div class="bg-gradient-teal p-6 text-white text-center">
                <h1 class="text-2xl font-bold">Verifikasi OTP</h1>
                <p class="mt-2 text-teal-100">Masukkan kode yang dikirimkan ke email Anda</p>
            </div>

            <!-- OTP Verification Form -->
            <div class="p-6">
                <div class="mb-6 text-center">
                    <p class="text-gray-700">
                        Kami telah mengirimkan kode verifikasi ke email <strong><?= $email ?></strong>. 
                        <br>Silakan masukkan kode tersebut di bawah ini.
                    </p>
                </div>

                <form id="formOTP" action="<?= site_url($action) ?>" method="POST" class="space-y-6">
                    <!-- Hidden Fields -->
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <input type="hidden" name="type" value="<?= $type ?>">
                    <?php if (isset($formData) && !empty($formData)): ?>
                        <?php foreach($formData as $key => $value): ?>
                            <input type="hidden" name="form_data[<?= $key ?>]" value="<?= $value ?>">
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <!-- Alert Messages -->
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p><?= session()->getFlashdata('error'); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <div id="alert-message" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 hidden" role="alert">
                        <!-- Error message will be displayed here -->
                    </div>
                    
                    <?php if(session()->getFlashdata('message')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p><?= session()->getFlashdata('message'); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- OTP Input Fields -->
                    <div class="flex justify-center space-x-2 sm:space-x-4 mb-6">
                        <input type="text" class="otp-input border border-gray-300 focus:border-teal-500 focus:ring-teal-500" maxlength="1" name="otp[]" data-index="0" autofocus>
                        <input type="text" class="otp-input border border-gray-300 focus:border-teal-500 focus:ring-teal-500" maxlength="1" name="otp[]" data-index="1">
                        <input type="text" class="otp-input border border-gray-300 focus:border-teal-500 focus:ring-teal-500" maxlength="1" name="otp[]" data-index="2">
                        <input type="text" class="otp-input border border-gray-300 focus:border-teal-500 focus:ring-teal-500" maxlength="1" name="otp[]" data-index="3">
                        <input type="text" class="otp-input border border-gray-300 focus:border-teal-500 focus:ring-teal-500" maxlength="1" name="otp[]" data-index="4">
                        <input type="text" class="otp-input border border-gray-300 focus:border-teal-500 focus:ring-teal-500" maxlength="1" name="otp[]" data-index="5">
                    </div>

                    <!-- Timer -->
                    <div class="text-center text-gray-600">
                        <p>Kode berlaku selama: <span id="countdown" class="font-semibold">10:00</span></p>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-teal hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                        >
                            Verifikasi
                        </button>
                    </div>
                </form>

                <!-- Resend Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Tidak menerima kode? 
                        <a href="#" id="resendOTP" class="font-medium text-teal-600 hover:text-teal-500">
                            Kirim ulang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Handle OTP input
        $('.otp-input').on('keyup', function(e) {
            const index = parseInt($(this).data('index'));
            
            // If a digit is entered, focus the next input
            if ($(this).val().length === 1) {
                if (index < 5) {
                    $('.otp-input[data-index="' + (index + 1) + '"]').focus();
                }
            }
            
            // On backspace, focus the previous input
            if (e.keyCode === 8 && index > 0 && $(this).val().length === 0) {
                $('.otp-input[data-index="' + (index - 1) + '"]').focus();
            }
        });
        
        // Allow only numbers
        $('.otp-input').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        
        // Countdown timer
        let duration = 10 * 60; // 10 minutes in seconds
        let timer = duration;
        
        function updateCountdown() {
            const minutes = Math.floor(timer / 60);
            let seconds = timer % 60;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            $('#countdown').text(minutes + ":" + seconds);
            
            if (timer === 0) {
                clearInterval(countdownInterval);
                $('#resendOTP').removeClass('disabled');
                $('.otp-input').prop('disabled', true);
                $('#alert-message').removeClass('hidden').text('Kode OTP telah kedaluarsa. Silakan kirim ulang kode.');
            } else {
                timer--;
            }
        }
        
        let countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
        
        // Handle resend OTP
        $('#resendOTP').on('click', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?= site_url('auth/resend-otp') ?>',
                type: 'POST',
                data: {
                    email: '<?= $email ?>',
                    type: '<?= $type ?>'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Reset timer
                        timer = duration;
                        updateCountdown();
                        
                        // Clear inputs & enable them
                        $('.otp-input').val('').prop('disabled', false);
                        $('.otp-input[data-index="0"]').focus();
                        
                        // Hide error message if any
                        $('#alert-message').addClass('hidden');
                        
                        // Show success message
                        const alertHtml = `
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                                <p>${response.message}</p>
                            </div>
                        `;
                        $('#formOTP').prepend(alertHtml);
                    } else {
                        $('#alert-message').removeClass('hidden').text(response.message);
                    }
                },
                error: function() {
                    $('#alert-message').removeClass('hidden').text('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
    </script>
</body>
</html> 