<?php

use Livewire\Component;

new class extends Component {
    public $todo;
    public $title = '';
    public $description = '';

    public function mount($todo)
    {
        $this->todo = Auth::user()->todos()->findOrFail($todo);

        $this->title = $this->todo->title;
        $this->description = $this->todo->description;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'description' => 'nullable',
        ]);

        $this->todo->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Todo edited successfully');

        $this->redirect('/livewire/tasks');
    }
};
?>

<div>
    <!-- Main Page -->
    <div class="min-h-screen bg-white">

        <!-- Heading -->
        <h1 class="text-center font-medium text-[32px] pt-[20px]">
            Edit Todo
        </h1>


        <!-- Gray Background -->
        <div class="bg-gray-50 rounded-t-[30px] min-h-screen mt-[30px] px-[20px] pt-[40px]">

            <!-- White Form Card -->
            <div class="bg-white rounded-[20px] shadow-sm max-w-[600px] mx-auto p-[30px]">

                <form wire:submit="update">
                    <div class="mb-[20px]">

                        <label for="title" class="block font-medium text-gray-700 mb-[8px]">
                            Title
                        </label>

                        <input type="text" id="title" wire:model="title" placeholder="Enter todo title..."
                            class="w-full border border-gray-300 rounded-[10px] px-[15px] py-[12px] outline-none focus:border-blue-500
                                   focus:ring-2 focus:ring-blue-100 transition duration-200">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>
                    <div class="mb-[20px]">

                        <label for="description" class="block font-medium text-gray-700 mb-[8px]">
                            Description
                        </label>

                        <textarea id="description" wire:model="description" rows="5" placeholder="Enter description..."
                            class="w-full border border-gray-300 rounded-[10px  px-[15px] py-[12px] outline-none resize-none
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                   transition duration-200"></textarea>

                        <!-- Description Validation Error -->
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>
                    <div class="flex flex-col items-center gap-3 mt-4">

                        <!-- Add Button -->
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-medium py-3 px-6
                                   rounded-[10px] transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 w-[200px]">
                            Edit Todo
                        </button>

                        <a href="{{ url('/livewire/tasks') }}"
                            class="text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium
                                   py-3 px-6 rounded-[10px] transition duration-200 focus:outline-none
                                   focus:ring-2 focus:ring-gray-300 w-[200px]">
                            Back
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>
    <x-toast />
</div>
<script>
    $wire.on('todo-added', (event) => {
        console.log('Event received:', event);
        console.log('showToast:', typeof window.showToast);

        window.showToast(event.message, 'success');
    });
</script>
