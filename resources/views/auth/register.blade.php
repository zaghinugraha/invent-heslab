<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HES Vault Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .awe {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .background {
            background-image: url('{{ asset('images/Blend Group 1.png') }}'),
                url('{{ asset('images/Ellipse 118.png') }}'),
                url('{{ asset('images/Ellipse 118.png') }}'),
                url('{{ asset('images/Rectangle 231.png') }}');
            background-size: 20%, 20%, 30%, cover;
            background-position: {{ rand(0, 100) }}% {{ rand(0, 100) }}%, {{ rand(0, 100) }}% {{ rand(0, 100) }}%, {{ rand(0, 100) }}% {{ rand(0, 100) }}%;
            background-repeat: no-repeat, no-repeat, no-repeat;
        }

        .gradient-text {
            background: linear-gradient(to right, #4f46e5, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-bg {
            background: linear-gradient(to right, #4f46e5, #3b82f6);
        }
    </style>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeIconPath = eyeIcon.getAttribute('src');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('src', '{{ asset('svg/eye-password-hide-svgrepo-com.svg') }}');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('src', '{{ asset('svg/eye-password-show-svgrepo-com.svg') }}');
            }
        }
    </script>
</head>

<body class="flex items-center justify-center min-h-screen bg-cover bg-center background">
    <!-- Register Card -->
    <div class="awe rounded-lg shadow-lg p-8 w-full max-w-sm mb-20">
        <!-- Logo and Title -->
        <div class="flex flex-col items-center">
            <img src="{{ asset('images/logo.png') }}" alt="HES Vault Logo" class="w-15 h-20 mb-4">
            <h1 class="text-2xl font-bold gradient-text mb-6">Daftar</h1>
        </div>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4" />

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Input -->
            <label for="name" class="block text-sm font-bold gradient-text mb-1">Nama</label>
            <div class="relative mb-4">
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                    <img id="name-icon" src="{{ asset('svg/user-account-profile-svgrepo-com.svg') }}"
                        class="w-5 h-5 text-gray-400" alt="Name">
                </span>
            </div>

            <!-- Email Input -->
            <label for="email" class="block text-sm font-bold gradient-text mb-1">Email</label>
            <div class="relative mb-4">
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                    <img id="email-icon" src="{{ asset('svg/email-message-inbox-svgrepo-com.svg') }}"
                        class="w-5 h-5 text-gray-400" alt="Email">
                </span>
            </div>

            <!-- Password Input -->
            <label for="password" class="block text-sm font-bold gradient-text mb-1">Kata Sandi</label>
            <div class="relative mb-4">
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <span class="absolute inset-y-0 right-4 flex items-center cursor-pointer"
                    onclick="togglePasswordVisibility()">
                    <img id="eye-icon" src="{{ asset('svg/eye-password-show-svgrepo-com.svg') }}"
                        class="w-5 h-5 text-gray-400" alt="Toggle Password Visibility">
                </span>
            </div>

            <!-- Confirm Password Input -->
            <label for="password_confirmation" class="block text-sm font-bold gradient-text mb-1">Konfirmasi Kata
                Sandi</label>
            <div class="relative mb-4">
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <span class="absolute inset-y-0 right-4 flex items-center cursor-pointer"
                    onclick="togglePasswordVisibility()">
                    <img id="eye-icon" src="{{ asset('svg/eye-password-show-svgrepo-com.svg') }}"
                        class="w-5 h-5 text-gray-400" alt="Toggle Password Visibility">
                </span>
            </div>

            <!-- Terms and Privacy Policy -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <!-- Submit Button -->
            <button type="submit"
                class="w-full px-4 py-2 gradient-bg text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">Daftar</button>

            <!-- Already have an account? Login Link -->
            @if (Route::has('login'))
                <div class="mt-4 text-center">
                    <span class="text-sm text-blue-800">Sudah punya akun? </span><a href="{{ route('login') }}"
                        class="text-sm text-blue-600 hover:underline">Masuk</a>
                </div>
            @endif
        </form>
    </div>

    <!-- Footer -->
    <footer class="fixed bottom-0 w-full text-center p-4 bg-white">
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/logo_text.png') }}" alt="HES Vault Logo" class="h-6 mr-2">
            <p class="text-xs text-black font-semibold">&copy; 2024 HES VAULT. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
