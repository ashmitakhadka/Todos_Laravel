<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Todo App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Toast Component -->
    <x-toast />

    <!-- Toast Data -->
    <div
        id="toast-data"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
    ></div>


    <!-- Page Header -->
    <header class="bg-white py-6 shadow-sm mb-8">

        <div class="max-w-2xl mx-auto px-4 flex items-center justify-between">

            <h1 class="text-3xl font-bold text-slate-900">
                Todo App
            </h1>

            <!-- Logout Button -->
            <button
                id="logoutBtn"
                type="button"
                class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600
                       text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition"
            >
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>

        </div>

    </header>


    <!-- Main Centered Container -->
    <main class="max-w-2xl mx-auto px-4 pb-12">


        <!-- Top Card -->
        <div class="flex items-center justify-between bg-gray-100 p-6 rounded-2xl mb-6 shadow-sm">

            <div>

                <h2 class="text-xl font-bold text-gray-800">
                    My Tasks
                </h2>

                <p class="text-sm font-medium text-gray-500 mt-0.5">
                    {{ count($todos) }}
                    {{ count($todos) == 1 ? 'task' : 'tasks' }}
                </p>

            </div>


            <!-- Add Task -->
            <a
                href="{{ route('todos.create') }}"
                class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600
                       text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition"
            >
                <i class="fa-solid fa-plus"></i>
                <span>Add Task</span>
            </a>

        </div>


        <!-- Task List -->
        <div class="space-y-3">

            @forelse($todos as $todo)

                <!-- Todo Card -->
                <div
                    class="flex items-center justify-between bg-white p-4 rounded-2xl
                           border border-gray-100 shadow-sm hover:shadow-md transition"
                >

                    <!-- Checkbox + Todo Information -->
                    <div class="flex items-center gap-4">

                        <!-- Complete Button -->
                        <form
                            action="{{ route('todos.complete', $todo) }}"
                            method="POST"
                        >

                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="w-6 h-6 rounded-md border flex items-center justify-center transition
                                {{ $todo->completed
                                    ? 'bg-emerald-500 border-emerald-500 text-white'
                                    : 'border-gray-300 hover:border-emerald-500'
                                }}"
                            >

                                @if($todo->completed)
                                    <i class="fa-solid fa-check text-xs"></i>
                                @endif

                            </button>

                        </form>


                        <!-- Todo Information -->
                        <div>

                            <!-- Title -->
                            <div
                                class="font-medium text-gray-800
                                {{ $todo->completed
                                    ? 'line-through text-gray-400'
                                    : ''
                                }}"
                            >
                                {{ $todo->title }}
                            </div>


                            <!-- Status -->
                            <span
                                class="inline-block text-xs font-medium px-2 py-0.5 rounded-full mt-1
                                {{ $todo->completed
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : 'bg-amber-100 text-amber-700'
                                }}"
                            >
                                {{ $todo->completed ? 'Completed' : 'Pending' }}
                            </span>


                            <!-- Completion Date -->
                            @if($todo->completed && $todo->completed_at)

                                <p class="text-xs text-gray-400 mt-1">
                                    Completed on
                                    {{ $todo->completed_at->format('M d, Y h:i A') }}
                                </p>

                            @endif

                        </div>

                    </div>


                    <!-- Actions -->
                    <div class="flex items-center gap-2">

                        <!-- Edit -->
                        @if(!$todo->completed)

                            <a
                                href="{{ route('todos.edit', $todo) }}"
                                class="p-2 text-gray-400 hover:text-blue-600
                                       hover:bg-blue-50 rounded-lg transition"
                                title="Edit task"
                            >
                                <i class="fa-solid fa-pen"></i>
                            </a>

                        @else

                            <!-- Disabled Edit -->
                            <button
                                type="button"
                                disabled
                                class="p-2 text-gray-300 cursor-not-allowed rounded-lg"
                                title="Completed tasks cannot be edited"
                            >
                                <i class="fa-solid fa-pen"></i>
                            </button>

                        @endif


                        <!-- Delete -->
                        <form
                            action="{{ route('todos.destroy', $todo) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this task?');"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="p-2 text-gray-400 hover:text-red-600
                                       hover:bg-red-50 rounded-lg transition"
                                title="Delete task"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </form>

                    </div>

                </div>


            @empty

                <!-- No Tasks -->
                <div
                    class="text-center py-12 px-4 bg-gray-50 rounded-2xl
                           border-2 border-dashed border-gray-200"
                >

                    <i class="fa-regular fa-clipboard text-4xl text-gray-400 mb-3"></i>

                    <h3 class="text-lg font-bold text-gray-700">
                        No tasks yet
                    </h3>

                    <p class="text-sm text-gray-500 mb-4">
                        Add your first task to get started.
                    </p>

                    <a
                        href="{{ route('todos.create') }}"
                        class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600
                               text-white font-semibold py-2 px-4 rounded-xl text-sm transition"
                    >
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Your First Task</span>
                    </a>

                </div>

            @endforelse

        </div>

    </main>


    <!-- JavaScript -->
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Toast Messages
            |--------------------------------------------------------------------------
            */

            const toastData = document.getElementById('toast-data');

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

    </script>

</body>

</html>