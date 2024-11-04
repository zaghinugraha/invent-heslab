<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HES Vault Login</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .awe {
      background-color: rgba(255, 255, 255, 0.7);
    }
    .background {
      background-image: url('{{ asset('images/Blend Group 1.png') }}'), 
                        url('{{ asset('images/Ellipse 118.png') }}'), 
                        url('{{ asset('images/Ellipse 119.png') }}'), 
                        url('{{ asset('images/Rectangle 231.png') }}');
      background-size: 20%, 20%, 30%, cover;
      background-position: top 70% left 10%, top right, bottom right;
      background-repeat: no-repeat, no-repeat, no-repeat;
    }
    .gradient-text {
      background: linear-gradient(to right, #4f46e5, #3b82f6);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen bg-cover bg-center background">
  <!-- Login Card -->
  <div class="awe rounded-lg shadow-lg p-8 w-full max-w-sm mx-auto">
    <!-- Logo and Title -->
    <div class="flex flex-col items-center">
      <img src="{{ asset('images/logo.png') }}" alt="HES Vault Logo" class="w-20 h-25 mb-4">
      <h1 class="text-2xl font-bold gradient-text mb-6">Sign In</h1>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- Email Input -->
      <label for="email" class="block text-sm font-bold gradient-text mb-1">Email</label>
      <div class="relative mb-4">
        <input type="email" id="email" name="email" placeholder="Input Your Email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none" />
        <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
          <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M21,8V19A2,2,0,0,1,19,21H5a2,2,0,0,1-2-2V8A2,2,0,0,1,5,6H6V5A5,5,0,0,1,16,5v1h1A2,2,0,0,1,21,8ZM8,5A3,3,0,0,1,11,8H13A3,3,0,0,1,16,5H8Zm7,6v2a1,1,0,0,1-1,1H10a1,1,0,0,1-1-1V11a1,1,0,0,1,1-1h4A1,1,0,0,1,15,11Z"/></svg>
        </span>
      </div>

      <!-- Password Input -->
      <label for="password" class="block text-sm font-bold gradient-text mb-1">Password</label>
      <div class="relative mb-4">
        <input type="password" id="password" name="password" placeholder="Input Your Password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none" />
        <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
          <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M21,8V19A2,2,0,0,1,19,21H5a2,2,0,0,1-2-2V8A2,2,0,0,1,5,6H6V5A5,5,0,0,1,16,5v1h1A2,2,0,0,1,21,8ZM8,5A3,3,0,0,1,11,8H13A3,3,0,0,1,16,5H8Zm7,6v2a1,1,0,0,1-1,1H10a1,1,0,0,1-1-1V11a1,1,0,0,1,1-1h4A1,1,0,0,1,15,11Z"/></svg>
        </span>
      </div>

      <!-- Remember Me Checkbox -->
      <div class="flex items-center mb-4">
        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="remember" class="ml-2 block text-sm text-gray-900">Remember Me</label>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">Login</button>
    </form>
  </div>

  <!-- Footer -->
  <footer class="absolute bottom-0 w-full text-center p-4 text-gray-300 text-xs">
    <p>&copy; 2024 HES VAULT. All rights reserved.</p>
  </footer>
</body>
</html>