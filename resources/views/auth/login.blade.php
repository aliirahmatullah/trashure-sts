<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Trashure - Login</title>
  @vite('resources/css/app.css')
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">

  {{-- Alert --}}
  @if (Session::get('success'))
    <div class="fixed top-4 left-1/2 -translate-x-1/2 w-full max-w-sm bg-green-100 text-green-700 px-4 py-3 rounded-lg shadow">{{ Session::get('success') }}</div>
  @endif

  @if (Session::get('error'))
    <div class="fixed top-4 left-1/2 -translate-x-1/2 w-full max-w-sm bg-red-100 text-red-700 px-4 py-3 rounded-lg shadow">{{ Session::get('error') }}</div>
  @endif

  {{-- Card Login --}}
  <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6 sm:p-8">
    <img src="{{asset('asset/logo.jpg')}}" alt="" class="h-22 mx-auto" viewBox="0 0 28 24" fill="none">
    <form method="POST" action="{{ route('login.auth') }}">
      @csrf

      {{-- Email --}}
      <div class="mb-5">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <i class="fa-solid fa-envelope"></i>
          </span>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
                 class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-500 @enderror"
                 placeholder="Masukkan Email">
        </div>
        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Password --}}
      <div class="mb-5">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <i class="fa-solid fa-lock"></i>
          </span>
          <input type="password" id="password" name="password" required
                 class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-500 @enderror"
                 placeholder="••••••••">
        </div>
        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      {{-- Submit --}}
      <button type="submit"
              class="w-full rounded-lg bg-green-600 py-2.5 text-sm font-semibold text-white
                     transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
        Login
      </button>

      {{-- Register --}}
      <div class="mt-4 text-center">
          <i class="fa-solid fa-user-plus mr-1 text-sm text-gray-600 hover:text-gray-800"></i><p class="inline text-sm text-gray-600 hover:text-gray-800">Belum Punya Akun?</p>
          <a href="{{ route('signup') }}" class="text-sm font-semibold text-black hover:text-gray-800">
            Register
          </a>
      </div>

      {{-- Kembali --}}
      <div class="mt-4 text-xs font-semibold text-end">
        <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-red-400 hover:text-white"> Kembali </a>
      </div>
    </form>
  </div>

</body>
</html>