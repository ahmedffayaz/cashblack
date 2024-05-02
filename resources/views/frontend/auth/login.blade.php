@extends('frontend.layouts.app')

@section('title', 'Login')

@section('content')
    <div class="main-container p-lg-5 login-screen">
        <div class="container">

            <div class="row">
                <div class="col-md-6 pe-sm-0">
                    <div class="form-img text-end">
                        <img src="{{ asset('storage/__asset/img/login-img.jpg') }}" alt="Auth Image" class="img-fluid">
                    </div>

                </div>
                <div class="col-md-6 ps-sm-0">
                    <div class="form-container">
                        <div class="inner-container">
                            <div class="form-title mb-4">
                                <h4>Log in to Your Account</h4>
                            </div>
                            <div class="form">
                                <form method="POST" action="{{ route('login', ['prvUrl' => request('prvUrl')]) }}" class="form-validate">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <input id="email" type="email" name="email" class="form-control icon mail-icon" placeholder="Enter your email"
                                                value="{{ old('email') }}" required autofocus data-msg-required="The email field is required.">
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="form-row">
                                                <div class="input-group-append">
                                                    <i class="far fa-eye icon-style toggle-password login-icon-style" data-target="#password"></i>
                                                </div>
                                                <input type="password" class="form-control icon password-icon eye-icon" name="password" id="password" placeholder="Password"
                                                    aria-label="password" autocomplete="off" data-msg-required="The password field is required." required="required" minlength="8"
                                                    placeholder="Enter your password" aria-invalid="false">
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            {!! app('captcha')->display() !!}
                                            @error('g-recaptcha-response')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col">
                                            <div class="form-check">
                                                <label class="form-check-label" for="remember-me">
                                                    <input class="form-check-input" type="checkbox" id="remember-me">
                                                    <span class="checkmark">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col d-flex align-items-center justify-content-end">
                                            <p class="forgot-pass"><a href="{{ route('password.request') }}">Forgot Password?</a></p>
                                        </div>
                                    </div>

                                    <div class="cta text-center d-grid">
                                        <button class="btn btn-primary btn-lg rounded-pill text-uppercase">Log in</button>
                                    </div>

                                    <div class="messageBox mt-4"></div>

                                    <div class="signin-option mt-4">
                                        <h6>Not a member yet? <a href="{{ route('register') }}">Join for Free</a></h6>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if (isFacebookEnabled() || isGoogleEnabled())
                            <div class="social-login-buttons">
                                <h6>Login With Social Account</h6>
                                <div class="social-buttons ms-4">
                                    @if (isFacebookEnabled())
                                        <a href="{{ url('/login/facebook') }}">
                                            <img src="{{ asset('storage/__asset/img/fb-login-icon.png') }}" alt="Sign in with Facebook">
                                        </a>
                                    @endif
                                    @if (isGoogleEnabled())
                                        <a href="{{ url('/login/google') }}">
                                            <img src="{{ asset('storage/__asset/img/google-login-icon.png') }}" alt="Sign in with Google" class="ms-2">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! NoCaptcha::renderJs() !!}
    <script>
        $(document).ready(function() {
            function togglePasswordVisibility() {
            var target = $($(this).data('target'));
            var fieldType = target.attr('type');

            if (fieldType === 'password') {
                target.attr('type', 'text');
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                target.attr('type', 'password');
                $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }

        $(document).ready(function() {
            $('.toggle-password').click(togglePasswordVisibility);
        });
        });
    </script>
@endpush
