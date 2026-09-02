const loginForm = document.getElementById("loginForm");

if (loginForm) {
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");

    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    const loginButton = document.getElementById("loginButton");
    const togglePassword = document.getElementById("togglePassword");

    // =========================
    // Show / Hide Password
    // =========================

    togglePassword.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            togglePassword.textContent = "Hide";
        } else {
            passwordInput.type = "password";
            togglePassword.textContent = "Show";
        }
    });

    // =========================
    // Error Functions
    // =========================

    function showError(input, errorElement, message) {
        errorElement.textContent = message;

        input.classList.add("border-red-500");
        input.classList.remove("border-gray-300");
    }

    function clearError(input, errorElement) {
        errorElement.textContent = "";

        input.classList.remove("border-red-500");
        input.classList.add("border-gray-300");
    }

    // =========================
    // Email Validation
    // =========================

    function validateEmail() {
        const email = emailInput.value.trim();

        if (email === "") {
            showError(emailInput, emailError, "Email is required.");

            return false;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email)) {
            showError(
                emailInput,
                emailError,
                "Please enter a valid email address.",
            );

            return false;
        }

        clearError(emailInput, emailError);

        return true;
    }

    // =========================
    // Password Validation
    // =========================

    function validatePassword() {
        const password = passwordInput.value;

        if (password === "") {
            showError(passwordInput, passwordError, "Password is required.");

            return false;
        }

        if (password.length < 6) {
            showError(
                passwordInput,
                passwordError,
                "Password must be at least 6 characters.",
            );

            return false;
        }

        clearError(passwordInput, passwordError);

        return true;
    }

    // =========================
    // Dynamic Email Validation
    // =========================

    emailInput.addEventListener("input", function () {
        if (emailInput.value.trim() !== "") {
            validateEmail();
        } else {
            clearError(emailInput, emailError);
        }
    });

    // =========================
    // Dynamic Password Validation
    // =========================

    passwordInput.addEventListener("input", function () {
        if (passwordInput.value !== "") {
            validatePassword();
        } else {
            clearError(passwordInput, passwordError);
        }
    });

    // =========================
    // Submit
    // =========================

    loginForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        // Clear previous errors
        clearError(emailInput, emailError);
        clearError(passwordInput, passwordError);

        // Validate inputs
        const emailValid = validateEmail();
        const passwordValid = validatePassword();

        if (!emailValid || !passwordValid) {
            return;
        }

        try {
            loginButton.disabled = true;
            loginButton.textContent = "Logging in...";

            const response = await fetch("/api/login", {
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
                    email: emailInput.value.trim(),
                    password: passwordInput.value,
                }),
            });

            const data = await response.json();

            // =========================
            // Laravel Validation Errors
            // =========================

            if (response.status === 422) {
                if (data.errors?.email) {
                    showError(emailInput, emailError, data.errors.email[0]);
                }

                if (data.errors?.password) {
                    showError(
                        passwordInput,
                        passwordError,
                        data.errors.password[0],
                    );
                }

                return;
            }

            // =========================
            // Invalid Credentials
            // =========================

            if (response.status === 401) {
                showToast(
                    data.message || "Invalid email or password.",
                    "error",
                );

                return;
            }

            // =========================
            // Other Errors
            // =========================

            if (!response.ok) {
                showToast(data.message || "Login failed.", "error");

                return;
            }

            // =========================
            // Login Successful
            // =========================

            showToast(data.message || "Login successful!", "success");

            setTimeout(() => {
                window.location.href = "/todos";
            }, 500);
        } catch (error) {
            console.error(error);

            showToast("Unable to connect to the server.", "error");
        } finally {
            loginButton.disabled = false;
            loginButton.textContent = "Login";
        }
    });
}
