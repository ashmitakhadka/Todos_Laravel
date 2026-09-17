<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public $email = '';

    #[Validate('required|string|min:6|confirmed')]
    public $password = '';
    public $password_confirmation = '';

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'Account created successfully! Please login.');

        $this->redirect('/livewire/login');
    }
};
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">

    <x-toast />

    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg px-8 py-7">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Todo App
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Create your account
                </p>
            </div>

            <form wire:submit="save" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Name
                    </label>

                    <input type="text" id="name" wire:model="name" placeholder="Enter your name"
                        autocomplete="name"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5
                               text-sm outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                               transition" />

                    @error('name')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email
                    </label>

                    <input type="email" id="email" wire:model="email" placeholder="Enter your email"
                        autocomplete="email"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5
                               text-sm outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                               transition" />

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Password
                    </label>

                    <input type="password" id="password" wire:model="password" placeholder="Enter your password"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5
                               text-sm outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                               transition" />

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Confirm Password
                    </label>

                    <input type="password" id="password_confirmation" wire:model="password_confirmation"
                        placeholder="Confirm your password" autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5
                               text-sm outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                               transition" />

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600
                           text-white text-sm font-semibold
                           py-2.5 rounded-xl
                           transition duration-200
                           shadow-sm hover:shadow">
                    Register
                </button>

                <p class="text-center text-sm text-gray-500 pt-1">
                    Already have an account?

                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-medium">
                        Login
                    </a>
                </p>

            </form>

        </div>

    </div>

</div>
