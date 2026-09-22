<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Register - Todo App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <x-toast />

    <div class="w-full max-w-md px-4">

        <div class="bg-white rounded-2xl shadow-sm p-8">

            <!-- Heading -->

            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-gray-800">
                    Todo App
                </h1>

                <p class="text-gray-500 mt-2">
                    Create an account
                </p>

            </div>


            <!-- Register Form -->

            <form id="registerForm">

                @csrf


                <!-- Name -->

                <div class="mb-5">

                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Name
                    </label>

                    <input type="text" id="name" name="name" placeholder="Enter your name"
                        autocomplete="name"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />

                    <p id="nameError" class="text-red-500 text-sm mt-1 hidden"></p>

                </div>


                <!-- Email -->

                <div class="mb-5">

                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        autocomplete="email"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />

                    <p id="emailError" class="text-red-500 text-sm mt-1 hidden"></p>

                </div>


                <!-- Password -->

                <div class="mb-5">

                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <div class="relative">

                        <input type="password" id="password" name="password" autocomplete="new-password"
                            placeholder="Enter your password"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />

                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            aria-label="Show password">
                            <i id="passwordIcon" class="fa-solid fa-eye-slash"></i>
                        </button>

                    </div>

                    <p id="passwordError" class="text-red-500 text-sm mt-1 hidden"></p>

                </div>


                <!-- Confirm Password -->

                <div class="mb-6">

                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password
                    </label>

                    <div class="relative">

                        <input type="password" id="password_confirmation" name="password_confirmation"
                            autocomplete="new-password" placeholder="Confirm your password"
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />

                        <button type="button" id="togglePasswordConfirmation"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            aria-label="Show password confirmation">
                            <i id="passwordConfirmationIcon" class="fa-solid fa-eye-slash"></i>
                        </button>

                    </div>

                    <p id="passwordConfirmationError" class="text-red-500 text-sm mt-1 hidden"></p>

                </div>


                <!-- Register Button -->

                <button type="submit" id="registerButton"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl transition">
                    Register
                </button>


                <!-- Login Link -->

                <p class="text-center text-sm text-gray-500 mt-5">

                    Already have an account?

                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-medium">
                        Login
                    </a>

                </p>

            </form>

        </div>

    </div>

</body>

</html>
