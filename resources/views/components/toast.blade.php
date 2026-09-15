<div id="toast" class="fixed top-5 right-5 z-50 hidden rounded-lg px-5 py-3 text-white shadow-lg">
</div>

<script>
    function showToast(message, type = 'error') {
        const toast = document.getElementById('toast');

        if (!toast || !message) {
            return;
        }

        toast.textContent = message;

        toast.classList.remove(
            'hidden',
            'bg-red-500',
            'bg-green-500'
        );

        if (type === 'success') {
            toast.classList.add('bg-green-500');
        } else {
            toast.classList.add('bg-red-500');
        }

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }

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
