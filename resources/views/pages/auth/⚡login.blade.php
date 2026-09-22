<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required|min:6')]
    public $password = '';

    public $remember = false;

    public function login()
    {
        $this->validate();

        if (
            !Auth::attempt(
                [
                    'email' => $this->email,
                    'password' => $this->password,
                ],
                $this->remember,
            )
        ) {
            $this->addError('email', 'The email or password is incorrect.');

            return;
        }

        request()->session()->regenerate();

        session()->flash('success', 'Login successful!');

        $this->redirect('/livewire/tasks');
    }
    public function updatedEmail()
    {
        $this->validateOnly('email');
    }

    public function updatedPassword()
    {
        $this->validateOnly('password');
    }
};
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4 py-8">

    <x-toast />

    <div class="w-full max-w-md">

        <div class="bg-white rounded-2xl shadow-lg px-8 py-7">

            <!-- Heading -->
            <div class="text-center mb-6">

                <h1 class="text-2xl font-bold text-gray-800">
                    Todo App
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Login to your account
                </p>

            </div>


            <!-- Login Form -->
            <form wire:submit="login" class="space-y-4">

                <!-- Email -->
                <div>

                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email
                    </label>

                    <input type="email" id="email" wire:model.live="email" placeholder="Enter your email"
                        autocomplete="email"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5
                               text-sm outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                               transition">

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Password -->
                <div>

                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Password
                    </label>

                    <div class="relative">

                        <input type="password" id="password" wire:model.live="password"
                            placeholder="Enter your password" autocomplete="current-password"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 pr-12
                                   text-sm outline-none
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                   transition">

                        <button type="button" id="togglePassword"
                            class="absolute right-3 top-1/2 -translate-y-1/2
                                   text-gray-500 hover:text-gray-700">
                            <i id="passwordIcon" class="fa-solid fa-eye-slash"></i>
                        </button>

                    </div>

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Remember Me -->
                <div class="flex items-center justify-between">

                    <label class="flex items-center gap-2 text-sm text-gray-600">

                        <input type="checkbox" wire:model="remember"
                            class="rounded border-gray-300
                                   text-blue-500 focus:ring-blue-500">

                        <span>
                            Remember me
                        </span>

                    </label>

                </div>


                <!-- Forgot Password -->
                <div class="text-right">

                    <a href="{{ route('password.request') }}"
                        class="text-sm text-blue-500 hover:text-blue-600 font-medium">
                        Forgot password?
                    </a>

                </div>


                <!-- Login Button -->
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-blue-500 hover:bg-blue-600
                           disabled:opacity-60 disabled:cursor-not-allowed
                           text-white text-sm font-semibold
                           py-2.5 rounded-xl
                           transition duration-200
                           shadow-sm hover:shadow">

                    <span wire:loading.remove>
                        Login
                    </span>

                    <span wire:loading>
                        Logging in...
                    </span>

                </button>


                <!-- Register -->
                <p class="text-center text-sm text-gray-500 pt-1">

                    Don't have an account?

                    <a href="{{ route('livewire.register') }}" class="text-blue-500 hover:text-blue-600 font-medium">
                        Register
                    </a>

                </p>

            </form>

        </div>

    </div>

</div>
