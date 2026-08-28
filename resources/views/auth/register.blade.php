@extends('layouts.app')

@section('title', 'Create Account')

@section('content')

    <div class="auth-wrapper">
        <div class="card auth-card">

            <div class="card-body p-4 p-md-5">

                <div class="text-center mb-4">

                    <h2 class="fw-bold">
                        Create Account
                    </h2>

                    <p class="text-secondary">
                        Create your account to get started.
                    </p>

                </div>

                <form action="{{ route('register.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">

                        <label for="name" class="form-label">
                            Full Name
                        </label>

                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="mb-3">

                        <label for="email" class="form-label">
                            Email Address
                        </label>

                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    <div class="mb-3">

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

                        <div class="form-text">
                            Minimum 8 characters with letters,
                            mixed case and numbers.
                        </div>

                    </div>


                    <div class="mb-4">

                        <label for="password_confirmation" class="form-label">
                            Confirm Password
                        </label>

                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            required>

                    </div>


                    <button type="submit" class="btn btn-primary w-100">
                        Create Account
                    </button>

                </form>


                <div class="text-center mt-4">

                    <span class="text-secondary">
                        Already have an account?
                    </span>

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                </div>

            </div>

        </div>
    </div>

@endsection
