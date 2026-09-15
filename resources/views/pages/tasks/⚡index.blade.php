<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    #[Computed]
    public function getTodos()
    {
        return Auth::user()->todos()->get();
    }

    public function completeTodo($id)
    {
        $todo = Auth::user()->todos()->findOrFail($id);
        $todo->update([
            'completed' => true,
            'completed_at' => now(),
        ]);
    }
};
?>

<div class="min-h-screen bg-gray-50 p-6">

    <!-- Main Content -->
    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="flex items-center justify-between bg-gray-100 p-6 rounded-2xl mb-6 shadow-sm">
            <h1 class="text-xl font-bold text-gray-800">
                My Tasks
            </h1>
        </div>


        <!-- Todo List -->
        <div class="space-y-4">

            @foreach ($this->getTodos as $todo)
                <!-- Todo Card -->
                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">

                    <div class="flex items-start gap-4">

                        <!-- Completion Button -->
                        <button type="button"
                            class="w-6 h-6 rounded-md border flex-shrink-0 flex items-center justify-center transition
                                {{ $todo->completed
                                    ? 'bg-emerald-500 border-emerald-500 text-white'
                                    : 'border-gray-300 hover:border-emerald-500' }}"
                            wire:click="completeTodo({{ $todo->id }})">

                            @if ($todo->completed)
                                <i class="fa-solid fa-check text-xs"></i>
                            @endif

                        </button>


                        <!-- Todo Information -->
                        <div class="flex-1">

                            <!-- Title -->
                            <div
                                class="font-medium text-gray-800
                                    {{ $todo->completed ? 'line-through text-gray-400' : '' }}">
                                {{ $todo->title }}
                            </div>


                            <!-- Status -->
                            <span
                                class="inline-block text-xs font-medium px-2 py-0.5 rounded-full mt-1
                                    {{ $todo->completed ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $todo->completed ? 'Completed' : 'Pending' }}
                            </span>


                            <!-- Completion Date -->
                            @if ($todo->completed && $todo->completed_at)
                                <p class="text-xs text-gray-400 mt-1">
                                    Completed on
                                    {{ $todo->completed_at->format('M d, Y h:i A') }}
                                </p>
                            @endif

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

</div>
