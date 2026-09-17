<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $status = 'all';
    public $sort = 'newest';
    public $search = '';
    #[Computed]
    public function getTodos()
    {
        $todos = Auth::user()->todos();

        if ($this->search) {
            $todos = $todos->search($this->search);
        }
        if ($this->status !== 'all') {
            $todos = $todos->status($this->status);
        }
        if ($this->sort === 'newest') {
            $todos->latest();
        } elseif ($this->sort === 'oldest') {
            $todos->oldest();
        } elseif ($this->sort === 'az') {
            $todos->orderBy('title', 'asc');
        } elseif ($this->sort === 'za') {
            $todos->orderBy('title', 'desc');
        }

        return $todos->paginate(5);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function searchTodos()
    {
        $this->resetPage();
    }

    public function completeTodo($id)
    {
        $todo = Auth::user()->todos()->findOrFail($id);

        $this->authorize('update', $todo);

        if ($todo->completed) {
            return;
        }

        $todo->update([
            'completed' => true,
            'completed_at' => now(),
        ]);

        $this->dispatch('todo-completed', message: 'Todo completed successfully');
    }

    public function deleteTodo($id)
    {
        $todo = Auth::user()->todos()->findOrFail($id);

        $this->authorize('delete', $todo);

        $todo->delete();

        $this->dispatch('todo-deleted', message: 'Todo deleted successfully');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $this->redirect('/livewire/login');
    }
};
?>

