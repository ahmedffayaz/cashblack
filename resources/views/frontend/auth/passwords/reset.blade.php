@extends('frontend.layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="main-container p-lg-5 login-screen">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pe-0">
                    <div class="form-img text-end">
                        <img src="{{ asset('storage/__asset/img/login-img.jpg') }}" alt="Auth Image" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6 ps-0">
                    <div class="form-container h-100 d-flex align-items-center">
                        <div class="inner-container w-100">
                            <div class="form-title mb-4">
                                <h4>Reset New Password</h4>
                            </div>
                            <div class="form">

                                @if (count($errors) > 0)
                                    <div class="messageBox mt-4">
                                        <div class="alert alert-danger alert-dismissible">
                                            <span class="messageTextError">
                                                <ul>
                                                    @foreach ($errors->all() as $message)
                                                        <li>{{ $message }}</li>
                                                    @endforeach
                                                </ul>
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="messageBox mt-4">
                                        <div class="alert alert-success alert-dismissible">
                                            <span class="messageTextSuccess">{{ session('status') }}</span>
                                        </div>
                                    </div>
                                @endif

                                <form method="post" autocomplete="off" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="row">
                                        <div class="col-12 mb-2">
                                            <input type="email" class="form-control icon mail-icon" name="email" id="email" aria-label="Email Address" autocomplete="off"
                                                data-msg-required="Please enter your login email" required placeholder="Your Email Address" value="{{ $email ?? old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="form-row">
                                                <div class="input-group-append">
                                                    <i class="fas fa-eye icon-style toggle-password" data-target="#password"></i>
                                                </div>
                                                <input type="password" class="form-control icon password-icon eye-icon" name="password" id="password" aria-label="Password" autocomplete="off"
                                                data-msg-required="Please enter your new password" required placeholder="Your Password">
                                                @error('password')
                                                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 mb-4">
                                            <div class="form-row">
                                                <div class="input-group-append">
                                                    <i class="fas fa-eye icon-style toggle-password" data-target="#confirm"></i>
                                                </div>
                                                <input type="password" class="form-control icon password-icon" name="password_confirmation" id="confirm"
                                                    aria-label="Confirm Password" autocomplete="off" data-msg-required="Please enter confirm password" required
                                                    placeholder="Confirm Password">
                                                @error('password_confirmation')
                                                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2 {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            {!! app('captcha')->display() !!}
                                            @error('g-recaptcha-response')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="cta text-center d-grid">
                                        <button class="btn btn-primary btn-lg rounded-pill text-uppercase">Reset Password</button>
                                    </div>

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
