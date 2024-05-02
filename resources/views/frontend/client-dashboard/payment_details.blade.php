@extends('frontend.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <style>
        .category-listing .list-item {
            display: block;
        }
    </style>
@endpush

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

                @include('frontend.client-dashboard.side-menu', ['page' => 'payment-details'])

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
                        <h4 class="section-title">Cashout Method</h4>
                        <p class="section-para mt-2">
                            Add your bank or PayPal account details below where they will be stored securely and Request a Cashout from the Dashboard to withdraw your earned cashback. You can amend your details at any time but please allow 48 hours for security reasons before we can process your payment.
                        </p>
                        <p class="section-para">
                            You can amend your details at any time but please allow 48 hours for security reasons before we can process your payment.
                        </p>
                    </div>

                    @include('flash::message')

                    <ul class="category-listing store-listing list-view">
                        <li class="list-item li-items">
                            <form class="form-validate bank-form" method="post" action="{{ route('account.payment_save') }}" novalidate="novalidate">
                                @csrf

                                <input type="hidden" name="payment_method" value="bank">

                                <h5 class="mb-4">Bank Transfer</h5>

                                <div class="row">
                                    <div class="col-6 mb-2">
                                        <label for="account_name"> <p class="required">*</p> Account Holder Name</label>
                                        <input type="text" class="form-control icon mail-icon valid" name="account_name" id="account_name" placeholder="Account Holder Name"
                                            value="{{ auth()->user()->bankInfo->account_name ?? '' }}">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label for="account_number"> <p class="required">*</p> Account Number</label>
                                        <input type="number" min="0" step="1" class="form-control icon password-icon valid mask-input" data-mask="" data-org="" name="account_number"
                                            id="account_number" placeholder="Account Number"
                                            value="{{ old('account_number') ?? (auth()->user()->bankInfo->account_number ?? '') }}">
                                    </div>
                                    <div class="col-6 mb-2">
                                        <label for="bank_sort_code"> <p class="required">*</p> Sort Code</label>
                                        <input type="number" min="0" step="1" class="form-control icon password-icon valid mask-input" data-mask="" data-org="" name="bank_sort_code"
                                            id="bank_sort_code" placeholder="Sort Code"
                                            value="{{ old('bank_sort_code') ?? (auth()->user()->bankInfo->bank_sort_code ?? '') }}">
                                    </div>
                                </div>

                                <div class="cta text-center d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill text-uppercase">Save</button>
                                </div>
                            </form>
                        </li>

                        <li class="list-item li-items">
                            <form class="form-validate paypal-form" method="post" action="{{ route('account.payment_save') }}" novalidate="novalidate">
                                @csrf

                                <input type="hidden" name="payment_method" value="paypal">

                                <h5 class="mb-4">PayPal</h5>

                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <label for="paypal_email"><p style="display: inline;">PayPal</p> Email</label>
                                        <input type="text" class="form-control icon mail-icon valid" name="paypal_email" id="paypal_email" placeholder="PayPal Email"
                                            value="{{ auth()->user()->paypalInfo->paypal_email ?? '' }}" aria-invalid="false" aria-label="PayPal Email">
                                    </div>
                                </div>

                                <div class="cta text-center d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill text-uppercase">Save</button>
                                </div>
                            </form>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

        });

        jQuery.validator.addMethod("account_name_regex", function(value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/i.test(value);
        }, "Only letters and spaces are allowed");

        jQuery.validator.addMethod("account_number_regex", function (value, element){
            return this.optional(element) || /^.{8}$/i.test(value);
        }, "Only numbers of 8 integers allowed");

        jQuery.validator.addMethod("bank_sort_code_regex", function (value, element){
            return this.optional(element) || /^.{6}$/i.test(value);
        }, "Only numbers of 6 integers allowed");

        jQuery.validator.addMethod("paypal_email_regex", function (value, element){
            return this.optional(element) ||/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
        }, "Please Enter Valid Email Address");
        
        $(".bank-form").validate({
            rules: {
                account_name: {
                    required: true,
                    account_name_regex: true
                },
                account_number: {
                    required: true,
                    account_number_regex: true
                },
                bank_sort_code: {
                    required: true,
                    bank_sort_code_regex: true
                }
            },
        });

        $(".paypal-form").validate({
            rules: {
                paypal_email: {
                    required: true,
                    paypal_email_regex: true
                }
            },
        });
    </script>
@endpush
