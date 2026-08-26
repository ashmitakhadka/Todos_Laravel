<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen">

    <h1 class="text-center font-medium text-[32px] my-[2px] px-[20px] pt-[30px]">Edit Todo</h1>

    <div class="bg-gray-50 min-h-screen flex flex-col items-center mt-[20px] px-[20px] py-[40px]">
        <form action="{{ route('todos.update', $todo) }}" method="POST" 
              class="bg-white shadow-sm max-w-[600px] w-full p-[30px] rounded-[30px] flex flex-col gap-6">
            @csrf
            @method('PUT')

            <div class="flex flex-col">
                <label for="title" class="block font-medium text-gray-700 mb-[8px]">Title</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title', $todo->title) }}" 
                    required
                    class="border border-gray-300 outline-none rounded-[6px] focus:ring-2 focus:ring-blue-100 text-left px-[16px] py-2.5"
                >
            </div>

            <div class="flex flex-col">
                <label for="description" class="block font-medium text-gray-700 mb-[8px]">Description</label>
                <textarea 
                    id="description" 
                    name="description"
                    class="border border-gray-300 outline-none rounded-[6px] focus:ring-2 focus:ring-blue-100 text-left p-[16px] min-h-[120px] "
                >{{ old('description', $todo->description) }}</textarea>
            </div>

            <div class="flex flex-col items-center gap-3 mt-4">
   
    <button 
        type="submit" 
        class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-[10px] focus:outline-none focus:ring-2 focus:ring-blue-500 w-[200px]"
    >
        Update Todo
    </button>
    
    <a 
        href="{{ route('todos.index') }}" 
        class="text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-[10px] transition duration-200 focus:outline-none focus:ring-2 w-[200px]"
    >
        Back
    </a>
</div>
        </form>
    </div>

</body>
</html>]