@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="page-header">
            <div class="icon-wrap">
                <img src="{{ asset('storage/__asset/img/dashboard-icons/dashboard.png') }}" alt="dashboard-icon">
            </div>
            <div class="title-wrap">
                <h1 class="page-title">My Account</h1>
            </div>
        </div>

        <div class="dashboard__content-area">
            <div class="row">

                @include('frontend.client-dashboard.side-menu', ['page' => 'password'])

                <div class="col main-content">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary d-none mb-3">
                        <svg class="svg-inline--fa fa-align-left fa-w-14 pe-1" aria-hidden="true" data-prefix="fa" data-icon="align-left" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M288 44v40c0 8.837-7.163 16-16 16H16c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h256c8.837 0 16 7.163 16 
                                16zM0 172v40c0 8.837 7.163 16 16 16h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 
                                16zm16 312h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 
                                16zm256-200H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h256c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z">
                            </path>
                        </svg>
                        Menu
                    </button>

                    <div class="section-title-wrap">
                        <h4 class="section-title">Change Password</h4>
                        <p class="section-para">On this page, you can update your account's password.</p>
                    </div>

                    @include('flash::message')

                    <form action="{{ route('account.save_password') }}" method="post" novalidate="novalidate">
                        @csrf
                        <div class="row">
                            <div class="col-12 mt-3 form-group">
                                <div class="input-group-append">
                                    <i class="far fa-eye dashboard__icon-style toggle-password" data-target="#current_password"></i>
                                </div>
                                    <input type="password" required placeholder="Your current password" data-msg-required="Please enter your current password"
                                    class="form-control eye-icon adorment" id="old_password" name="old_password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3 form-group">
                                <div class="input-group-append">
                                    <i class="far fa-eye dashboard__icon-style toggle-password" data-target="#new_password"></i>
                                </div>
                                <input type="password" required placeholder="Your new password" data-msg-required="Please enter your  new password" class="form-control eye-icon adorment"
                                    id="password" name="password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3 form-group">
                                <div class="input-group-append">
                                    <i class="far fa-eye dashboard__icon-style toggle-password" data-target="#repeat_password"></i>
                                </div>
                                <input type="password" required placeholder="Repeat password" data-msg-required="Please enter repeat password" class="form-control eye-icon adorment"
                                    id="password_confirmation" name="password_confirmation" data-msg-equalto="Repeat password did not match with your password"
                                    equalto="#password">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-4 form-group">
                                <button type="submit" class="btn btn-primary text-uppercase">Change Password</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function togglePasswordVisibility() {
            var target = $(this).closest('.form-group').find('input[type="password"], input[type="text"]');
            if (target.length === 1) {
                var fieldType = target.prop('type');
                console.log(fieldType);
                if (fieldType === 'password') {
                    target.prop('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    target.prop('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            }
        }
        $(document).ready(function() {
            $(".toggle-password").click(togglePasswordVisibility);
        });
    </script>
@endpush
