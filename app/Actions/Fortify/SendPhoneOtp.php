<?php

namespace App\Actions\Fortify;

use App\Services\PhoneOtpService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;

class SendPhoneOtp
{
    public function handle(Request $request, Closure $next)
    {
        $guard = Auth::guard(config('fortify.guard'));
        $user = $guard->user();

        if (! $user) {
            return $next($request);
        }

        $code = app(PhoneOtpService::class)->generate($user);

        $userId = $user->getKey();

        $guard->logout();

        $request->session()->put('phone_otp_user_id', $userId);

        if (app()->isLocal()) {
            $request->session()->put('phone_otp_debug_code', $code);
        }

        return redirect()->route('phone-otp.show');
    }
}
