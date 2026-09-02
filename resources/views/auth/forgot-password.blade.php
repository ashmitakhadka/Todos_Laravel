<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Forgot Password - Todo App</title>

    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <x-toast />

    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <!-- Heading -->
            <div class="text-center mb-7">
                <h1 class="text-3xl font-bold text-gray-800">
                    Forgot Password?
                </h1>

                <p class="text-gray-500 mt-2">Enter your email to reset your password.</p>
            </div>

            <!-- Forgot Password Form -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <label
                        for="email"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        placeholder="Enter your email"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                    />

                    @error ('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Send Button -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200"
                >
                    Send Reset Link
                </button>
            </form>

            <!-- Back to Login -->
            <p class="text-center text-sm text-gray-500 mt-6">
                Remember your password?

                <a
                    href="{{ route('login') }}"
                    class="text-blue-600 hover:text-blue-700 font-medium"
                >
                    Login
                </a>
            </p>
        </div>
    </div>
</body>
</html>
