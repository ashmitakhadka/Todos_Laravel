<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Login - Todo App</title>

    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <x-toast />

    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <!-- Heading -->
            <div class="text-center mb-7">
                <h1 class="text-3xl font-bold text-gray-800">Todo App</h1>

                <p class="text-gray-500 mt-2">Login to your account</p>
            </div>

            <!-- Login Form -->
            <form id="loginForm">
                @csrf

                <!-- Email -->
                <div class="mb-3">
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
                        autocomplete="email"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter your email"
                    />

                    <!-- Reserved error space -->
                    <p
                        id="emailError"
                        class="text-red-500 text-xs mt-1 min-h-[18px]"
                    ></p>
                </div>

                <!-- Password -->
                <div class="mb-2">
                    <label
                        for="password"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Password
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            class="w-full px-4 py-2.5 pr-16 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter your password"
                        />

                        <button
                            type="button"
                            id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 hover:text-gray-700"
                        >
                            Show
                        </button>
                    </div>

                    <!-- Reserved error space -->
                    <p
                        id="passwordError"
                        class="text-red-500 text-xs mt-1 min-h-[18px]"
                    ></p>
                </div>

                <!-- Forgot Password -->
                <div class="text-right mb-5">
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-blue-600 hover:text-blue-700"
                    >
                        Forgot Password?
                    </a>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    id="loginButton"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition duration-200"
                >
                    Login
                </button>
            </form>

            <!-- Register -->
            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account?

                <a
                    href="{{ route('register') }}"
                    class="text-blue-600 hover:text-blue-700 font-medium"
                >
                    Register
                </a>
            </p>
        </div>
    </div>
</body>
</html>
