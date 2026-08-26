<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Page Header -->
    <header class="bg-white py-6 shadow-sm text-center mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Todo App</h1>
    </header>

    <!-- Main Centered Container -->
    <main class="max-w-2xl mx-auto px-4 pb-12">

        <!-- Top Card: Title + Add Button -->
        <div class="flex items-center justify-between bg-gray-100 p-6 rounded-2xl mb-6 shadow-sm">
            <div>
                <h2 class="text-xl font-bold text-gray-800">My Tasks</h2>
                <p class="text-sm font-medium text-gray-500 mt-0.5">
                    {{ count($todos) }} {{ count($todos) == 1 ? 'task' : 'tasks' }}
                </p>
            </div>

            <a href="{{ route('todos.create') }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition">
                <i class="fa-solid fa-plus"></i>
                <span>Add Task</span>
            </a>
        </div>

        <!-- Task List Container -->
        <div class="space-y-3">
            @forelse($todos as $todo)
                <div class="flex items-center justify-between bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                    
                    <!-- Checkbox + Title + Status -->
                    <div class="flex items-center gap-4">
                        <form action="{{ route('todos.complete', $todo) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-6 h-6 rounded-md border flex items-center justify-center transition {{ $todo->completed ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-gray-300 hover:border-emerald-500' }}">
                                @if($todo->completed)
                                    <i class="fa-solid fa-check text-xs"></i>
                                @endif
                            </button>
                        </form>

                        <div>
                            <div class="font-medium text-gray-800 {{ $todo->completed ? 'line-through text-gray-400' : '' }}">
                                {{ $todo->title }}
                            </div>
                            <span class="inline-block text-xs font-medium px-2 py-0.5 rounded-full mt-1 {{ $todo->completed ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $todo->completed ? 'Completed' : 'Pending' }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions (Edit / Delete) -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('todos.edit', $todo) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit task">
                            <i class="fa-solid fa-pen"></i>
                        </a>

                        <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete task">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="text-center py-12 px-4 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <i class="fa-regular fa-clipboard text-4xl text-gray-400 mb-3"></i>
                    <h3 class="text-lg font-bold text-gray-700">No tasks yet</h3>
                    <p class="text-sm text-gray-500 mb-4">Add your first task to get started.</p>
                    <a href="{{ route('todos.create') }}" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-xl text-sm transition">
                        <i class="fa-solid fa-plus"></i>
                        <span>Add Your First Task</span>
                    </a>
                </div>
            @endforelse
        </div>

    </main>

</body>
</html>