<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyOtpRequest;
use App\Services\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;
use RuntimeException;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function show(): View|RedirectResponse
    {
        if (session('two_factor_verified') === true) {
            return redirect()->route('dashboard');
        }

        return view('auth.verify-otp', [
            'email' => Auth::user()->email,
        ]);
    }

    public function verify(
        VerifyOtpRequest $request,
        TwoFactorService $twoFactorService
    ): RedirectResponse {
        $user = Auth::user();

        $key = '2fa-verify:' . $user->id;

        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->with(
                'error',
                "Too many attempts. Try again in {$seconds} seconds."
            );
        }

        RateLimiter::hit($key, 60);

        try {
            $twoFactorService->verify(
                $user,
                $request->validated('code')
            );
        } catch (RuntimeException $exception) {
            return back()
                ->with('error', $exception->getMessage())
                ->withInput();
        }

        RateLimiter::clear($key);

        session([
            'two_factor_verified' => true,
        ]);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Two-factor authentication verified successfully.'
            );
    }

    public function resend(
        TwoFactorService $twoFactorService
    ): RedirectResponse {
        $user = Auth::user();

        try {
            $twoFactorService->generateAndSend($user);
        } catch (RuntimeException $exception) {
            return back()
                ->with('error', $exception->getMessage());
        }

        return back()
            ->with(
                'success',
                'A new verification code has been sent to your email.'
            );
    }
}
