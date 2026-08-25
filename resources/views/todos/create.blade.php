<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Todo</title>

    <link rel="stylesheet" href="{{ asset('css/create.css') }}?v={{ time() }}">
</head>

<body>

    <div class="create-form-container">

        <h1>Add Todo</h1>

        <div class="form">
            <form action="{{ route('todos.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>

                    <input
                        type="text"
                        id="title"
                        name="title"
                        placeholder="Enter todo title..."
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="description">Description</label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Enter description..."
                    ></textarea>
                </div>

                <button class="btn" type="submit">
                    Add Todo
                </button>

            </form>
        </div>

    </div>

</body>
</html>