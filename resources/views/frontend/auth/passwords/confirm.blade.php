@extends('frontend.layouts.app')

@section('title', 'Confirm Your Password')

@section('content')
    <div class="main-container p-lg-5 login-screen">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pe-0">
                    <div class="form-img text-end">
                        <img src="{{ asset('storage/__asset/img/login-img.jpg') }}" alt="Auth Image" class="fluid-img">
                    </div>
                </div>
                <div class="col-md-6 ps-0">
                    <div class="form-container h-100 d-flex align-items-center">
                        <div class="inner-container w-100">
                            <div class="form-title mb-4">
                                <h4>Confirm Your Password</h4>
                                <p>Please confirm your password before continuing.</p>
                            </div>
                            <div class="form">
                                <form method="post" autocomplete="off" action="{{ route('password.confirm') }}">
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <input type="password" class="form-control icon password-icon" name="password" id="password" aria-label="Password" autocomplete="off"
                                                data-msg-required="Please enter your new password" required placeholder="Your Password">
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="cta text-center d-grid">
                                        <button class="btn btn-primary btn-lg rounded-pill text-uppercase">Confirm Password</button>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <div class="signin-option mt-4">
                                            <h6>Forgot Your Password? <a href="{{ route('password.request') }}">Reset Password.</a></h6>
                                        </div>
                                    @endif

                                    <div class="messageBox mt-4"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
