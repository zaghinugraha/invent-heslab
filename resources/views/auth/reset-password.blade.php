<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HES Vault Reset Password</title>
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
      const passwordConfirmationInput = document.getElementById('password_confirmation');
      const eyeIcons = document.querySelectorAll('.eye-icon');

      const showIcon = @json(asset('svg/eye-password-show-svgrepo-com.svg'));
      const hideIcon = @json(asset('svg/eye-password-hide-svgrepo-com.svg'));

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordConfirmationInput.type = 'text';
        eyeIcons.forEach(icon => icon.src = hideIcon);
      } else {
        passwordInput.type = 'password';
        passwordConfirmationInput.type = 'password';
        eyeIcons.forEach(icon => icon.src = showIcon);
      }
    }
  </script>
</head>
<body class="flex items-center justify-center min-h-screen bg-cover bg-center background">
  <!-- Reset Password Card -->
  <div class="awe rounded-lg shadow-lg p-8 w-full max-w-sm mx-auto">
    <!-- Logo and Title -->
    <div class="flex flex-col items-center">
      <img src="{{ asset('images/logo.png') }}" alt="HES Vault Logo" class="w-15 h-20 mb-4">
      <h1 class="text-2xl font-bold gradient-text mb-6">Reset Password</h1>
    </div>

    <!-- Validation Errors -->
    <x-validation-errors class="mb-4" />

    <!-- Reset Password Form -->
    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <!-- Email Input -->
      <label for="email" class="block text-sm font-bold gradient-text mb-1">Email</label>
      <div class="relative mb-4">
        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
        <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
          <img id="email-icon" src="{{ asset('svg/email-message-inbox-svgrepo-com.svg') }}" class="w-5 h-5 text-gray-400" alt="Email">
        </span>
      </div>

      <!-- Password Input -->
      <label for="password" class="block text-sm font-bold gradient-text mb-1">Password</label>
      <div class="relative mb-4">
        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        <span class="absolute inset-y-0 right-4 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
            <img id="eye-icon" src="{{ asset('svg/eye-password-show-svgrepo-com.svg') }}" class="w-5 h-5 text-gray-400" alt="Toggle Password Visibility">
        </span>
      </div>

      <!-- Confirm Password Input -->
      <label for="password_confirmation" class="block text-sm font-bold gradient-text mb-1">Confirm Password</label>
      <div class="relative mb-4">
        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        <span class="absolute inset-y-0 right-4 flex items-center cursor-pointer" onclick="togglePasswordVisibility()">
            <img id="eye-icon" src="{{ asset('svg/eye-password-show-svgrepo-com.svg') }}" class="w-5 h-5 text-gray-400" alt="Toggle Password Visibility">
        </span>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="w-full px-4 py-2 gradient-bg text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">Reset Password</button>
    </form>
  </div>

  <!-- Footer -->
  <footer class="absolute bottom-0 w-full text-center p-4 bg-white">
    <div class="flex items-center justify-center">
      <img src="{{ asset('images/logo_text.png') }}" alt="HES Vault Logo" class="h-6 mr-2">
      <p class="text-xs text-black font-semibold">&copy; 2024 HES VAULT. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>