<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome CDN -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >
</head>

<body class="bg-gray-50 min-h-screen flex flex-col items-center justify-center p-6 text-center">

    <div class="space-y-4">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-800">
            Hello, welcome to your app!
        </h1>

        <p class="text-lg text-gray-600">
            Click below to manage your task list.
        </p>

        <div>
            <a 
                href="{{ route('todos.index') }}" 
                class="inline-flex items-center gap-2 px-6 py-3 text-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-colors duration-200"
            >
                <i class="fa-solid fa-list-check"></i>
                Go to Todos
            </a>
        </div>
    </div>

</body>

</html>