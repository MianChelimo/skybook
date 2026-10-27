<?php

namespace App\Providers;

use App\Actions\Fortify\SendPhoneOtp;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Contracts\RedirectsIfTwoFactorAuthenticatable;
use Laravel\Fortify\Features;


use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    auth()->logout();

                    return redirect()
                        ->route('login')
                        ->with(
                            'status',
                            'Registration successful! Please log in.'
                        );
                }
            };
        });
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        // Display the login and registration pages.
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });
        Fortify::redirects('login', '/dashboard');
        
Fortify::authenticateThrough(function (Request $request) {
    return array_filter([
        config('fortify.limiters.login')
            ? null
            : EnsureLoginIsNotThrottled::class,

        config('fortify.lowercase_usernames')
            ? CanonicalizeUsername::class
            : null,

        Features::enabled(Features::twoFactorAuthentication())
            ? RedirectsIfTwoFactorAuthenticatable::class
            : null,

        AttemptToAuthenticate::class,

        SendPhoneOtp::class,

        PrepareAuthenticatedSession::class,
    ]);
});


        // Configure Fortify user actions.
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::updateUserProfileInformationUsing(
            UpdateUserProfileInformation::class
        );

        Fortify::updateUserPasswordsUsing(
            UpdateUserPassword::class
        );

        Fortify::resetUserPasswordsUsing(
            ResetUserPassword::class
        );

        Fortify::redirectUserForTwoFactorAuthenticationUsing(
            RedirectIfTwoFactorAuthenticatable::class
        );

        // Limit login attempts.
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(
                Str::lower($request->input(Fortify::username()))
                . '|' . $request->ip()
            );

            return Limit::perMinute(5)->by($throttleKey);
        });

        // Limit two-factor authentication attempts.
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by(
                $request->session()->get('login.id')
            );
        });

        // Limit passkey authentication attempts.
        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId())
                . '|' . $request->ip()
            );
        });
    }
}
