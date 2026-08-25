<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="container">


    <header class="header">
        <div>
            <h1>Todo App</h1>
        </div>
    </header>



    <div class="task-header">
        <div>
            <h2>My Tasks</h2>
            <p>{{ count($todos) }} {{ count($todos) == 1 ? 'task' : 'tasks' }}</p>
        </div>

        <a href="{{ route('todos.create') }}" class="add-button">
            <i class="fa-solid fa-plus"></i>
            Add Task
        </a>
    </div>


    
    <div class="todos">

        @forelse($todos as $todo)

            <div class="todo {{ $todo->completed ? 'completed' : '' }}">

         
                <div class="todo-check">
                    <form action="{{ route('todos.complete', $todo) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="checkbox {{ $todo->completed ? 'checked' : '' }}">
                            @if($todo->completed)
                                <i class="fa-solid fa-check"></i>
                            @endif
                        </button>
                    </form>
                </div>


        
                <div class="todo-content">

                    <div class="todo-title">
                        @if($todo->completed)
                            <del>{{ $todo->title }}</del>
                        @else
                            {{ $todo->title }}
                        @endif
                    </div>

                    <span class="status">
                        {{ $todo->completed ? 'Completed' : 'Pending' }}
                    </span>

                </div>


      
                <div class="todo-actions">

                    <a href="{{ route('todos.edit', $todo) }}"
                       class="edit"
                       title="Edit task">
                        <i class="fa-solid fa-pen"></i>
                    </a>

                    <form action="{{ route('todos.destroy', $todo) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this task?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="delete"
                                title="Delete task">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="empty">
                <i class="fa-regular fa-clipboard"></i>
                <h3>No tasks yet</h3>
                <p>Add your first task to get started.</p>

                <a href="{{ route('todos.create') }}" class="add-button">
                    <i class="fa-solid fa-plus"></i>
                    Add Your First Task
                </a>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>