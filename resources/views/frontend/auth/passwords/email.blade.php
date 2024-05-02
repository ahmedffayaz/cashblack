@extends('frontend.layouts.app')

@section('title', 'Forgot Password')

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
                                <h4>Forgot Password?</h4>
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

                                <form method="post" autocomplete="off" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <input type="email" class="form-control icon mail-icon" name="email" id="email" aria-label="Email Address" autocomplete="off"
                                                data-msg-required="Please enter your login email" required="required" placeholder="Your Email Address">
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                                            @enderror
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
@endpush
