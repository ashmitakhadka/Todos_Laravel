<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo</title>

    {{-- Link to your create.css stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/create.css') }}?v={{ time() }}">
</head>
<body>

    <div class="create-form-container">
        <h1>Edit Todo</h1>

        <div class="form">
            <form action="{{ route('todos.update', $todo) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title', $todo->title) }}" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea 
                        id="description" 
                        name="description"
                    >{{ old('description', $todo->description) }}</textarea>
                </div>

                <div class="button-group">
                    <button class="btn" type="submit">Update Todo</button>
                    <a href="{{ route('todos.index') }}" class="btn-back">Back</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>