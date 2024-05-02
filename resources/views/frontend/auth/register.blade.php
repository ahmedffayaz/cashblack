@extends('frontend.layouts.app')

@section('title', 'Register')

@section('content')
    <div class="main-container p-md-5 login-screen">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pe-md-0">
                    <div class="form-img text-end">
                        <img src="{{ asset('storage/__asset/img/signup-img.jpg') }}" alt="Register Image" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6 ps-0">
                    <div class="form-container">
                        <div class="inner-container">
                            <div class="form-title mb-4">
                                <h4>Join Cashblack for Free</h4>
                            </div>
                            <div class="form">
                                <form class="register_form" method="post" action="{{ route('register') }}">
                                    @csrf
                                    <input type="hidden" name="referral_code" value="{{ $refCode }}">
                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <input type="text" class="form-control icon user-icon" name="firstname" id="firstname" aria-label="First Name"
                                                value="{{ old('firstname') }}" data-msg-required="Please enter your first name" required="required" placeholder="First Name"
                                                aria-invalid="false">
                                            @error('firstname')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-2">
                                            <input type="text" class="form-control icon user-icon" name="lastname" id="lastname" aria-label="Last Name"
                                                value="{{ old('lastname') }}" data-msg-required="Please enter your last name" required="required" placeholder="Last Name"
                                                aria-invalid="false">
                                            @error('lastname')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-2">
                                            <input type="email" class="form-control icon mail-icon" name="email" id="email" aria-label="Email Address"
                                                value="{{ old('email') }}" data-msg-required="Please enter your email address" required="required" placeholder="Email Address"
                                                aria-invalid="false">
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="form-row">
                                                <div class="input-group-append">
                                                    <i class="far fa-eye icon-style toggle-password" data-target="#password"></i>
                                                </div>
                                                <input type="password" class="form-control icon password-icon eye-icon" name="password" id="password" placeholder="Password"
                                                    aria-label="password" autocomplete="off" data-msg-required="Please enter your password" required="required" minlength="8"
                                                    aria-invalid="false">
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="form-row">
                                                <div class="input-group-append">
                                                    <i class="far fa-eye icon-style toggle-password" style="margin-top: 22px !important " data-target="#confirm-password"></i>
                                                </div>
                                                <input type="password" class="form-control eye-icon icon password-icon" name="password_confirmation" id="confirm-password"
                                                    aria-label="confirm password" required="required" autocomplete="off" data-msg-required="Please enter confirm password"
                                                    data-msg-equalto="Repeat password did not match with your password" equalto="#password" placeholder="Confirm Password">
                                            </div>
                                        </div>

                                        <div class="col-12 mb-4">
                                            <input type="text" class="form-control icon user-icon" name="ref_code" id="ref_code" placeholder="Referral Code">
                                        </div>

                                        <div class="col-12 {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            {!! app('captcha')->display() !!}
                                            @error('g-recaptcha-response')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="cta text-center d-grid">
                                        <button class="btn btn-primary btn-lg rounded-pill text-uppercase">Sign Up</button>
                                    </div>

                                    <div class="messageBox mt-4"></div>

                                    <div class="row mt-4 pb-0">
                                        <div class="col">
                                            <label class="form-check-label" for="gridCheck">
                                                By joining, you agree to Cashblack's <a href="{{ url('pages/terms-conditions') }}">Terms</a> and <a
                                                    href="{{ url('pages/privacy-policy') }}">Privacy Policy</a>.
                                            </label>
                                        </div>
                                    </div>

                                    @if (isFacebookEnabled() || isGoogleEnabled())
                                        <div class="social-login-buttons mt-4">
                                            <h6>Join With Social Account</h6>
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

                                    <div class="signin-option mt-4">
                                        <h6>Already a member? <a href="{{ route('login') }}">Login Here</a></h6>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! NoCaptcha::renderJs() !!}
    <script>
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
    </script>
@endpush
