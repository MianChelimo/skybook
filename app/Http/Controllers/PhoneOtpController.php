<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PhoneOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneOtpController extends Controller
{
    public function show(Request $request)
    {
        if (! $request->session()->has('phone_otp_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.phone-otp');
    }

    public function verify(
        Request $request,
        PhoneOtpService $phoneOtpService
    ) {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $userId = $request->session()->get('phone_otp_user_id');

        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);

        if (! $user) {
            $request->session()->forget('phone_otp_user_id');

            return redirect()->route('login');
        }

        $phoneOtpService->verify($user, $request->input('code'));

        Auth::login($user);

        $request->session()->forget('phone_otp_user_id');
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
