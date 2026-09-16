<div id="toast"
    class="fixed top-5 right-5 z-50 hidden
           min-w-[320px] max-w-[420px]
           rounded-2xl bg-white
           px-4 py-4
           shadow-xl ring-1 ring-black/5
           transition-all duration-300">
    <div class="flex items-start gap-3">

        <!-- Icon -->
        <div id="toast-icon" class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full">
        </div>

        <!-- Message -->
        <div class="flex-1">
            <p id="toast-title" class="font-semibold text-gray-900"></p>
            <p id="toast-message" class="mt-0.5 text-sm text-gray-500"></p>
        </div>

        <!-- Close button -->
        <button type="button" onclick="hideToast()" class="text-gray-400 hover:text-gray-600 transition">
            <i class="fa-solid fa-xmark"></i>
        </button>

    </div>
</div>

<script>
    window.showToast = function(message, type = 'error') {

        const toast = document.getElementById('toast');
        const icon = document.getElementById('toast-icon');
        const title = document.getElementById('toast-title');
        const messageElement = document.getElementById('toast-message');

        if (!toast || !message) {
            return;
        }

        // Clear previous classes
        icon.className =
            'flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full';

        // Set message
        messageElement.textContent = message;

        // Success
        if (type === 'success') {

            title.textContent = 'Success';

            icon.classList.add(
                'bg-green-100',
                'text-green-600'
            );

            icon.innerHTML = '<i class="fa-solid fa-check"></i>';

        }

        // Error
        else {

            title.textContent = 'Error';

            icon.classList.add(
                'bg-red-100',
                'text-red-600'
            );

            icon.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        }

        // Show toast
        toast.classList.remove('hidden');

        // Automatically hide after 5 seconds
        clearTimeout(window.toastTimeout);

        window.toastTimeout = setTimeout(() => {
            hideToast();
        }, 5000);
    };


    window.hideToast = function() {

        const toast = document.getElementById('toast');

        if (!toast) {
            return;
        }

        toast.classList.add('hidden');
    };


    // Existing Laravel session messages
    document.addEventListener('DOMContentLoaded', () => {

        const success = @json(session('success'));
        const error = @json(session('error'));

        if (success) {
            showToast(success, 'success');
        }

        if (error) {
            showToast(error, 'error');
        }

    });
</script>
