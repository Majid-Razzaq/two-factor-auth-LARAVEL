<?php

namespace App\Services;

use App\Mail\TwoFactorCodeMail;
use App\Models\TwoFactorCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use RuntimeException;

class TwoFactorService
{
    private const CODE_EXPIRATION_MINUTES = 5;

    private const MAX_ATTEMPTS = 5;

    public function generateAndSend(User $user): void
    {
        $rateLimitKey = '2fa-send:' . $user->id;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 3)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            throw new RuntimeException(
                "Too many verification codes requested. Try again in {$seconds} seconds."
            );
        }

        RateLimiter::hit($rateLimitKey, 60);

        $user->twoFactorCodes()->delete();

        $plainCode = (string) random_int(100000, 999999);

        $code = $user->twoFactorCodes()->create([
            'code' => Hash::make($plainCode),
            'attempts' => 0,
            'expires_at' => now()->addMinutes(
                self::CODE_EXPIRATION_MINUTES
            ),
        ]);

        Mail::to($user->email)
            ->send(
                new TwoFactorCodeMail(
                    $user,
                    $plainCode,
                    $code->expires_at
                )
            );
    }

    public function verify(User $user, string $plainCode): bool
    {
        $code = $user->twoFactorCodes()
            ->latest()
            ->first();

        if (!$code) {
            throw new RuntimeException(
                'No verification code was found. Please request a new code.'
            );
        }

        if ($code->isExpired()) {
            $code->delete();

            throw new RuntimeException(
                'Your verification code has expired. Please request a new code.'
            );
        }

        if ($code->attempts >= self::MAX_ATTEMPTS) {
            $code->delete();

            throw new RuntimeException(
                'Too many incorrect attempts. Please request a new code.'
            );
        }

        if (!Hash::check($plainCode, $code->code)) {
            $code->increment('attempts');

            throw new RuntimeException(
                'The verification code is incorrect.'
            );
        }

        $code->delete();

        return true;
    }
}
