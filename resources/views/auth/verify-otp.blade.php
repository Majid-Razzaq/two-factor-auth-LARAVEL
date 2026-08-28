@extends('layouts.app')

@section('title', 'Verify Login')

@section('content')

    <div class="auth-wrapper">

        <div class="card auth-card">

            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">

                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
                        style="width:70px;height:70px;">
                        🔐
                    </div>

                    <h2 class="fw-bold">
                        Verify Your Login
                    </h2>

                    <p class="text-secondary mb-1">
                        We've sent a 6-digit verification code to:
                    </p>

                    <strong>
                        {{ $email }}
                    </strong>

                </div>


                <form action="{{ route('two-factor.verify') }}" method="POST">

                    @csrf

                    <div class="mb-4">

                        <label for="code" class="form-label">
                            Verification Code
                        </label>

                        <input type="text" name="code" id="code"
                            class="form-control otp-input @error('code') is-invalid @enderror" maxlength="6"
                            inputmode="numeric" autocomplete="one-time-code" placeholder="000000" required autofocus>

                        @error('code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <button type="submit" class="btn btn-primary w-100">
                        Verify Code
                    </button>

                </form>


                <div class="text-center mt-4">

                    <p class="text-secondary mb-2">
                        Didn't receive the code?
                    </p>

                    <form action="{{ route('two-factor.resend') }}" method="POST">

                        @csrf

                        <button type="submit" class="btn btn-link text-decoration-none">
                            Resend Code
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
