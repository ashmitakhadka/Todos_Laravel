import "@fortawesome/fontawesome-free/js/all.js";
import "./login";
import Swal from 'sweetalert2';

document.querySelectorAll('.delete-form').forEach((form) => {
    form.addEventListener('submit', (event) => {
        event.preventDefault();

        Swal.fire({
            title: 'Delete Todo?',
            text: 'Are you sure you want to delete this task?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Toast Messages
    |--------------------------------------------------------------------------
    */

    const toastData = document.getElementById('toast-data');

    if (toastData) {

        const successMessage = toastData.dataset.success;
        const errorMessage = toastData.dataset.error;

        if (successMessage) {

            showToast(
                successMessage,
                'success'
            );

        }

        if (errorMessage) {

            showToast(
                errorMessage,
                'error'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    const logoutBtn = document.getElementById('logoutBtn');

    if (logoutBtn) {

        logoutBtn.addEventListener('click', async function () {

            logoutBtn.disabled = true;

            try {

                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');

                const response = await fetch('/api/logout', {

                    method: 'POST',

                    credentials: 'same-origin',

                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }

                });

                const data = await response.json();

                if (response.ok) {

                    showToast(
                        data.message || 'Logout successful.',
                        'success'
                    );

                    setTimeout(function () {
                        window.location.href = '/login';
                    }, 700);

                } else {

                    showToast(
                        data.message || 'Logout failed.',
                        'error'
                    );

                    logoutBtn.disabled = false;

                }

            } catch (error) {

                showToast(
                    'Something went wrong. Please try again.',
                    'error'
                );

                logoutBtn.disabled = false;

            }

        });

    }

});