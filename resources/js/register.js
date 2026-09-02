const registerForm = document.getElementById("registerForm");

if (registerForm) {
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

    // -----------------------------
    // Show error
    // -----------------------------

    function showError(input, errorElement, message) {
        errorElement.textContent = message;
        errorElement.classList.remove("hidden");

        input.classList.remove("border-gray-300", "border-green-500");
        input.classList.add("border-red-500");
    }

    // -----------------------------
    // Clear error
    // -----------------------------

    function clearError(input, errorElement) {
        errorElement.textContent = "";
        errorElement.classList.add("hidden");

        input.classList.remove("border-red-500");
        input.classList.add("border-gray-300");
    }

    // -----------------------------
    // Name validation
    // -----------------------------

    function validateName() {
        const name = nameInput.value.trim();

        if (name === "") {
            showError(nameInput, nameError, "Name is required.");

            return false;
        }

        if (name.length > 255) {
            showError(
                nameInput,
                nameError,
                "Name must not exceed 255 characters.",
            );

            return false;
        }

        clearError(nameInput, nameError);

        return true;
    }

    // -----------------------------
    // Email validation
    // -----------------------------

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

    // -----------------------------
    // Password validation
    // -----------------------------

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

    // -----------------------------
    // Confirm password validation
    // -----------------------------

    function validatePasswordConfirmation() {
        const password = passwordInput.value;
        const confirmation = passwordConfirmationInput.value;

        if (confirmation === "") {
            showError(
                passwordConfirmationInput,
                passwordConfirmationError,
                "Please confirm your password.",
            );

            return false;
        }

        if (password !== confirmation) {
            showError(
                passwordConfirmationInput,
                passwordConfirmationError,
                "Passwords do not match.",
            );

            return false;
        }

        clearError(passwordConfirmationInput, passwordConfirmationError);

        return true;
    }

    // -----------------------------
    // Dynamic validation
    // -----------------------------

    nameInput.addEventListener("input", validateName);

    emailInput.addEventListener("input", validateEmail);

    passwordInput.addEventListener("input", () => {
        validatePassword();

        // Re-check confirmation when password changes
        if (passwordConfirmationInput.value !== "") {
            validatePasswordConfirmation();
        }
    });

    passwordConfirmationInput.addEventListener(
        "input",
        validatePasswordConfirmation,
    );

    // -----------------------------
    // Submit
    // -----------------------------

    registerForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        // Validate everything before API request

        const nameValid = validateName();
        const emailValid = validateEmail();
        const passwordValid = validatePassword();
        const confirmationValid = validatePasswordConfirmation();

        if (!nameValid || !emailValid || !passwordValid || !confirmationValid) {
            return;
        }

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

            // -----------------------------
            // Laravel validation errors
            // -----------------------------

            if (response.status === 422) {
                if (data.errors) {
                    if (data.errors.name) {
                        showError(nameInput, nameError, data.errors.name[0]);
                    }

                    if (data.errors.email) {
                        showError(emailInput, emailError, data.errors.email[0]);
                    }

                    if (data.errors.password) {
                        showError(
                            passwordInput,
                            passwordError,
                            data.errors.password[0],
                        );
                    }

                    if (data.errors.password_confirmation) {
                        showError(
                            passwordConfirmationInput,
                            passwordConfirmationError,
                            data.errors.password_confirmation[0],
                        );
                    }
                }

                return;
            }

            // -----------------------------
            // Other errors
            // -----------------------------

            if (!response.ok) {
                showToast(data.message || "Registration failed.", "error");

                return;
            }

            // -----------------------------
            // Success
            // -----------------------------

            showToast(data.message || "Registration successful!", "success");

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
}
