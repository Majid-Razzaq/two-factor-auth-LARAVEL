@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="auth-wrapper">

        <div class="card auth-card">

            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">

                    <h2 class="fw-bold">
                        Welcome Back
                    </h2>

                    <p class="text-secondary">
                        Login to continue to your account.
                    </p>

                </div>


                <form action="{{ route('login.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">

                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required
                            autofocus>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="mb-4">

                        <label for="password" class="form-label">
                            Password
                        </label>

                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <button type="submit" class="btn btn-primary w-100">
                        Login
                    </button>

                </form>


                <div class="text-center mt-4">

                    <span class="text-secondary">
                        Don't have an account?
                    </span>

                    <a href="{{ route('register') }}">
                        Create one
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection
