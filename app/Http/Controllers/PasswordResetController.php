<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
      
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            [
                'email' => $request->email,
            ],
            [
                'token' => $token,
                'created_at' => Carbon::now(),
            ]
        );

        $resetUrl = url(
            '/password-reset/' .
            $token .
            '?email=' .
            urlencode($request->email)
        );


        Mail::send(
            'email.password-reset',
            [
                'token' => $token,
                'email' => $request->email,
                'resetUrl' => $resetUrl,
            ],
            function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            }
        );

        return redirect()
            ->route('password.request')
            ->with(
                'success',
                'Email has been sent successfully!'
            );
    }


    public function resetPassword(Request $request, $token)
    {
        return view('auth.new-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPasswordPost(Request $request)
    {

        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],

            'token' => [
                'required'
            ],
        ]);


        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();


        if (!$resetData) {

            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Invalid or expired password reset link.'
                );
        }


        if (
            Carbon::parse($resetData->created_at)
                ->addMinutes(60)
                ->isPast()
        ) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return redirect()
                ->route('password.request')
                ->with(
                    'error',
                    'Password reset link has expired.'
                );
        }


        $user = User::where(
            'email',
            $request->email
        )->first();

        $user->password = $request->password;
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Password reset successfully. You can now login.'
            );
    }
}