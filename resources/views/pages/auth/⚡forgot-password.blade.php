<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

new class extends Component {
    #[Validate('required|email|exists:users,email')]
    public $email = '';

    public function sendResetLink()
    {
        $this->validate();

        // Generate reset token
        $token = Str::random(64);

        // Store or update reset token
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $this->email],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ],
        );

        // Create reset URL
        $resetUrl = url('/livewire/password-reset/' . $token . '?email=' . urlencode($this->email));

        // Send email
        Mail::send(
            'email.password-reset',
            [
                'token' => $token,
                'email' => $this->email,
                'resetUrl' => $resetUrl,
            ],
            function ($message) {
                $message->to($this->email);
                $message->subject('Reset Password');
            },
        );

        $this->dispatch('show-toast', message: 'Password reset email has been sent successfully!', type: 'success');

        $this->reset('email');
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
                    Forgot Password
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Enter your email to receive a password reset link.
                </p>

            </div>


            <!-- Form -->
            <form wire:submit="sendResetLink" class="space-y-4">

                <!-- Email -->
                <div>

                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email
                    </label>

                    <input type="email" id="email" wire:model="email" placeholder="Enter your email"
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


                <!-- Button -->
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-blue-500 hover:bg-blue-600
                           disabled:opacity-60 disabled:cursor-not-allowed
                           text-white text-sm font-semibold
                           py-2.5 rounded-xl
                           transition duration-200
                           shadow-sm hover:shadow">

                    <span wire:loading.remove>
                        Send Reset Link
                    </span>

                    <span wire:loading>
                        Sending...
                    </span>

                </button>


                <!-- Back to Login -->
                <p class="text-center text-sm text-gray-500 pt-1">

                    Remember your password?

                    <a href="{{ route('livewire.login') }}" class="text-blue-500 hover:text-blue-600 font-medium">
                        Login
                    </a>

                </p>

            </form>

        </div>

    </div>

</div>
