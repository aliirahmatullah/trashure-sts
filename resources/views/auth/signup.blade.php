<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trashure - SignUp</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen px-4">
    <!-- Card Form -->
    <div class="w-full max-w-2xl  bg-white rounded-2xl shadow-lg p-6 sm:p-8">
        <img src="{{ asset('asset/logo.jpg') }}" alt="" class="h-22 mx-auto" viewBox="0 0 28 24" fill="none">
        <form method="POST" action="{{ route('signup.register') }}">
            @csrf

            <!-- First & Last Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('first_name') border-red-500 @enderror"
                        placeholder="Masukkan nama depan">
                    @error('first_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('last_name') border-red-500 @enderror"
                        placeholder="Masukkan nama belakang">
                    @error('last_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('email') border-red-500 @enderror"
                    placeholder="Masukkan email">
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- No Telepon -->
            <div class="mb-5">
                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                <input type="tel" id="no_hp" name="no_hp" pattern="[0-9]{10,15}" value="{{ old('no_hp') }}"
                    required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('no_hp') border-red-500 @enderror"
                    placeholder="Masukkan no telepon">
                @error('no_hp')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-5">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea id="alamat" name="alamat" rows="4" required
                    class="w-full resize-none rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('alamat') border-red-500 @enderror"
                    placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 @error('password') border-red-500 @enderror"
                    placeholder="Masukkan password">
                @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full rounded-lg bg-green-600 py-2.5 text-sm font-semibold text-white
                       transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Sign Up
            </button>

            <!-- Back to Home -->
            {{-- Kembali --}}
            <div class="mt-6 text-xs font-semibold text-end">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-red-400 hover:text-white"> Kembali
                </a>
            </div>
        </form>
    </div>

</body>

</html>
