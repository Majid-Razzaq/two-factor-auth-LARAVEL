<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RuntimeException;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        User::create([
            'name'      => $request->validated('name'),
            'email'     => $request->validated('email'),
            'password'  => $request->validated('password'),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Account created successfully. You can now login.');
    }

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(
        LoginRequest $request,
        TwoFactorService $twoFactorService
    ): RedirectResponse {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'email' => 'The provided credentials are incorrect.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        session([
            'two_factor_verified' => false,
        ]);

        try {
            $twoFactorService->generateAndSend($user);
        } catch (RuntimeException $exception) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->with('error', $exception->getMessage())
                ->onlyInput('email');
        }

        return redirect()
            ->route('two-factor.show')
            ->with(
                'success',
                'A verification code has been sent to your email.'
            );
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