<div class="min-h-screen bg-slate-50 p-6">

    <!-- Navbar -->
    <nav class="border-b border-slate-200 bg-white">

        <div class="mx-auto flex h-20 max-w-5xl items-center justify-between px-6">

            <!-- App Name -->
            <h1 class="text-2xl font-bold text-slate-900">
                Todo App
            </h1>

            <!-- Right Side -->
            <div class="flex items-center gap-3">

                <!-- Search -->
                <form wire:submit="searchTodos">
                    <div class="relative">

                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400">
                        </i>

                        <input type="text" placeholder="Search todos..."
                            class="h-11 w-56 rounded-lg border border-slate-200 bg-slate-50 pl-10 pr-4 text-sm text-slate-700
                           placeholder-slate-400 outline-none transition focus:border-violet-400 focus:bg-white focus:ring-2 focus:ring-violet-100"
                            wire:model.live="search">

                    </div>
                </form>

                <form wire:submit="logout">
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex h-11 items-center gap-2 rounded-lg px-4 text-sm font-semibold text-rose-600
                         transition hover:bg-rose-50 disabled:opacity-60">

                        <i class="fa-solid fa-right-from-bracket"></i>

                        <span wire:loading.remove>Log out</span>
                        <span wire:loading>Logging out...</span>

                    </button>
                </form>

            </div>

        </div>

    </nav>

    <!-- Main Content -->
    <div class="mx-auto max-w-3xl">

        <!-- Header -->
        <div class="mb-6 mt-8 flex items-center justify-between">

            <div>
                <h2 class="text-xl font-bold text-slate-900">My tasks</h2>
                <p class="mt-0.5 text-sm text-slate-500">
                    {{ $this->getTodos->total() }}
                    {{ $this->getTodos->total() == 1 ? 'task' : 'tasks' }}
                </p>
            </div>

            <div class="flex items-center gap-3">

                <!-- Status Filter -->

                <div class="relative">

                    <i class="fa-solid fa-filter absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>

                    <select name="status" onchange="this.form.submit()"
                        class="cursor-pointer appearance-none rounded-lg border border-slate-200 bg-white
                               py-2.5 pl-8 pr-8 text-sm font-medium text-slate-700 outline-none
                               focus:border-violet-400 focus:ring-2 focus:ring-violet-100"
                        wire:model.live="status">

                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>
                            All</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>

                    </select>

                    <i
                        class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>

                </div>
                <!-- Sort -->
                <div class="relative">

                    <i
                        class="fa-solid fa-arrow-down-wide-short absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">
                    </i>

                    <select wire:model.live="sort"
                        class="cursor-pointer appearance-none rounded-lg border border-slate-200 bg-white
                        py-2.5 pl-8 pr-8 text-sm font-medium text-slate-700 outline-none
                      focus:border-violet-400 focus:ring-2 focus:ring-violet-100">

                        <option value="newest">Newest</option>
                        <option value="oldest">Oldest</option>
                        <option value="az">A → Z</option>
                        <option value="za">Z → A</option>

                    </select>

                    <i
                        class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400">
                    </i>

                </div>
                <!-- Add Task -->
                <a href="{{ route('livewire.tasks.create') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-violet-600 px-4 py-2.5 text-sm font-semibold
                       text-white transition hover:bg-violet-700">

                    <i class="fa-solid fa-plus"></i>
                    <span>Add task</span>

                </a>

            </div>

        </div>

        <!-- Todo List -->
        <div class="space-y-3">

            @forelse ($this->getTodos as $todo)
                <div wire:key="todo-{{ $todo->id }}"
                    class="flex items-start gap-4 rounded-xl border border-slate-200 bg-white p-4 transition hover:border-slate-300">

                    <!-- Completion Button -->
                    <button type="button"
                        class="mt-0.5 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-md border transition
                           {{ $todo->completed
                               ? 'border-emerald-500 bg-emerald-500 text-white'
                               : 'border-slate-300 hover:border-emerald-500' }}"
                        wire:click="completeTodo({{ $todo->id }})">

                        @if ($todo->completed)
                            <i class="fa-solid fa-check text-xs"></i>
                        @endif

                    </button>

                    <!-- Todo Information -->
                    <div class="flex-1">

                        <div
                            class="font-medium text-slate-800 {{ $todo->completed ? 'text-slate-400 line-through' : '' }}">
                            {{ $todo->title }}
                        </div>

                        <div class="mt-1.5 flex items-center gap-2">

                            <span
                                class="inline-block rounded-full px-2 py-0.5 text-xs font-medium
                                {{ $todo->completed ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">
                                {{ $todo->completed ? 'Completed' : 'Pending' }}
                            </span>

                            @if ($todo->completed && $todo->completed_at)
                                <span class="text-xs text-slate-400">
                                    {{ $todo->completed_at->format('M d, Y h:i A') }}
                                </span>
                            @endif

                        </div>

                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 pt-0.5">

                        @if (!$todo->completed)
                            <a href="{{ route('livewire.tasks.edit', $todo->id) }}"
                                class="inline-flex items-center gap-1.5 text-sm font-medium text-violet-600 transition hover:text-violet-800">
                                <i class="fa-solid fa-pen text-xs"></i>
                                <span>Edit</span>
                            </a>
                        @endif

                        <button type="button" wire:click="deleteTodo({{ $todo->id }})"
                            wire:confirm="Delete this task? This can't be undone."
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-rose-500 transition hover:text-rose-700">
                            <i class="fa-solid fa-trash text-xs"></i>
                            <span>Delete</span>
                        </button>

                    </div>

                </div>

            @empty

                <div class="rounded-xl border border-dashed border-slate-200 bg-white p-10 text-center">
                    <i class="fa-regular fa-circle-check text-2xl text-slate-300"></i>
                    <p class="mt-3 font-medium text-slate-700">Nothing here</p>
                    <p class="mt-1 text-sm text-slate-500">Add a task to get started.</p>
                </div>
            @endforelse

            @if ($this->getTodos->hasPages())
                <div class="pt-2">
                    {{ $this->getTodos->links() }}
                </div>
            @endif

        </div>

    </div>

    <!-- Toast -->
    <x-toast />

</div>

<script>
    $wire.on('todo-completed', (event) => {
        showToast(event.message, 'success');
    });

    $wire.on('todo-deleted', (event) => {
        showToast(event.message, 'success');
    });
</script>
