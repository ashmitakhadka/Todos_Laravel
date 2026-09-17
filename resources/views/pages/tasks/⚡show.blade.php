<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $todo;

    public function mount($todo)
    {
        $this->todo = Auth::user()->todos()->findOrFail($todo);

        $this->authorize('view', $this->todo);
    }

    public function toggleComplete()
    {
        $this->authorize('update', $this->todo);

        $this->todo->update([
            'completed' => !$this->todo->completed,
            'completed_at' => !$this->todo->completed ? now() : null,
        ]);
    }

    public function deleteTodo()
    {
        $this->authorize('delete', $this->todo);

        $this->todo->delete();

        session()->flash('success', 'Todo deleted successfully');

        $this->redirect('/livewire/tasks');
    }

    public function askDelete()
    {
        $this->dispatch('confirm-delete');
    }
};
?>
<div class="min-h-screen bg-gray-50 px-4 py-10">
    <div class="mx-auto max-w-2xl">

        {{-- Back button --}}
        <a href="{{ route('livewire.tasks.index') }}"
            class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-gray-500
                   transition hover:text-gray-900">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Tasks
        </a>

        {{-- Task Card --}}
        <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">

            {{-- Card Header --}}
            <div class="border-b border-gray-100 px-6 py-5">
                <div class="flex items-center justify-between gap-4">

                    <div>
                        <p class="text-sm font-medium text-gray-400">
                            Task Details
                        </p>

                        <h1 class="mt-1 text-2xl font-bold text-gray-900">
                            {{ $todo->title }}
                        </h1>
                    </div>

                    {{-- Status --}}
                    @if ($todo->completed)
                        <span
                            class="inline-flex items-center gap-2 rounded-full
                                   bg-green-50 px-3 py-1.5 text-sm font-medium text-green-700">
                            <span class="h-2 w-2 rounded-full bg-green-500"></span>
                            Completed
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-2 rounded-full
                                   bg-yellow-50 px-3 py-1.5 text-sm font-medium text-yellow-700">
                            <span class="h-2 w-2 rounded-full bg-yellow-500"></span>
                            Active
                        </span>
                    @endif

                </div>
            </div>

            {{-- Task Content --}}
            <div class="px-6 py-6">

                {{-- Description --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">
                        Description
                    </h2>

                    @if ($todo->description)
                        <p class="mt-2 leading-7 text-gray-600">
                            {{ $todo->description }}
                        </p>
                    @else
                        <p class="mt-2 italic text-gray-400">
                            No description provided.
                        </p>
                    @endif
                </div>

                {{-- Created date --}}
                <div class="mt-6 flex items-center gap-2 text-sm text-gray-400">
                    <i class="fa-regular fa-calendar"></i>

                    Created
                    {{ $todo->created_at->format('M d, Y') }}
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex flex-col gap-3 border-t border-gray-100 bg-gray-50 px-6 py-5 sm:flex-row">

                {{-- Toggle Complete --}}
                <button wire:click="toggleComplete" wire:loading.attr="disabled"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl
                           bg-gray-900 px-5 py-3 text-sm font-semibold text-white
                           transition hover:bg-gray-800
                           disabled:cursor-not-allowed disabled:opacity-50">
                    <i class="fa-solid fa-check"></i>

                    @if ($todo->completed)
                        Mark as Active
                    @else
                        Mark as Completed
                    @endif
                </button>

                {{-- Edit --}}
                <a href="{{ route('livewire.tasks.edit', $todo->id) }}"
                    class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl
                           border border-gray-200 bg-white px-5 py-3 text-sm font-semibold
                           text-gray-700 transition hover:bg-gray-100">
                    <i class="fa-solid fa-pen"></i>
                    Edit
                </a>

                {{-- Delete --}}
                <button type="button" wire:click="askDelete"
                    class="inline-flex items-center justify-center gap-2 rounded-xl
           border border-red-200 bg-white px-5 py-3 text-sm font-semibold
           text-red-600 transition hover:bg-red-50">
                    <i class="fa-solid fa-trash"></i>
                    Delete
                </button>

            </div>

        </div>
    </div>
    <x-toast />
</div>

@script
    <script>
        $wire.on('confirm-delete', () => {
            Swal.fire({
                title: 'Delete Todo?',
                text: 'Are you sure you want to delete "{{ $todo->title }}"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deleteTodo();
                }
            });
        });
    </script>
@endscript
