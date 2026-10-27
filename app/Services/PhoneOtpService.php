<?php
namespace App\Services;

use App\Models\PhoneOtp;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class PhoneOtpService
{
    public function generate(User $user): string
    {
        if (empty($user->phone_number)) {
            throw ValidationException::withMessages([
                'phone_number' => 'Please add a phone number to your account first.',
            ]);
        }

        $code = (string) random_int(100000, 999999);

        PhoneOtp::updateOrCreate(
            ['user_id' => $user->id],
            [
                'code_hash' => Hash::make($code),
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
            ]
        );

        RateLimiter::clear('phone-otp:' . $user->id);

        return $code;
    }

    public function verify(User $user, string $code): bool
    {
        $key = 'phone-otp:' . $user->id;

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'code' => 'Too many attempts. Please request a new code later.',
            ]);
        }

        $verified = DB::transaction(function () use ($user, $code, $key) {
            $otp = PhoneOtp::where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if (
                ! $otp ||
                $otp->expires_at->isPast() ||
                $otp->attempts >= 5 ||
                ! Hash::check($code, $otp->code_hash)
            ) {
                if ($otp) {
                    $otp->increment('attempts');
                }

                RateLimiter::hit($key, 300);

                return false;
            }

            $otp->delete();

            return true;
        });

        if (! $verified) {
            throw ValidationException::withMessages([
                'code' => 'The code is invalid or expired.',
            ]);
        }

        RateLimiter::clear($key);

        return true;
    }
}
