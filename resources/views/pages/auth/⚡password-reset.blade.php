<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

new class extends Component {
    public $token = '';

    public $email = '';

    #[Validate('required|string|min:6|confirmed')]
    public $password = '';

    public $password_confirmation = '';

    public function mount($token)
    {
        $this->token = $token;

        $this->email = request()->query('email');
    }

    public function resetPassword()
    {
        $this->validate();

        // Find matching reset token
        $resetData = DB::table('password_reset_tokens')->where('email', $this->email)->where('token', $this->token)->first();

        // Token doesn't exist
        if (!$resetData) {
            session()->flash('error', 'Invalid or expired password reset link.');

            return;
        }

        // Token expired
        if (Carbon::parse($resetData->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $this->email)->delete();

            session()->flash('error', 'Password reset link has expired.');

            return;
        }

        // Find user
        $user = User::where('email', $this->email)->first();

        // Update password
        $user->password = Hash::make($this->password);
        $user->save();

        // Delete used token
        DB::table('password_reset_tokens')->where('email', $this->email)->delete();

        session()->flash('success', 'Password reset successfully. You can now login.');

        $this->redirect('/livewire/login');
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
                    Reset Password
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Enter your new password below.
                </p>

            </div>


            <!-- Form -->
            <form wire:submit="resetPassword" class="space-y-4">

                <!-- Email -->
                <div>

                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Email
                    </label>

                    <input type="email" id="email" wire:model="email" readonly
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5
                               text-sm bg-gray-50 text-gray-600">

                </div>


                <!-- New Password -->
                <div>

                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                        New Password
                    </label>

                    <input type="password" id="password" wire:model="password" placeholder="Enter new password"
                        autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5
                               text-sm outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                               transition">

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <!-- Confirm Password -->
                <div>

                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Confirm Password
                    </label>

                    <input type="password" id="password_confirmation" wire:model="password_confirmation"
                        placeholder="Confirm new password" autocomplete="new-password"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5
                               text-sm outline-none
                               focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                               transition">

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
                        Reset Password
                    </span>

                    <span wire:loading>
                        Resetting...
                    </span>

                </button>


                <!-- Login -->
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
