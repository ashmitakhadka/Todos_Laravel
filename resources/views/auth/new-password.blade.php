<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Reset Password - Todo App</title>

    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <div class="text-center mb-7">
                <h1 class="text-3xl font-bold text-gray-800">Reset Password</h1>

                <p class="text-gray-500 mt-2">Enter your new password below.</p>
            </div>

            <form method="POST" action="{{ route('reset.password.post') }}">
                @csrf

                {{-- Reset token --}}
                <input type="hidden" name="token" value="{{ $token }}" />

                {{-- Email --}}
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
                        value="{{ old('email', $email) }}"
                        readonly
                        class="w-full px-4 py-2.5 border border-gray-300 bg-gray-50 rounded-lg"
                    />

                    @error ('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div class="mb-5">
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        New Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        placeholder="Enter your new password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                    />

                    @error ('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-6">
                    <label
                        for="password_confirmation"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        placeholder="Confirm your password"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                    />

                    @error ('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200"
                >
                    Reset Password
                </button>
            </form>

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
