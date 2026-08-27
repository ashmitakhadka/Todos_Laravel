<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Todo</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white min-h-screen">

    <!-- Main Page -->
    <div class="min-h-screen bg-white">

        <!-- Heading -->
        <h1 class="text-center font-medium text-[32px] pt-[20px]">
            Add Todo
        </h1>

        

        <!-- Gray Background -->
        <div class="bg-gray-50 rounded-t-[30px] min-h-screen mt-[30px] px-[20px] pt-[40px]">

            <!-- White Form Card -->
            <div class="bg-white rounded-[20px] shadow-sm max-w-[600px] mx-auto p-[30px]">

                <form action="{{ route('todos.store') }}" method="POST">

                    @csrf

                    <!-- Title -->
                    <div class="mb-[20px]">
                        <label
                            for="title"
                            class="block font-medium text-gray-700 mb-[8px]"
                        >
                            Title
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            placeholder="Enter todo title..."
                            required
                            class="w-full border border-gray-300 rounded-[10px] px-[15px] py-[12px] outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200"
                        >
                    </div>

                    <!-- Description -->
                    <div class="mb-[20px]">
                        <label
                            for="description"
                            class="block font-medium text-gray-700 mb-[8px]"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            placeholder="Enter description..."
                            class="w-full border border-gray-300 rounded-[10px] px-[15px] py-[12px] outline-none resize-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition duration-200"
                        ></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col items-center gap-3 mt-4">

                        <!-- Add Button -->
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-[10px] transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 w-[200px]"
                        >
                            Add Todo
                        </button>

                        <!-- Back Button -->
                        <a
                            href="{{ route('todos.index') }}"
                            class="text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-[10px] transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 w-[200px]"
                        >
                            Back
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>