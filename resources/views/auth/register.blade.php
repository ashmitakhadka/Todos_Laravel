<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Register - Todo App</title>

    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center">
    <x-toast />

    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-2xl shadow-sm p-8">
            <!-- Heading -->

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Todo App</h1>

                <p class="text-gray-500 mt-2">Create an account</p>
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

                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />

                    <p id="passwordError" class="text-red-500 text-sm mt-1 hidden"></p>
                </div>

                <!-- Confirm Password -->

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password
                    </label>

                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Confirm your password" autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" />

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

    <script>
        const registerForm = document.getElementById("registerForm");

        const nameInput = document.getElementById("name");

        const emailInput = document.getElementById("email");

        const passwordInput = document.getElementById("password");

        const passwordConfirmationInput = document.getElementById(
            "password_confirmation",
        );

        const nameError = document.getElementById("nameError");

        const emailError = document.getElementById("emailError");

        const passwordError = document.getElementById("passwordError");

        const passwordConfirmationError = document.getElementById(
            "passwordConfirmationError",
        );

        const registerButton = document.getElementById("registerButton");

        registerForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // Clear previous errors

            nameError.textContent = "";
            nameError.classList.add("hidden");

            emailError.textContent = "";
            emailError.classList.add("hidden");

            passwordError.textContent = "";
            passwordError.classList.add("hidden");

            passwordConfirmationError.textContent = "";
            passwordConfirmationError.classList.add("hidden");

            try {
                registerButton.disabled = true;

                registerButton.textContent = "Creating account...";

                const response = await fetch("/api/register", {
                    method: "POST",

                    credentials: "same-origin",

                    headers: {
                        "Content-Type": "application/json",

                        Accept: "application/json",

                        "X-CSRF-TOKEN": document.querySelector(
                            'input[name="_token"]',
                        ).value,
                    },

                    body: JSON.stringify({
                        name: nameInput.value.trim(),

                        email: emailInput.value.trim(),

                        password: passwordInput.value,

                        password_confirmation: passwordConfirmationInput.value,
                    }),
                });

                const data = await response.json();

                // Validation errors

                if (response.status === 422) {
                    if (data.errors) {
                        if (data.errors.name) {
                            nameError.textContent = data.errors.name[0];

                            nameError.classList.remove("hidden");
                        }

                        if (data.errors.email) {
                            emailError.textContent = data.errors.email[0];

                            emailError.classList.remove("hidden");
                        }

                        if (data.errors.password) {
                            passwordError.textContent = data.errors.password[0];

                            passwordError.classList.remove("hidden");
                        }

                        if (data.errors.password_confirmation) {
                            passwordConfirmationError.textContent =
                                data.errors.password_confirmation[0];

                            passwordConfirmationError.classList.remove(
                                "hidden",
                            );
                        }
                    }

                    return;
                }

                // Other errors

                if (!response.ok) {
                    showToast(data.message || "Registration failed.", "error");

                    return;
                }

                // Success

                showToast(
                    data.message || "Registration successful!",
                    "success",
                );

                setTimeout(() => {
                    window.location.href = "/todos";
                }, 500);
            } catch (error) {
                console.error(error);

                showToast("Unable to connect to the server.", "error");
            } finally {
                registerButton.disabled = false;

                registerButton.textContent = "Register";
            }
        });
    </script>
</body>

</html>
