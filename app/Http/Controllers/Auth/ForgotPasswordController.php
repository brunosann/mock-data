<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::INVALID_USER) {
            return response()->json(['message' => __(Password::RESET_LINK_SENT)]);
        }

        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], 400);
        }

        return response()->json(['message' => __($status)]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)], 400);
        }

        return response()->json(['message' => __($status)]);
    }
}
