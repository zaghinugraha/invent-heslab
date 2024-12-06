<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HES Vault Login</title>
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
<body class="flex flex-col min-h-screen bg-cover bg-center background">
  <!-- Main Content -->
  <div class="flex-grow flex items-center justify-center">
    <!-- Login Card -->
    <div class="awe rounded-lg shadow-lg p-8 w-full max-w-sm mx-auto mb-14">
      <!-- Logo and Title -->
      <div class="flex flex-col items-center">
        <img src="{{ asset('images/logo.png') }}" alt="HES Vault Logo" class="w-15 h-20 mb-4">
        <h1 class="text-2xl font-semibold text-blue-800 mb-6">Sign In</h1>
      </div>

    <!-- Validation Errors -->
    <x-validation-errors class="mb-4" />

      <!-- Login Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Input -->
        <label for="email" class="block text-sm font-bold gradient-text mb-1">Email</label>
        <div class="relative mb-4">
          <input type="email" id="email" name="email" placeholder="Input Your Email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none" />
          <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
          <img id="email=icon" src="{{ asset('svg/email-message-inbox-svgrepo-com.svg') }}" class="w-5 h-5 text-gray-400" alt="Email">
          </span>
        </div>

        <!-- Password Input -->
        <label for="password" class="block text-sm font-bold gradient-text mb-1">Password</label>
        <div class="relative mb-4">
          <input type="password" id="password" name="password" placeholder="Input Your Password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none" />
          <span class="absolute inset-y-0 right-4 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
            <img id="eye-icon" src="{{ asset('svg/eye-password-show-svgrepo-com.svg') }}" class="w-5 h-5 text-gray-400" alt="Toggle Password Visibility">
          </span>
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center mb-4">
          <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
          <label for="remember" class="ml-2 block text-sm text-gray-900">Remember Me</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full px-4 py-2 gradient-bg text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">Login</button>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
          <div class="mt-4 text-center">
            <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot Your Password?</a>
          </div>
        @endif

        <!-- Sign Up Link -->
        @if (Route::has('register'))
          <div class="mt-4 text-center">
            <span class="text-sm text-blue-800">Don't have an account?</span> <a href="{{ route('register') }}" class="text-sm font-semibold text-blue-600 hover:underline gradient-text">Sign Up</a>
          </div>
        @endif
      </form>
    </div>
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