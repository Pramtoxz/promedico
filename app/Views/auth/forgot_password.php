<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
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
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header with Teal Gradient -->
            <div class="bg-gradient-teal p-6 text-white text-center">
                <h1 class="text-2xl font-bold">Lupa Password</h1>
                <p class="mt-2 text-teal-100">Masukkan email Anda untuk reset password</p>
            </div>

            <!-- Forgot Password Form -->
            <div class="p-6">
                <form id="formForgotPassword" class="space-y-6" action="<?= site_url('auth/forgot-password') ?>" method="POST">
                    <!-- Alert Messages -->
                    <?php if(session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <p><?= session()->getFlashdata('error'); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if(session()->getFlashdata('message')): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p><?= session()->getFlashdata('message'); ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                            placeholder="Masukkan email Anda"
                            required
                            autofocus
                        />
                        <?php if(isset($validation) && $validation->hasError('email')): ?>
                            <p class="mt-1 text-sm text-red-600"><?= $validation->getError('email') ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button
                            type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-teal hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                        >
                            Kirim Link Reset
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        <a href="<?= site_url('auth') ?>" class="font-medium text-teal-600 hover:text-teal-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html> 