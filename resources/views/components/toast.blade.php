<div
    id="toast-container"
    class="fixed top-5 right-5 z-50 flex flex-col gap-3 w-[calc(100%-2rem)] max-w-sm"
></div>

<script>
    function showToast(message, type = "error") {
        const container = document.getElementById("toast-container");

        if (!container) return;

        const settings = {
            success: {
                icon: "✓",
                title: "Success",
                color: "border-green-500",
                iconBg: "bg-green-500",
            },

            error: {
                icon: "✕",
                title: "Error",
                color: "border-red-500",
                iconBg: "bg-red-500",
            },

            warning: {
                icon: "!",
                title: "Warning",
                color: "border-yellow-500",
                iconBg: "bg-yellow-500",
            },

            info: {
                icon: "i",
                title: "Info",
                color: "border-blue-500",
                iconBg: "bg-blue-500",
            },
        };

        const config = settings[type] || settings.error;

        const toast = document.createElement("div");

        toast.className = `
            relative overflow-hidden
            flex items-start gap-3
            w-full
            bg-white
            border-l-4 ${config.color}
            rounded-xl
            shadow-xl
            px-4 py-4
            translate-x-[120%]
            transition-all duration-300 ease-out
        `;

        toast.innerHTML = `

            <div class="
                flex items-center justify-center
                w-9 h-9
                rounded-full
                ${config.iconBg}
                text-white
                font-bold
                flex-shrink-0
            ">
                ${config.icon}
            </div>


            <div class="flex-1 min-w-0">

                <p class="text-sm font-semibold text-gray-900">
                    ${config.title}
                </p>

                <p class="text-sm text-gray-600 mt-1 break-words">
                    ${message}
                </p>

            </div>


            <button
                type="button"
                class="
                    text-gray-400
                    hover:text-gray-700
                    text-xl
                    leading-none
                    transition
                "
            >
                ×
            </button>


            <div
                class="
                    progress-bar
                    absolute
                    bottom-0
                    left-0
                    h-1
                    ${config.iconBg}
                "
            ></div>

        `;

        container.appendChild(toast);

        // Slide in
        requestAnimationFrame(() => {
            toast.classList.remove("translate-x-[120%]");
        });

        // Close button
        const closeButton = toast.querySelector("button");

        closeButton.addEventListener("click", () => {
            removeToast();
        });

        // Progress bar
        const progressBar = toast.querySelector(".progress-bar");

        progressBar.style.width = "100%";
        progressBar.style.transition = "width 3s linear";

        requestAnimationFrame(() => {
            progressBar.style.width = "0%";
        });

        // Automatically remove
        const timeout = setTimeout(() => {
            removeToast();
        }, 3000);

        function removeToast() {
            clearTimeout(timeout);

            toast.classList.add("translate-x-[120%]");

            setTimeout(() => {
                toast.remove();
            }, 300);
        }
    }
</script>
