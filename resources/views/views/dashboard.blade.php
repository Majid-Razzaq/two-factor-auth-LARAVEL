@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4 p-md-5">

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div>
                                <h2 class="fw-bold mb-1">
                                    Welcome, {{ auth()->user()->name }}!
                                </h2>

                                <p class="text-secondary mb-0">
                                    You are successfully authenticated.
                                </p>
                            </div>

                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width:55px;height:55px;">
                                ✓
                            </div>

                        </div>


                        <hr>


                        <div class="row g-3 mt-2">

                            <div class="col-md-6">

                                <div class="p-3 bg-light rounded">

                                    <small class="text-secondary">
                                        Email
                                    </small>

                                    <div class="fw-semibold">
                                        {{ auth()->user()->email }}
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="p-3 bg-light rounded">

                                    <small class="text-secondary">
                                        Two-Factor Authentication
                                    </small>

                                    <div class="fw-semibold text-success">
                                        Verified ✓
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="alert alert-success mt-4 mb-0">

                            <strong>Security check passed.</strong>

                            Your email/password credentials and
                            six-digit verification code have both
                            been successfully verified.

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
